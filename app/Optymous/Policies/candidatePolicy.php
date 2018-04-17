<?php

namespace App\Optymous\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class candidatePolicy extends EntityPolicy {
    use HandlesAuthorization;

    public function getEntityName() {
        return 'candidate';
    }
}
