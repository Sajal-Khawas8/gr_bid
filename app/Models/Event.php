<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", "description", "start", "end", "venue", "cover", "organized_by"];

    protected $with=["items"];

    public function items()
    {
        return $this->hasManyThrough(Inventory::class, EventItem::class, "event_id", "id", "id", "product_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "organized_by", "uuid");
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false,
            fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('venue', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['organized_by'] ?? false,
            fn($query, $organizedBy) =>
            $query->where(fn($query) =>
                $query->where('organized_by', $organizedBy)
            )
        );

        $query->when($filters['start'] ?? false,
            fn($query, $start) =>
            $query->where(fn($query) =>
                $query->where('start', '>=', $start)
            )
        );

        $query->when($filters['end'] ?? false,
            fn($query, $end) =>
            $query->where(fn($query) =>
                $query->where('end', '<', $end)
            )
        );
    }
}
