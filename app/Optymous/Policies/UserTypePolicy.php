<?php

namespace App\Optymous\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy extends EntityPolicy {
    use HandlesAuthorization;

    public function getEntityName() {
        return 'UserType';
    }
}
