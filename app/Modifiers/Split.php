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
        $groups_name = Arr::get($params, 1, 'groups');
        $items_name = Arr::get($params, 2, 'items');

        return collect($value)
            ->split($size)
            ->map(function ($collection) use ($groups_name, $items_name) {
                return [
                    $groups_name => [
                        $items_name => $collection->all(),
                    ],
                ];
            })->all();
    }
}
