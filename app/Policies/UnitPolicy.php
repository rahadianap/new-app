<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('List units');
    }

    public function view(User $user, Unit $unit)
    {
        return $user->can('View unit');
    }

    public function create(User $user)
    {
        return $user->can('Create unit');
    }

    public function update(User $user, Unit $unit)
    {
        return $user->can('Update unit');
    }

    public function delete(User $user, Unit $unit)
    {
        return $user->can('Delete unit');
    }

    public function restore(User $user, Unit $unit)
    {
        //
    }

    public function forceDelete(User $user, Unit $unit)
    {
        //
    }
}