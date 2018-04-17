<?php namespace App\Optymous\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UserTypeTransformer extends TransformerAbstract {
    protected $availableIncludes = ["userPermissions"];

    public function transform($data) {
        return [
            "id" => $data["id"],
            "created_at" => $data["created_at"],
            "updated_at" => $data["updated_at"],
			"name" => $data["name"]
        ];
    }


	public function includeUserPermissions($data) {
		return isset($data['userPermissions']) ? $this->collection($data['userPermissions'], new UserPermissionTransformer()) : null;
	}
}