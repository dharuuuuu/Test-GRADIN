<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'level',
    ];

    /**
     * Scope a query to only include couriers of a certain level.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|int $levels
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLevel($query, $levels)
    {
        return $query->whereIn('level', (array) $levels);
    }

    /**
     * Scope a query to search couriers by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }
}
