<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactInfo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'name',
        'email',
        'address',
    ];

    public function chairmanAssociations(): HasMany
    {
        return $this->hasMany(RegionalAssociation::class, 'chairman_contact_id');
    }

    public function treasurerAssociations(): HasMany
    {
        return $this->hasMany(RegionalAssociation::class, 'treasurer_contact_id');
    }
}
