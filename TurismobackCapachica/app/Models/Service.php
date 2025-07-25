<?php

// app/Models/Service.php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// modelo trait para auditar
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Service extends Model implements Auditable
{
  use AuditableTrait, HasFactory;

  protected $fillable = [
    'company_id',
    'category_id',
    'location_id',
    'title',
    'slug',
    'description',
    'ubicacion_detallada',     // Nuevo campo para la ubicación detallada
    'price',
    'policy_cancellation',
    'capacity',
    'duration',
    'status',
    'published_at',
    'is_active',
  ];

  public function company()
  {
    return $this->belongsTo(Company::class);
  }
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  public function zone()
  {
    return $this->belongsTo(Location::class, 'location_id');
  }
  public function media()
  {
    return $this->hasMany(ServiceMedia::class);
  }
  public function reservations()
  {
    return $this->hasManyThrough(
      Booking::class,        // Modelo final que queremos (reserva)
      BookingItem::class,    // Tabla intermedia
      'service_id',          // Clave foránea en booking_items que apunta a services
      'id',                  // Clave foránea en bookings
      'id',                  // Clave primaria en services
      'booking_id'           // Clave foránea en booking_items que apunta a bookings
    );
  }
  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  public function promotions()
  {
    return $this->belongsToMany(Promotion::class, 'promotion_service')
      ->withTimestamps();
  }

  // Itinerarios polimórficos
  public function itineraries()
  {
    return $this->morphMany(Itinerary::class, 'itineraryable')
      ->orderBy('day_number')
      ->orderBy('start_time');
  }
}
