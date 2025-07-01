<?php
// app/Http/Controllers/Emprendedor/CalendarController.php

namespace App\Http\Controllers\Emprendedor;

use App\Http\Controllers\Controller;
use App\Models\PersonalEvent;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:emprendedor');
    }

    // ✅ Fechas ocupadas por reservas de un servicio
    public function occupiedDates(Service $service)
    {
        // Validar que el servicio pertenezca a la empresa del usuario
        if ($service->company_id !== Auth::user()->company->id) {
            return response()->json(['error' => 'No autorizado'], Response::HTTP_FORBIDDEN);
        }

        // Estados que se consideran ocupados
        $blockedStatuses = ['pre_reservation', 'booked', 'paid', 'confirmed', 'completed'];

        // Obtener fechas ocupadas desde booking_items correctamente relacionados
        $dates = $service->reservations()
            ->whereIn('status', $blockedStatuses)
            ->pluck('reservation_date')
            ->unique()
            ->values();

        return response()->json($dates, Response::HTTP_OK);
    }

    // ✅ Listar eventos personales de la empresa
    public function personalEvents()
    {
        $events = PersonalEvent::where('company_id', Auth::user()->company->id)
            ->orderBy('start_time')
            ->get();

        return response()->json($events, Response::HTTP_OK);
    }

    // ✅ Crear evento personal
    public function createPersonalEvent(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'nullable|date|after_or_equal:start_time',
            'status'      => 'nullable|in:pendiente,reprogramado,completado'
        ]);

        $data['company_id'] = Auth::user()->company->id;
        $data['status'] = $data['status'] ?? 'pendiente';

        $event = PersonalEvent::create($data);

        return response()->json($event, Response::HTTP_CREATED);
    }

    // ✅ Actualizar evento personal
    public function updatePersonalEvent(Request $request, PersonalEvent $event)
    {
        if ($event->company_id !== Auth::user()->company->id) {
            return response()->json(['error' => 'No autorizado'], Response::HTTP_FORBIDDEN);
        }

        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'sometimes|required|date',
            'end_time'    => 'nullable|date|after_or_equal:start_time',
            'status'      => 'nullable|in:pendiente,reprogramado,completado'
        ]);

        $event->update($data);

        return response()->json($event, Response::HTTP_OK);
    }

    // ✅ Eliminar evento personal
    public function deletePersonalEvent(PersonalEvent $event)
    {
        if ($event->company_id !== Auth::user()->company->id) {
            return response()->json(['error' => 'No autorizado'], Response::HTTP_FORBIDDEN);
        }

        $event->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
