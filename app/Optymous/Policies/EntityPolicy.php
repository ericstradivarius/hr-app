<?php

namespace App\Optymous\Policies;

use App\Optymous\UserPermission;
use Illuminate\Database\Eloquent\Model;
use App\Optymous\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class EntityPolicy {
    use HandlesAuthorization;

    abstract function getEntityName();

    public function before($user, $ability) {
        if($user->type && $user->type->name === 'Admin') {
            return true;
        }
    }

    /**
     * Determine if the user can create a specific entity type.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user) {
        return $this->hasPermission($user, 'create');
    }

    /**
     * Determine if the user can read a specific entity or entity type.
     *
     * @param  User $user
     * @param  Model $model
     * @return bool
     */
    public function read(User $user, $model = null) {
        $access = $this->hasPermission($user, 'read');

        if($model !== null && $access && $model->user_id !== null) {
            $access = $access && $model->user_id === $user->id;
        }

        return $access;
    }

    /**
     * Determine if the given entity can be updated by the user.
     *
     * @param  User $user
     * @param  Model  $model
     * @return bool
     */
    public function update(User $user, Model $model) {
        $access = $this->hasPermission($user, 'update');

        if($access && $model->user_id !== null) {
            $access = $access && $model->user_id === $user->id;
        }

        return $access;
    }

    /**
     * Determine if the user can delete an entity.
     *
     * @param  User $user
     * @param  Model $model
     * @return bool
     */
    public function delete(User $user, Model $model) {
        $access = $this->hasPermission($user, 'delete');

        if($access && $model->user_id !== null) {
            $access = $access && $model->user_id === $user->id;
        }

        return $access;
    }

    protected function hasPermission(User $user, $label) {
        return !!UserPermission::where('entity', $this->getEntityName())->where('label', $label)->where('user_type_id', $user->user_type_id)->first();
    }
}
