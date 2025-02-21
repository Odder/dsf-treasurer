<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'invoice_number',
        'participants',
        'non_paying_participants',
        'amount',
        'status',
        'recipient_id',
        'competition_id',
        'association_id',
        'due_at',
        'sent_at',
    ];
    protected $casts = [
        'sent_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(ContactInfo::class);
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function association(): BelongsTo
    {
        return $this->belongsTo(RegionalAssociation::class, 'association_id');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function stamp(): Invoice
    {
        $this->update([
            'invoice_number' => (Invoice::max('invoice_number') ?? 0) + 1,
            'sent_at' => now(),
            'due_at' => now()->addDays(30),
            'status' => 'unpaid',
        ]);

        return $this;
    }

    public function scopeByYear($query, $year)
    {
        return $query->whereHas('competition', function ($q) use ($year) {
            $q->whereYear('end_date', $year);
        });
    }

    public function scopePastDueAt($query)
    {
        return $query->whereNotNull('due_at')->where('due_at', '<', now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopeForCurrentUser(Builder $query)
    {
        $user = Auth::user();
        if (!$user) {
            return $query->where('id', null);
        }

        $regionalAssociations = $user->contact?->associations;

        if (!$regionalAssociations) {
            return $query->where('id', null);
        }

        if ($regionalAssociations->where('wcif_identifier', 'DSF')->isNotEmpty()) {
            return $query;
        }

        return $query->whereIn('association_id', $regionalAssociations->pluck('id'));
    }
}
