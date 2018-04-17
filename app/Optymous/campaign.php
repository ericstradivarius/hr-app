<?php

namespace App\Optymous;

use Illuminate\Database\Eloquent\Model;

class campaign extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		"name",
		"start_date",
		"end_date",
		"status",
		"available_jobs",
		"description",
        'candidates_total'
    ];



	public function candidates() {
		return $this->belongsToMany(candidate::class, "campaign_candidates_pivot", "campaign_id", "candidate_id", "id");
	}
    public function files() {
        return $this->belongsToMany(File::class, "campaign_files", "campaign_id", "file_id", "id")->withTimestamps();
    }
}
