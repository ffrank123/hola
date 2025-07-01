<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'user_id', 'method', 'transaction_id',
        'amount', 'currency', 'status', 'paid_at'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
