<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "inventory";
    protected $guarded = ["id", "deleted_at", "created_at", "updated_at"];
    protected $casts = [
        "bid" => "decimal:2"
    ];

    public function setNameAttribute(string $name)
    {
        $this->attributes["name"] = ucwords($name);
    }

    public function setDescriptionAttribute(string $description)
    {
        $this->attributes["description"] = ucfirst($description);
    }

    public function getConditionAttribute(string $condtion)
    {
        return ucfirst($condtion);
    }

    // public function getStartingBidAttribute(float $bid)
    // {
    //     return number_format($bid, 2);
    // }

    public function images()
    {
        return $this->morphMany(Image::class, "attachable");
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, "added_by", "uuid");
    }

    public function event()
    {
        return $this->hasOne(EventItem::class, "product_id");
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false,
            fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('name', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['category'] ?? false,
            fn($query, $category) =>
            $query->where(function ($query) use ($category) {
                $category = array_filter($category, function ($v){
                    return !is_null($v);
                });
                if (!empty($category)) {
                    $query->where('category', $category[0]);
                    unset($category[0]);
                }
                foreach ($category as $c) {
                    $query->orWhere('category', $c);
                }
            })
        );

        $query->when($filters['condition'] ?? false,
            fn($query, $condition) =>
            $query->where(fn($query) =>
                $query->where('condition', $condition)
            )
        );

        $query->when($filters['location'] ?? false,
            fn($query, $locations) =>
            $query->where(function ($query) use ($locations) {
                $locations = array_filter($locations, function ($v){
                    return !is_null($v);
                });
                if (!empty($locations)) {
                    $query->where('location', $locations[0]);
                    unset($locations[0]);
                }
                foreach ($locations as $l) {
                    $query->orWhere('location', $l);
                }
            })
        );

        $query->when($filters['added_by'] ?? false,
            fn($query, $addedBy) =>
            $query->where(fn($query) =>
                $query->where('added_by', $addedBy)
            )
        );
    }
}
