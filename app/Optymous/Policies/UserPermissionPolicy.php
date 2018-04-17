<?php

namespace App\Optymous\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPermissionPolicy extends EntityPolicy {
    use HandlesAuthorization;

    public function getEntityName() {
        return 'UserPermission';
    }
}
