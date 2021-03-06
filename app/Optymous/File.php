<?php

namespace App\Optymous;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "path",
        "type",
        "entity",
        "purpose",
        "name"
    ];
}
