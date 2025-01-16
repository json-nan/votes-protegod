<?php

namespace App\Enums;

enum VoteStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
}
