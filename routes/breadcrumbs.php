<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\Category;
use App\Models\Event;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Events
Breadcrumbs::for('events', function (BreadcrumbTrail $trail) {
    $trail->push('Events', '/dashboard/events');
});

// Events > Organize Event
Breadcrumbs::for('addEvent', function (BreadcrumbTrail $trail) {
    $trail->parent('events');
    $trail->push('Organize Event', '/dashboard/events/addEvent');
});

// Events > Edit Event
Breadcrumbs::for('editEvent', function (BreadcrumbTrail $trail, Event $event) {
    $trail->parent('events');
    $trail->push('Edit Event: '. $event->name, '/dashboard/events/editEvent/'. $event->id );
});

// Inventory
Breadcrumbs::for('inventory', function (BreadcrumbTrail $trail) {
    $trail->push('Inventory', '/dashboard/inventory');
});

// Inventory > Add Product
Breadcrumbs::for('addItem', function (BreadcrumbTrail $trail) {
    $trail->parent('inventory');
    $trail->push('Add Product', '/dashboard/inventory/addItem');
});

// Inventory > Edit Product
Breadcrumbs::for('editItem', function (BreadcrumbTrail $trail, Inventory $product) {
    $trail->parent('inventory');
    $trail->push('Edit Product: '. $product->name, '/dashboard/inventory/updateItem/'. $product->id );
});

// Users
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->push('Users', '/dashboard/users');
});

// Users > Add User
Breadcrumbs::for('addUser', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Add User', '/dashboard/users/addUser');
});

// User > Edit User
Breadcrumbs::for('editUser', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push('Edit User: '. $user->name, '/dashboard/users/updateUser/'. $user->uuid );
});

// Categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->push('Categories', '/dashboard/categories');
});

// Categories > Add Category
Breadcrumbs::for('addCategory', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Add Category', '/dashboard/categories/addCategory');
});

// Categories > Edit Category
Breadcrumbs::for('editCategory', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('categories');
    $trail->push('Edit Category: '. $category->name, '/dashboard/categories/updateCategory/'. $category->id );
});

// Locations
Breadcrumbs::for('locations', function (BreadcrumbTrail $trail) {
    $trail->push('Our Locations', '/dashboard/locations');
});

// Location > Add Location
Breadcrumbs::for('addLocation', function (BreadcrumbTrail $trail) {
    $trail->parent('locations');
    $trail->push('Add Location', '/dashboard/locations/addLocation');
});

// Locations > Edit Location
Breadcrumbs::for('editLocation', function (BreadcrumbTrail $trail, Location $location) {
    $trail->parent('locations');
    $trail->push('Edit Location: '. $location->name, '/dashboard/location/updateLocation/'. $location->id );
});

// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->push('Account Settings', '/dashboard/settings');
});

// Locations > Edit Location
Breadcrumbs::for('editSettings', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push('Edit Settings', '/dashboard/settings/update/');
});