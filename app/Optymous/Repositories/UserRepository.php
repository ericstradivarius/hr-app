<?php namespace App\Optymous\Repositories;

use App\Optymous\User;

class UserRepository extends Repository {
    function assignedModel() {
        return app(User::class);
    }
}