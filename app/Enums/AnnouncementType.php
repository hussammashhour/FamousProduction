<?php

namespace App\Enums;

enum AnnouncementType: string
{
    case INFO = 'info';
    case WARNING = 'warning';
    case UPDATE = 'update';
    case FEATURE = 'feature';
}
