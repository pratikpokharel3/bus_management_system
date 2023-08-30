<?php

namespace App\Enums;

enum BusDepartureStatus: string
{
    case NOT_STARTED = 'not_started';
    case PENDING = 'pending';
    case ARRIVED = 'arrived';
    case CANCELLED = 'cancelled';
}
