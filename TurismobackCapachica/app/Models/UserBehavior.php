<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBehavior extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'last_seen_service_id', 'preferred_categories',
        'viewed_services', 'clicked_services', 'reserved_services'
    ];

    protected $casts = [
        'preferred_categories' => 'array',
        'viewed_services' => 'array',
        'clicked_services' => 'array',
        'reserved_services' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
