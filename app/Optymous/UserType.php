<?php

namespace App\Optymous;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		"name",
    ];



	public function userPermissions() {
		return $this->hasMany(UserPermission::class, "user_type_id", "id");
	}
}
