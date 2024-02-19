<?php

namespace App\Policies;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventoryPolicy
{

    public function before(User $user, string $ability): bool|null
    {
        return $user->hasRole("admin") ? true : null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['add item', 'edit item', 'remove item']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inventory $product): bool
    {
        return $user->hasAnyPermission(['add item', 'edit item', 'remove item']) && $user->uuid === $product->added_by;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add item');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inventory $product): bool
    {
        return $user->hasPermissionTo('edit item') && $user->uuid === $product->added_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inventory $product): bool
    {
        return $user->hasPermissionTo('remove item') && $user->uuid === $product->added_by;
    }

}
