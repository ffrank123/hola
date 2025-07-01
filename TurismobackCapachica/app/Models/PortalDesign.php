<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortalDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'portal_id', 'slider_images', 'colors', 'typography', 'sections', 
        'translations', 'status'
    ];

    protected $casts = [
        'slider_images' => 'array',
        'colors' => 'array',
        'typography' => 'array',
        'sections' => 'array',
        'translations' => 'array',
    ];

    public function portal()
    {
        return $this->belongsTo(Portal::class);
    }
}
