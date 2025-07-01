<?php

namespace App\Http\Controllers\Turista;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Emprendedor\ServicioController; // Importa el controlador de servicios


class BookingController extends Controller
{
    // GET /api/turista/bookings
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('items.service', 'items.promotion')
            ->latest()
            ->paginate(10);

        return response()->json($bookings);
    }

    // GET /api/turista/bookings/{id}
    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with('items.service', 'items.promotion')
            ->findOrFail($id);

        return response()->json($booking);
    }

    // POST /api/turista/bookings/{id}/pay
public function pay(Request $request, $id)
{
    $request->validate([
        'payment_method_id' => 'required|exists:payment_methods,id',
    ]);

    $booking = Booking::where('user_id', Auth::id())
        ->with('items.service', 'items.promotion') // Traes relaciones necesarias
        ->findOrFail($id);

    if ($booking->status === 'completed') {
        return response()->json(['message' => 'Esta reserva ya ha sido pagada'], 409);
    }

    if ($booking->status !== 'confirmed') {
        return response()->json(['message' => 'Sólo se puede pagar un booking confirmado'], 422);
    }

    $paymentMethod = PaymentMethod::where('id', $request->payment_method_id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // Reducción de capacidad de servicios reservados
    foreach ($booking->items as $item) {
        if ($item->type === 'service') {
            $serviceController = new ServicioController();
            $serviceController->updateCapacityAndStatus($item->service_id, $item->quantity);
        }
    }

    // Simulación de cobro exitoso
    $booking->update([
        'status'  => 'completed',
        'paid_at' => now(),
    ]);

    // Registro en la tabla payments
    DB::table('payments')->insert([
        'booking_id'      => $booking->id,
        'user_id'         => Auth::id(),
        'method'          => 'tarjeta_guardada',
        'transaction_id'  => null,
        'amount'          => $booking->total_amount,
        'currency'        => 'USD',
        'status'          => 'paid',
        'paid_at'         => now(),
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);

    return response()->json([
        'message' => 'Pago realizado correctamente',
        'booking' => $booking->load('items.service', 'items.promotion'),
    ]);
}


}
