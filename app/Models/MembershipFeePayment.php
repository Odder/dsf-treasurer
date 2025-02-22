<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipFeePayment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'wca_id',
        'competition_id',
        'amount',
        'waived',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
