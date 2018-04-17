<?php

namespace App\Optymous\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends EntityPolicy {
    use HandlesAuthorization;

    public function getEntityName() {
        return 'User';
    }
}
