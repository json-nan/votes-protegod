<?php

declare(strict_types=1);

namespace App\Enums;

enum ContentType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case VIDEO = 'video';
} 