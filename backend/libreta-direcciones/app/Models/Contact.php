<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'birthday',
        'website',
        'company',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
