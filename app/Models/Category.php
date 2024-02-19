<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function setNameAttribute(string $name)
    {
        $this->attributes["name"] = ucwords($name);
    }

    public function scopeFilter($query)
    {
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
    }

    public function items()
    {
        return $this->hasMany(Inventory::class, "category", "name");
    }
}
