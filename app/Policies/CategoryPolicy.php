<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('List categories');
    }

    public function view(User $user, Category $category)
    {
        return $user->can('View category');
    }

    public function create(User $user)
    {
        return $user->can('Create category');
    }

    public function update(User $user, Category $category)
    {
        return $user->can('Update category');
    }

    public function delete(User $user, Category $category)
    {
        return $user->can('Delete category');
    }

    public function restore(User $user, Category $category)
    {
        //
    }

    public function forceDelete(User $user, Category $category)
    {
        //
    }
}