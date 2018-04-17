<?php namespace App\Optymous\Http\Transformers;

use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract {
    protected $availableIncludes = [];

    private $defaultOptions = [
        'or' => 'auto',
        'fit' => 'fill',
        'q' => 100
    ];

    public function transform($data) {
        $response = [
            "id" => $data["id"],
            "path" => $data["path"],
            "type" => $data["type"],
            "name" => $data["name"],
            "entity" => $data["entity"],
            "fullPath" => $this->downloadUrl($data["entity"], $data["path"])
        ];

        if($data["type"] == 'image') {
            $response['sizes'] = [
                "header" => $this->sizeUrl($data["entity"], $data["path"], [
                    'w' => 40,
                    'h' => 40,
                ]),
            ];
        }

        return $response;
    }

    public function sizeUrl($entity, $path, $options) {
        return asset('/images/' . $entity . '/' . $path . $this->getQuery($options));
    }

    public function downloadUrl($entity, $path) {
        return url('/download/' . rawurlencode($entity) . '/' . rawurlencode($path));
    }

    private function getQuery($options) {
        $q = [];
        $actualOptions = array_merge($options, $this->defaultOptions);

        foreach($actualOptions as $key => $value) {
            $q[] = $key . '=' . rawurlencode($value);
        }

        return empty($q) ? '' : '?' . implode('&', $q);
    }
}
