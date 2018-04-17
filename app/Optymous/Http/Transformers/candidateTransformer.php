<?php namespace App\Optymous\Http\Transformers;

use League\Fractal\TransformerAbstract;

class candidateTransformer extends TransformerAbstract {
    protected $availableIncludes = ["campaigns", "files"];

    public function transform($data) {
        return [
            "id" => $data["id"],
            "created_at" => $data["created_at"],
            "updated_at" => $data["updated_at"],
			"first_name" => $data["first_name"],
			"last_name" => $data["last_name"],
			"email" => $data["email"],
			"phone" => $data["phone"],
			"status" => $data["status"],
			"dob" => $data["dob"],
            "stage" => $data["stage"],
            "campaigns_total" => $data["campaigns_total"]
        ];
    }


	public function includecampaigns($data) {
		return isset($data['campaigns']) ? $this->collection($data['campaigns'], new campaignTransformer()) : null;
	}
    public function includeFiles($data) {
        return isset($data['files']) ? $this->collection($data['files'], new FileTransformer()) : null;
    }
}