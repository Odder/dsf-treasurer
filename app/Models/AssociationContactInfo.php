<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssociationContactInfo extends Pivot
{
    public function association(): BelongsTo
    {
        return $this->belongsTo(RegionalAssociation::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(ContactInfo::class);
    }
}
