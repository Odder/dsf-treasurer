<?php

namespace App\Models;

use App\Services\Wca\Wcif;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'wca_id',
        'name',
        'number_of_competitors',
        'start_date',
        'end_date',
        'wcif',
        'participants',
    ];

    public function getWcifAttribute()
    {
        return new Wcif($this->attributes['wcif']);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
