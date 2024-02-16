<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilters;

class NewsFilter extends ApiFilters
{
    // TODO: Title like search left to do
    protected $allowedParms = [
        'title' => ['eq', 'like'],
        'userId' => ['eq'],
        'status' => ['eq'],
        'createdAt' => ['eq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'createdAt' => 'created_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => "<",
        'lte' => "<=",
        'gt' => ">",
        'gte' => ">=",
        'ne' => "!=",
        'like' => 'like'
    ];
}
