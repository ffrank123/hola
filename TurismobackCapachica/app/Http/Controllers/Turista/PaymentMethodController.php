<?php

namespace App\Http\Controllers\Turista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod; // Asegúrate de tener este modelo
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
     public function index()
    {
        $methods = PaymentMethod::where('user_id', Auth::id())->get();

        // Enmascarar el número y ocultar CVV
        $methods->transform(function ($method) {
            $method->card_number = '**** **** **** ' . substr($method->card_number, -4);
            unset($method->cvv);
            return $method;
        });

        return $methods;
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_number'      => 'required|string|regex:/^\d{13,19}$/',
            'cardholder_name'  => 'required|string|max:255',
            'expiry_month'     => 'required|integer|min:1|max:12',
            'expiry_year'      => 'required|integer|min:' . date('Y'),
            'cvv'              => 'required|string|regex:/^\d{3,4}$/',
            'brand'            => 'nullable|string|max:50',
        ]);

        $paymentMethod = PaymentMethod::create([
            'user_id'         => Auth::id(),
            'card_number'     => $request->card_number,
            'cardholder_name' => $request->cardholder_name,
            'expiry_month'    => $request->expiry_month,
            'expiry_year'     => $request->expiry_year,
            'cvv'             => $request->cvv,
            'brand'           => $request->brand,
        ]);

        return response()->json([
            'message' => 'Método de pago agregado correctamente',
            'payment_method' => [
                'id'              => $paymentMethod->id,
                'card_number'     => '**** **** **** ' . substr($paymentMethod->card_number, -4),
                'cardholder_name' => $paymentMethod->cardholder_name,
                'expiry_month'    => $paymentMethod->expiry_month,
                'expiry_year'     => $paymentMethod->expiry_year,
                'brand'           => $paymentMethod->brand,
            ],
        ], 201);
    }




    
    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        return [
            'id'              => $paymentMethod->id,
            'card_number'     => '**** **** **** ' . substr($paymentMethod->card_number, -4),
            'cardholder_name' => $paymentMethod->cardholder_name,
            'expiry_month'    => $paymentMethod->expiry_month,
            'expiry_year'     => $paymentMethod->expiry_year,
            'brand'           => $paymentMethod->brand,
        ];
    }



    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'card_number'      => 'sometimes|string|regex:/^\d{13,19}$/',
            'cardholder_name'  => 'sometimes|string|max:255',
            'expiry_month'     => 'sometimes|integer|min:1|max:12',
            'expiry_year'      => 'sometimes|integer|min:' . date('Y'),
            'cvv'              => 'sometimes|string|regex:/^\d{3,4}$/',
            'brand'            => 'nullable|string|max:50',
        ]);

        $paymentMethod->update($request->all());

        return response()->json([
            'message' => 'Método de pago actualizado correctamente',
            'payment_method' => [
                'id'              => $paymentMethod->id,
                'card_number'     => '**** **** **** ' . substr($paymentMethod->card_number, -4),
                'cardholder_name' => $paymentMethod->cardholder_name,
                'expiry_month'    => $paymentMethod->expiry_month,
                'expiry_year'     => $paymentMethod->expiry_year,
                'brand'           => $paymentMethod->brand,
            ],
        ]);
    }
    
    public function destroy($id)
{
    $paymentMethod = PaymentMethod::findOrFail($id);

    if ($paymentMethod->user_id !== Auth::id()) {
        abort(403, 'No autorizado');
    }

    $paymentMethod->delete();

    return response()->json(['message' => 'Método de pago eliminado correctamente'], 200);
}

}
