<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;
use Statamic\Support\Arr;

class Split extends Modifier
{
    private $context;

    /**
     * Break an array into a given number of groups.
     *
     * @param $value
     * @param $params
     * @return array
     */
    public function index($value, $params)
    {
        $size = Arr::get($params, 0, 1);

        return collect($value)
            ->split($size)
            ->map(function ($collection) {
                return [
                    'items' => $collection->all(),
                ];
            })->all();
    }
}
