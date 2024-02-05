<?php

namespace App\Enums;

enum ActivityType: string
{
    case Created = 'created';
    case Commented = 'commented';
    case Sent = 'sent';
    case Viewed = 'viewed';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Paid = 'paid';
}
