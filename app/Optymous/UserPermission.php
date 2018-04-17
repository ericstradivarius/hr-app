<?php

namespace App\Optymous;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		"entity",
		"label",
		"user_type_id",
		"user_type_id",
    ];



	public function userType() {
		return $this->belongsTo(UserType::class, "user_type_id", "id");
	}
}
