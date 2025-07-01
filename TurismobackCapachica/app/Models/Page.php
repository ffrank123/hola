<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'portal_id', 'slug', 'title', 'content',
        'language', 'published_at'
    ];

    public function portal()
    {
        return $this->belongsTo(Portal::class);
    }
}
