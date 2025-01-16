<?php

namespace App\Enums;

enum ContentType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case TWITCH_CLIP = 'twitch-clip';
    case YOUTUBE_VIDEO = 'youtube-video';
}
