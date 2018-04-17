<?php namespace App\Optymous\Repositories;

use App\Optymous\UserType;

class UserTypeRepository extends Repository {
    function assignedModel() {
        return app(UserType::class);
    }
}