<?php

namespace App\Optymous\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy extends EntityPolicy {
    use HandlesAuthorization;

    public function getEntityName() {
        return 'File';
    }
}
