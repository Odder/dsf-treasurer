<?php

namespace App\Enums;

enum AssociationRole: string
{
    case CHAIRMAN = 'chairman';
    case VICE_CHAIR = 'vice-chairman';
    case TREASURER = 'treasurer';
    case MEMBER = 'member';
    case ALTERNATE = 'alternate';
    case ACCOUNTANT = 'accountant';
}
