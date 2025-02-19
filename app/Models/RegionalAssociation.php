<?php

namespace App\Models;

use App\Enums\AssociationRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    public function competitions(): HasMany
    {
        return $this->hasMany(Competition::class);
    }

    public function getNumberOfCompetitionsAttribute()
    {
        return $this->competitions()->count();
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(ContactInfo::class, 'association_contact_info')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function treasurer(): BelongsToMany
    {
        return $this->members()->wherePivot('role', AssociationRole::TREASURER);
    }

    public function chairman(): BelongsToMany
    {
        return $this->members()->wherePivot('role', AssociationRole::CHAIRMAN);
    }

    public function viceChair(): BelongsToMany
    {
        return $this->members()->wherePivot('role', AssociationRole::VICE_CHAIR);
    }

    public function accountant(): BelongsToMany
    {
        return $this->members()->wherePivot('role', AssociationRole::ACCOUNTANT);
    }

    public function currentOutstanding(): float
    {
        return $this->invoices()
            ->where('status', 'unpaid')
            ->get()
            ->sum(function ($invoice) {
                return $invoice->amount;
            });

    }

    public function paidInvoices(): HasMany
    {
        return $this->invoices()->where('status', 'paid');
    }

    public function unpaidInvoices(): HasMany
    {
        return $this->invoices()->where('status', 'unpaid');
    }
}
