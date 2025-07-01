<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'subdomain', 'default_language', 'logo_url',
        'primary_color', 'secondary_color', 'font_family', 'layout_template'
    ];

    public function design()
    {
        return $this->hasOne(PortalDesign::class);
    }
}
