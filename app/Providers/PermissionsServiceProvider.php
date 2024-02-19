<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Roles
        $roles = collect(['admin', 'manager', 'employee', 'user']);
        $roleInstances = collect();
        $roles->each(function ($role) use (&$roleInstances) {
            $roleInstances->put($role, Role::firstOrCreate(['name' => $role]));
        });

        // Permissions
        $permissions = collect([
            // Location permissions
            'add location', 'edit location', 'remove location',
            // Category permissions
            'add category', 'edit category', 'remove category',
            // Manager permissions
            'add manager', 'remove manager',
            // Employee permissions
            'add employee', 'remove employee',
            // Item permissions
            'add item', 'edit item', 'remove item',
            // Event permissions
            'add event', 'edit event', 'remove event',
            // Event item permissions
            'add event item', 'remove event item',
        ]);
        $permissionInstances = collect();
        $permissions->each(function ($permission) use (&$permissionInstances) {
            $permissionInstances->put($permission, Permission::firstOrCreate(['name' => $permission]));
        });

        $roleInstances['admin']->syncPermissions($permissionInstances);

        $roleInstances->except('admin', 'user')->each(function ($role) use ($permissionInstances) {
            $role->syncPermissions($permissionInstances->only([
                'add item', 'edit item', 'remove item', 
                'add event', 'edit event', 'remove event', 
                'add event item', 'remove event item'
            ]));
        });
    }
}
