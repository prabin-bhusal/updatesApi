<?php

namespace App\Filters\V1;

use App\Filters\ApiFilters;

class NoticeFilter extends ApiFilters
{
    protected $allowedParms = [
        'title' => ['like'],
        'content' => ['like'],
        'date' => ['eq', 'lt', 'lte', 'gt', 'gte'],
    ];
}
