<?php

namespace App\Policies;

use App\Estimate;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Routing\Console\MiddlewareMakeCommand;

class EstimatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any estimates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the estimate.
     *
     * @param  \App\User  $user
     * @param  \App\Estimate  $estimate
     * @return mixed
     */
    public function view(User $user, Estimate $estimate)
    {
        //
    }

    /**
     * Determine whether the user can create estimates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the estimate.
     *
     * @param  \App\User  $user
     * @param  \App\Estimate  $estimate
     * @return mixed
     */
    public function update(User $user, Estimate $estimate)
    {
        
    }

    /**
     * Determine whether the user can delete the estimate.
     *
     * @param  \App\User  $user
     * @param  \App\Estimate  $estimate
     * @return mixed
     */
    public function delete(User $user, Estimate $estimate)
    {
        //
    }

    /**
     * Determine whether the user can restore the estimate.
     *
     * @param  \App\User  $user
     * @param  \App\Estimate  $estimate
     * @return mixed
     */
    public function restore(User $user, Estimate $estimate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the estimate.
     *
     * @param  \App\User  $user
     * @param  \App\Estimate  $estimate
     * @return mixed
     */
    public function forceDelete(User $user, Estimate $estimate)
    {
        //
    }
}
