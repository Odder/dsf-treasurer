<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RegionalAssociation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'address',
        'wcif_identifier',
        'chairman_contact_id',
        'treasurer_contact_id',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'association_id');
    }

    public function chairman(): BelongsTo
    {
        return $this->belongsTo(ContactInfo::class, 'chairman_contact_id');
    }

    public function treasurer(): BelongsTo
    {
        return $this->belongsTo(ContactInfo::class, 'treasurer_contact_id');
    }
}
