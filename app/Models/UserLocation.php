<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'location_name'];

    public function users()
    {
        return $this->hasMany(User::class, 'uuid', 'user_id');
    }
}
