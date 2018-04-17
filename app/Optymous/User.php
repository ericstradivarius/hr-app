<?php

namespace App\Optymous;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

	public function type() {
		return $this->hasOne(UserType::class, 'id', 'user_type_id');
	}

    public function files() {
        return $this->belongsToMany(File::class, "user_files", "user_id", "file_id", "id")->withTimestamps();
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',  'password', 'google2fa_secret', 'fa_enabled',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'google2fa_secret', 'fa_enabled', 'remember_token',
    ];
}
