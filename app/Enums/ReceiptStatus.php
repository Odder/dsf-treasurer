<?php

namespace App\Enums;

enum ReceiptStatus: string
{
    case REPORTED = 'reported';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case SETTLED = 'settled';
}
