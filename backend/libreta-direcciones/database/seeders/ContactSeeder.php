<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class ContactSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Crear 5000 contactos
        for ($i = 0; $i < 5000; $i++) {
            $contact = Contact::create([
                'name' => $faker->name,
                'notes' => $faker->text,
                'birthday' => $faker->date,
                'website' => $faker->url,
                'company' => $faker->company,
            ]);

            // Crear 1-3 teléfonos por contacto
            for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                Phone::create([
                    'contact_id' => $contact->id,
                    'number' => $faker->phoneNumber,
                    'type' => $faker->randomElement(['home', 'work', 'mobile']),
                ]);
            }

            // Crear 1-2 emails por contacto
            for ($j = 0; $j < $faker->numberBetween(1, 2); $j++) {
                Email::create([
                    'contact_id' => $contact->id,
                    'email' => $faker->email,
                ]);
            }

            // Crear 1-2 direcciones por contacto
            for ($j = 0; $j < $faker->numberBetween(1, 2); $j++) {
                Address::create([
                    'contact_id' => $contact->id,
                    'street' => $faker->streetAddress,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'zip_code' => $faker->postcode,
                ]);
            }
        }
    }
}
