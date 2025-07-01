<?php

namespace App\Http\Controllers\Emprendedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\ServiceMedia;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:emprendedor']);
    }

    /**
     * 1️⃣ Listar servicios del emprendedor
     */
     /** 1️⃣ Listar */
     public function index()
     {
         $services = Service::whereHas('company', fn($q)=> $q->where('user_id', Auth::id()))
             ->with([
                 'media',
                 'category',
                 'zone',
                 'promotions'  => fn($q)=> $q->active(),
                 'itineraries'
             ])
             ->latest()
             ->get();
 
         return response()->json($services);
     }


    /**
     * 2️⃣ Crear un servicio + subir fotos
     *    POST /api/emprendedor/servicios
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'               => 'required|string|max:255',   
            'description'         => 'required|string',
            'ubicacion_detallada' => 'nullable|string|max:255',
            'price'               => 'required|numeric|min:0',
            'capacity'            => 'nullable|integer|min:1',
            'duration'            => 'nullable|string|max:100',
            'policy_cancellation' => 'nullable|string',
            'category_id'         => 'required|exists:categories,id',
            'location_id'         => 'required|exists:locations,id',
           
            // fotos iniciales (opcional)
            'photos.*'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        $company = Auth::user()->company;
        if (!$company || $company->status !== 'aprobada') {
            return response()->json(['message' => 'Empresa no aprobada'], 403);
        }

         // Si la capacidad es 0, marcar el servicio como pausado
        if ($data['capacity'] <= 0) {
            $data['status'] = 'paused';  // o 'inactive'
        }


        // preparar campos extra
        $data['slug']         = Str::slug($data['title']) . '-' . uniqid();
        $data['status']       = 'active';
        $data['published_at'] = now();

        
        // crear servicio
        $service = $company->services()->create($data);

        // subir fotos iniciales
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $idx => $file) {
                $path = $file->store("services/{$service->id}", 'public');
                ServiceMedia::create([
                    'service_id'   => $service->id,
                    'url'          => Storage::url($path),
                    'type'         => 'image',
                    'order_column' => $idx,
                ]);
            }
        }

        $service->load(['media','category','zone',  'promotions'  => fn($q)=> $q->active(),
        'itineraries']);

        return response()->json([
            'message' => 'Servicio creado exitosamente.',
            'service' => $service
        ], 201);
    }

    /**
     * 3️⃣ Mostrar detalle de un servicio propio
     *    GET /api/emprendedor/servicios/{id}
     */
     /** 3️⃣ Mostrar detalle */
     public function show($id)
     {
         $service = Service::with([
                 'media',
                 'category',
                 'zone',
                 'promotions'  => fn($q)=> $q->active(),
                 'itineraries'
             ])
             ->findOrFail($id);
 
         if ($service->company->user_id !== Auth::id()) {
             return response()->json(['message'=>'No autorizado'], 403);
         }
 
         return response()->json($service);
     }
 

    /**
     * 4️⃣ Actualizar solo campos simples (sin fotos)
     *    PATCH /api/emprendedor/servicios/{id}
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title'               => 'sometimes|required|string|max:255',
            'description'         => 'sometimes|required|string',
            'ubicacion_detallada' => 'sometimes|nullable|string|max:255',
            'price'               => 'sometimes|required|numeric|min:0',
            'capacity'            => 'sometimes|nullable|integer|min:1',
            'duration'            => 'sometimes|nullable|string|max:100',
            'policy_cancellation' => 'sometimes|nullable|string',
            'category_id'         => 'sometimes|required|exists:categories,id',
            'location_id'         => 'sometimes|required|exists:locations,id',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors'  => $validator->errors()
            ], 422);
        }

        $service->update($validator->validated());
        $service->load(['media','category','zone', 'promotions'  => fn($q)=> $q->active(),
        'itineraries']);

        return response()->json([
            'message' => 'Servicio actualizado.',
            'service' => $service
        ], 200);
    }

    /**
     * 5️⃣ Subir nuevas fotos a un servicio existente
     *    POST /api/emprendedor/servicios/{id}/media
     */
    public function storeMedia(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        $uploaded = [];
        foreach ($request->file('photos') as $idx => $file) {
            $path = $file->store("services/{$service->id}", 'public');
            $media = ServiceMedia::create([
                'service_id'   => $service->id,
                'url'          => Storage::url($path),
                'type'         => 'image',
                'order_column' => $idx,
            ]);
            $uploaded[] = $media;
        }

        return response()->json([
            'message' => 'Imágenes subidas.',
            'media'   => $uploaded
        ], 201);
    }

    /**
     * 6️⃣ Eliminar una foto de un servicio
     *    DELETE /api/emprendedor/servicios/{id}/media/{mediaId}
     */
    public function destroyMedia($id, $mediaId)
    {
        $service = Service::findOrFail($id);
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $media = ServiceMedia::where('service_id', $service->id)
                              ->findOrFail($mediaId);
        $media->delete();

        return response()->noContent();
    }

    /**
     * 7️⃣ Eliminar servicio
     *    DELETE /api/emprendedor/servicios/{id}
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $service->delete();

        return response()->noContent();
    }

    /**
     * 8️⃣ Activar / Desactivar servicio
     *    PATCH /api/emprendedor/servicios/{id}/toggle-active
     */
   // 3️⃣ Activar / Desactivar servicio
    public function toggleActive(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        if ($service->company->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Solo cambiar el estado si hay capacidad disponible
        if ($service->capacity > 0) {
            $service->status = $service->status === 'active' ? 'pending' : 'active';
        } else {
            // Si la capacidad es 0, se pausa el servicio
            $service->status = 'paused'; // o 'inactive'
        }

        $service->save();

        return response()->json(['status' => $service->status]);
    }

   
   // 2️⃣ Actualizar la capacidad y el estado del servicio
    public function updateCapacityAndStatus($serviceId, $quantityReserved)
    {
        $service = Service::findOrFail($serviceId);
        $service->capacity -= $quantityReserved; // Reducir la capacidad disponible

        if ($service->capacity <= 0) {
            $service->status = 'paused'; // Si no hay más capacidad, pausa el servicio
        }

        
        $service->save();

        return response()->json([
            'message' => 'Capacidad actualizada',
            'service' => $service
        ], 200);
    }


}