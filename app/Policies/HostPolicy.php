<?php

namespace App\Policies;

use App\User;
use App\Host;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the host model.
     *
     * @param  \App\User  $user
     * @param  \App\Host  $hostModel
     * @return mixed
     */
    public function view(User $user, Host $hostModel)
    {
        if ($hostModel->status == 1) {
            return $user->id === $hostModel->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create host models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the host model.
     *
     * @param  \App\User  $user
     * @param  \App\Host  $hostModel
     * @return mixed
     */
    public function update(User $user, Host $hostModel)
    {
        return $user->id === $hostModel->user_id;
    }

    /**
     * 主机Push操作
     * @param User $user
     * @param Host $host
     * @return bool
     */
    public function push(User $user,Host $host)
    {
        if ($host->status == 1){//正常才可以转移
            return $user->id === $host->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the host model.
     *
     * @param  \App\User  $user
     * @param  \App\Host  $hostModel
     * @return mixed
     */
    public function delete(User $user, Host $hostModel)
    {
        return $user->id === $hostModel->user_id;
    }

    /**
     * Determine whether the user can restore the host model.
     *
     * @param  \App\User  $user
     * @param  \App\Host  $hostModel
     * @return mixed
     */
    public function restore(User $user, Host $hostModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the host model.
     *
     * @param  \App\User  $user
     * @param  \App\Host  $hostModel
     * @return mixed
     */
    public function forceDelete(User $user, Host $hostModel)
    {
        //
    }
}
