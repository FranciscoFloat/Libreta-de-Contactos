<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');

        $contactsQuery = Contact::with(['phones', 'emails', 'addresses']);

        if ($search) {
            $contactsQuery->where('name', 'LIKE', "%$search%")
                ->orWhereHas('phones', function ($query) use ($search) {
                    $query->where('number', 'LIKE', "%$search%");
                })
                ->orWhereHas('emails', function ($query) use ($search) {
                    $query->where('email', 'LIKE', "%$search%");
                });
        }

        $contacts = $contactsQuery->paginate($perPage);

        return response()->json($contacts);
    }
    public function show(Contact $contact): JsonResponse
    {
        $contact->load(['phones', 'emails', 'addresses']);
        return response()->json($contact);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $contact = $this->createContact($request->validated());
            $this->addPhoneNumbers($contact, $request->phoneNumbers);
            $this->addEmails($contact, $request->emails);
            $this->addAddresses($contact, $request->addresses);

            DB::commit();

            return response()->json([
                'message' => 'Contact created successfully',
                'contact' => $contact->load(['phones', 'emails', 'addresses'])
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error creating contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        DB::beginTransaction();

        try {
            $contact->update($request->validated());

            $this->updatePhoneNumbers($contact, $request->phoneNumbers);
            $this->updateEmails($contact, $request->emails);
            $this->updateAddresses($contact, $request->addresses);

            DB::commit();

            return response()->json([
                'message' => 'Contact updated successfully',
                'contact' => $contact->fresh(['phones', 'emails', 'addresses'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error updating contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Contact $contact): JsonResponse
    {
        try {
            $contact->delete();
            return response()->json(['message' => 'Contact deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function createContact(array $data): Contact
    {
        return Contact::create($data);
    }

    private function addPhoneNumbers(Contact $contact, array $phoneNumbers): void
    {
        foreach ($phoneNumbers as $phoneNumber) {
            $contact->phones()->create($phoneNumber);
        }
    }

    private function addEmails(Contact $contact, array $emails): void
    {
        foreach ($emails as $email) {
            $contact->emails()->create($email);
        }
    }

    private function addAddresses(Contact $contact, array $addresses): void
    {
        foreach ($addresses as $address) {
            $contact->addresses()->create($address);
        }
    }

    private function updatePhoneNumbers(Contact $contact, array $phoneNumbers): void
    {
        $contact->phones()->delete();
        $this->addPhoneNumbers($contact, $phoneNumbers);
    }

    private function updateEmails(Contact $contact, array $emails): void
    {
        $contact->emails()->delete();
        $this->addEmails($contact, $emails);
    }

    private function updateAddresses(Contact $contact, array $addresses): void
    {
        $contact->addresses()->delete();
        $this->addAddresses($contact, $addresses);
    }
}
