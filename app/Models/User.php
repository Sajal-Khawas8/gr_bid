<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // protected $primaryKey = 'uuid';
    // protected $keyType = 'string';
    // public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        // Creating event to set UUID before creating a new user
        static::creating(function ($user) {
            $user->uuid = Uuid::uuid6();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'attachable', null, null, 'id');
    }

    public function locations()
    {
        return $this->hasMany(UserLocation::class, 'user_id', 'uuid');
    }

    public function items()
    {
        return $this->hasMany(Inventory::class, 'added_by', 'uuid');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'organized_by', 'uuid');
    }

    public function scopeFilter($query, array $filters)
    {
        // if (request('search')) {
        //     $query->where('name', 'like', '%' . request('search') . '%')
        //         ->orWhere('email', 'like', '%' . request('search') . '%');
        // }

        $query->when($filters['search'] ?? false,
            fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
            )
        );

        $query->when($filters['role'] ?? false,
            fn($query, $role) =>
            $query->where(fn($query) =>
                $query->whereHas('roles', fn($query) => $query->where('name', $role))
                ->orWhere('uuid', $role)
            )
        );
    }
}
