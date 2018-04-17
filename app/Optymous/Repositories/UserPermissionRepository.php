<?php namespace App\Optymous\Repositories;

use App\Optymous\UserPermission;

class UserPermissionRepository extends Repository {
    function assignedModel() {
        return app(UserPermission::class);
    }
}