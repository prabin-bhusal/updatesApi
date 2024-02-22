<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilters
{
    protected $allowedParms = [];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => "<",
        'lte' => "<=",
        'gt' => ">",
        'gte' => ">=",
        'like' => 'like'
    ];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->allowedParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;
            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    if ($operator == 'like') {
                        $query[$operator] = '%' . $query[$operator] . '%';
                    }

                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
