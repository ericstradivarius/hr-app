<?php namespace App\Optymous\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {
    protected $availableIncludes = ["files"];

    public function transform($data) {
        return [
            "id" => $data["id"],
            "created_at" => $data["created_at"],
            "updated_at" => $data["updated_at"],
			"name" => $data["name"],
			"email" => $data["email"]
        ];
    }

    public function includeFiles($data) {
        return isset($data['files']) ? $this->collection($data['files'], new FileTransformer()) : null;
    }
}