<?php
// app/Models/Location.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
      'name','type',
      'descripcion_corta','descripcion_larga',
      'atractivos','habitantes',
      'estado','imagen','galeria',
    ];

    protected $casts = [
      'galeria' => 'array',
    ];

   public function companies()
{
    return $this->hasMany(Company::class, 'location_id');
}

}