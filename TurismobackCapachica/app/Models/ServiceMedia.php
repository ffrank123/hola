<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceMedia extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'url', 'type', 'order_column'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
