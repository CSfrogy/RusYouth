<?php

namespace App\Enums;

enum PostCategory: string
{
    case NEWS = 'news';
    case EVENTS = 'events';
    case UPDATES = 'updates';
    case INTERVIEWS = 'interviews';

    public function getLabel(): string
    {
        return match($this) {
            PostCategory::NEWS => "News",
            PostCategory::EVENTS => "Events",
            PostCategory::UPDATES => "Updates",
            PostCategory::INTERVIEWS => "Interviews",

        };
    }
}
