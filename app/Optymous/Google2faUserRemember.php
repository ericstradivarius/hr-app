<?php

namespace App\Optymous;

use Illuminate\Database\Eloquent\Model;

class Google2faUserRemember extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "token"
    ];

    protected $table = 'google2fa_users_remembers';

    public function user() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
