<?php

namespace App\Optymous\Http\Transformers\Special;
use League\Fractal\TransformerAbstract;

class CountTransformer extends TransformerAbstract {

    public function transform($data) {
        return [
            'value' => $data['value'],
            'count' => intval($data['count'])
        ];
    }
}