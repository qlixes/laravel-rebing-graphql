<?php

namespace App\Traits;

trait ArrayTrait
{
    function array_filter(array $data, array $filter): array
    {
        return array_intersect_key($data, array_flip($filter));
    }
}
