<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('List suppliers');
    }

    public function view(User $user, Supplier $supplier)
    {
        return $user->can('View supplier');
    }

    public function create(User $user)
    {
        return $user->can('Create supplier');
    }

    public function update(User $user, Supplier $supplier)
    {
        return $user->can('Update supplier');
    }

    public function delete(User $user, Supplier $supplier)
    {
        return $user->can('Delete supplier');
    }

    public function restore(User $user, Supplier $supplier)
    {
        //
    }

    public function forceDelete(User $user, Supplier $supplier)
    {
        //
    }
}