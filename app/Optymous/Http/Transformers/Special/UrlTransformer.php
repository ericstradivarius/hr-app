<?php

namespace App\Optymous\Http\Transformers\Special;

use League\Fractal\TransformerAbstract;

class UrlTransformer extends TransformerAbstract {

    public function transform($data) {
        return [
            'url' => $data['url'] ? asset($data['url']) : ''
        ];
    }
}