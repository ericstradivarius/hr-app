<?php

namespace App\Optymous\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class campaignPolicy extends EntityPolicy {
    use HandlesAuthorization;

    public function getEntityName() {
        return 'campaign';
    }
}
