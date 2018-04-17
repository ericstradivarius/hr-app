<?php namespace App\Optymous\Http\Transformers\Core;

use League\Fractal\Serializer\ArraySerializer;

class Serializer extends ArraySerializer {
    public function collection($resourceKey, array $data) {
        return $data;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data) {
        if(empty($data)) {
            return null;
        }

        return parent::item($resourceKey, $data);
    }
}