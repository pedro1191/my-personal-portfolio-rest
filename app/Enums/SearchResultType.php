<?php

namespace App\Enums;

enum SearchResultType: string
{
    case All = 'all';
    case Paginated = 'paginated';

    public static function csv(): string
    {
        return implode(',', array_column(self::cases(), 'value'));
    }
}
