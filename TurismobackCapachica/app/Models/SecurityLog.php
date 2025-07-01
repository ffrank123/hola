<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;  // IMPORTANTE agregar
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event',
        'ip_address',
        'user_agent',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
