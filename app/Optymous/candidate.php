<?php

namespace App\Optymous;

use Illuminate\Database\Eloquent\Model;

class candidate extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		"first_name",
		"last_name",
		"email",
		"phone",
		"status",
		"dob",
        "stage",
        "campaigns_total"
    ];



	public function campaigns() {
		return $this->belongsToMany(campaign::class, "campaign_candidates_pivot", "candidate_id", "campaign_id", "id");
	}

    public function files() {
        return $this->belongsToMany(File::class, "candidate_files", "candidate_id", "file_id", "id")->withTimestamps();
    }

}
