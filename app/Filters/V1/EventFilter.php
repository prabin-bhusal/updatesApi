<?php

namespace App\Filters\V1;

use App\Filters\ApiFilters;

class EventFilter extends ApiFilters
{
    protected $allowedParms = [
        'title' => ['like'],
        'content' => ['like'],
        'venue' => ['like'],
        'start_date' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'end_date' => ['eq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        'startDate' => 'start_date',
        'endDate' => 'end_date'
    ];
}
