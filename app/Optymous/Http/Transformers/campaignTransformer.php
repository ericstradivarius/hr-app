<?php namespace App\Optymous\Http\Transformers;

use League\Fractal\TransformerAbstract;

class campaignTransformer extends TransformerAbstract {
    protected $availableIncludes = ["candidates"];

    public function transform($data) {
        return [
            "id" => $data["id"],
            "created_at" => $data["created_at"],
            "updated_at" => $data["updated_at"],
			"name" => $data["name"],
			"start_date" => $data["start_date"],
			"end_date" => $data["end_date"],
			"status" => $data["status"],
			"available_jobs" => $data["available_jobs"],
			"description" => $data["description"],
            'candidates_total' => $data['candidates_total']
        ];
    }


	public function includecandidates($data) {
		return isset($data['candidates']) ? $this->collection($data['candidates'], new candidateTransformer()) : null;
	}
}