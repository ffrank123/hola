<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// routes/api.php

use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);


// --- AUTH PÚBLICO ---
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\GoogleController;

// --- CONTROLADORES PÚBLICOS ---
use App\Http\Controllers\Publico\PublicServiceController;
use App\Http\Controllers\Publico\PublicCategoryController;
use App\Http\Controllers\Publico\CartController;
use App\Http\Controllers\Publico\CheckoutController;
use App\Http\Controllers\Publico\CalendarController as PublicCalendarController;
use App\Http\Controllers\Publico\PublicPromotionController;


// Itinerarios & Mensajes
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\MessageController;


// --- CONTROLADORES AUXILIARES ---
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;


// --- CONTROLADORES SUPERADMIN ---
use App\Http\Controllers\Superadmin\DashboardController        as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserManagementController;
use App\Http\Controllers\Superadmin\CompanyManagementController;
use App\Http\Controllers\Superadmin\ContentManagementController;
use App\Http\Controllers\Superadmin\ExperienceManagementController;
use App\Http\Controllers\Superadmin\CommunityManagementController;
use App\Http\Controllers\Superadmin\ReportController;
use App\Http\Controllers\Superadmin\ConfigController           as SuperadminConfigController;
use App\Http\Controllers\Superadmin\SecurityController;
use App\Http\Controllers\Superadmin\SuperadminController;
use App\Http\Controllers\Superadmin\PortalController;
use App\Http\Controllers\Superadmin\PortalDesignController;
use App\Http\Controllers\Superadmin\EmprendedoresController;
use App\Http\Controllers\Superadmin\CategoryManagementController;


// --- CONTROLADORES EMPRENDEDOR ---
use App\Http\Controllers\Emprendedor\DashboardController      as EmprendedorDashboardController;
use App\Http\Controllers\Emprendedor\ReservacionesController as EmprendedorReservationController;

use App\Http\Controllers\Emprendedor\PromotionController;
use App\Http\Controllers\Emprendedor\BlogController;
use App\Http\Controllers\Emprendedor\ProfileController         as EmprendedorProfileController;
use App\Http\Controllers\Emprendedor\ConfigController          as EmprendedorConfigController;
use App\Http\Controllers\Emprendedor\ServicioController;
use App\Http\Controllers\Emprendedor\CalendarController        as EmprendedorCalendarController;
use App\Http\Controllers\Emprendedor\EmprendedorController;
use App\Http\Controllers\Emprendedor\BookingController as EmprendedorBookingController;


// --- CONTROLADORES TURISTA ---
use App\Http\Controllers\Turista\DashboardController          as TuristaDashboardController;
use App\Http\Controllers\Turista\ExperienceController         as TuristaExperienceController;
use App\Http\Controllers\Turista\PackageController            as TuristaPackageController;
use App\Http\Controllers\Turista\ReservationController        as TuristaReservationController;
use App\Http\Controllers\Turista\FavoriteController;
use App\Http\Controllers\Turista\ReviewController;
use App\Http\Controllers\Turista\ProfileController             as TuristaProfileController;
use App\Http\Controllers\Turista\PaymentMethodController;
use App\Http\Controllers\Turista\ConfigController              as TuristaConfigController;
use App\Http\Controllers\Turista\ReservaPublicaController;

// --- RUTAS DE AUTENTICACIÓN PÚBLICA ---
Route::prefix('auth')->group(function () {

    Route::post('register-turista', [AuthController::class, 'registerTurista']);
    Route::post('login',            [AuthController::class, 'login']);
    Route::post('forgot-password',  [PasswordResetController::class, 'sendResetLinkEmail']);
    Route::post('reset-password',   [PasswordResetController::class, 'reset']);
    Route::get('google',            [GoogleController::class, 'redirectToGoogle']);
    Route::get('google/callback',   [GoogleController::class, 'handleGoogleCallback']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user',    [AuthController::class, 'user']);
    });
});

// --- RUTAS PÚBLICAS (SIN AUTH) ---
// Rutas públicas (sin auth)
Route::get('servicios-publicos',                  [PublicServiceController::class, 'index']);
Route::get('servicios-publicos/{service}',        [PublicServiceController::class, 'show']);
Route::get('servicios-publicos/{service}/calendar', [PublicCalendarController::class, 'occupiedDates']);

Route::get('categorias-publicas',  [PublicCategoryController::class, 'index']);
Route::get('locations',            [LocationController::class, 'index']);
Route::get('/locations/{id}', [LocationController::class, 'show']);
Route::get('categories',           [CategoryController::class, 'index']);

Route::get('promociones-publicas', [PublicPromotionController::class, 'index']);

// Carrito (requiere sesión web)
Route::middleware('web')->group(function () {
    Route::get('cart',                      [CartController::class,      'index']);
    Route::get('cart/summary',              [CartController::class,      'summary']);
    Route::post('cart/service/{serviceId}',  [CartController::class,      'addService']);
    Route::post('cart/promotion/{promoId}',  [CartController::class,      'addPromotion']);
    Route::delete('cart/{type}/{id}',          [CartController::class,      'remove']);
    Route::delete('cart', [CartController::class, 'clear']);
});

// Carrito para API (para tests)
Route::prefix('api')->middleware('web')->group(function () {
    Route::get('cart',                      [CartController::class,      'index']);
    Route::get('cart/summary',              [CartController::class,      'summary']);
    Route::post('cart/service/{serviceId}',  [CartController::class,      'addService']);
    Route::post('cart/promotion/{promoId}',  [CartController::class,      'addPromotion']);
    Route::delete('cart/{type}/{id}',          [CartController::class,      'remove']);
    Route::post('cart/clear', [CartController::class, 'clear']);
});

// Selectores de UI
Route::get('locations',  [LocationController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);




// TODAS ESTAS SON RUTAS PROTEGIDAS .

Route::middleware('auth:sanctum')->group(function () {

    // Mensajes
    Route::prefix('mensajes')->group(function () {
        Route::get('/',           [MessageController::class, 'index']);
        Route::post('/',          [MessageController::class, 'store']);
        Route::get('{message}',   [MessageController::class, 'show']);
        Route::put('{message}',   [MessageController::class, 'update']);
        Route::delete('{message}', [MessageController::class, 'destroy']);
    });


    // Itinerarios
    Route::prefix('itineraries')->group(function () {
        Route::get('/',           [ItineraryController::class, 'index']);
        Route::post('/',          [ItineraryController::class, 'store']);
        Route::get('{itinerary}', [ItineraryController::class, 'show']);
        Route::put('{itinerary}', [ItineraryController::class, 'update']);
        Route::delete('{itinerary}', [ItineraryController::class, 'destroy']);
    });




    // --- RUTAS PROTEGIDAS ---
    // Superadmin
    Route::middleware('role:superadmin')
        ->prefix('superadmin')
        ->group(function () {
            Route::get('dashboard', [SuperadminDashboardController::class, 'overview']);

            //Route::apiResource('users',       UserManagementController::class);   

            // ↓↓↓  Aquí insertas las rutas de gestión de TURISTAS ↓↓↓
            Route::get('turistas',                    [UserManagementController::class, 'index']);
            Route::get('turistas/{id}',               [UserManagementController::class, 'show']);
            Route::put('turistas/{id}/status',        [UserManagementController::class, 'updateStatus']);
            Route::post('turistas/{id}/mensaje',      [UserManagementController::class, 'sendMessage']);
            // ↑↑↑  Fin de rutas de TURISTAS ↑↑↑

            Route::get('companies/pending',   [CompanyManagementController::class, 'pending']);
            Route::put('companies/{id}/approve', [CompanyManagementController::class, 'approve']);
            Route::put('companies/{id}/reject',  [CompanyManagementController::class, 'reject']);


            // use App\Http\Controllers\Superadmin\EmprendedoresController;
            Route::get('emprendedores/kpis',           [EmprendedoresController::class, 'kpis']);
            Route::get('emprendedores',                [EmprendedoresController::class, 'index']);
            Route::post('emprendedores',               [EmprendedoresController::class, 'store']);
            Route::get('emprendedores/{id}',           [EmprendedoresController::class, 'show']);
            Route::put('emprendedores/{id}/estado',    [EmprendedoresController::class, 'updateEstado']);
            Route::delete('emprendedores/{id}',        [EmprendedoresController::class, 'destroy']);

            Route::apiResource('contents',     ContentManagementController::class)
                ->only(['index', 'show', 'update', 'destroy']);

            // ↓↓↓ RUTAS PARA EXPERIENCIAS PUBLICADAS ↓↓↓
            // Dentro del group superadmin, reemplaza tu bloque de rutas por esto:

            // 1) EXPERIENCIAS PUBLICADAS (filtros estáticos)
            Route::get('experiencias/publicadas',        [ExperienceManagementController::class, 'published']);

            // CRUD de comunidades
            Route::get('comunidades',             [CommunityManagementController::class, 'index']);
            Route::post('comunidades',             [CommunityManagementController::class, 'store']);
            Route::get('comunidades/{community}', [CommunityManagementController::class, 'show']);
            Route::put('comunidades/{community}', [CommunityManagementController::class, 'update']);
            Route::delete('comunidades/{community}', [CommunityManagementController::class, 'destroy']);


            // 2) CRUD de CATEGORÍAS de experiencias
            Route::get('experiencias/categorias',               [CategoryManagementController::class, 'index']);
            Route::post('experiencias/categorias',               [CategoryManagementController::class, 'store']);
            Route::put('experiencias/categorias/{category}',    [CategoryManagementController::class, 'update']);
            Route::delete('experiencias/categorias/{category}',    [CategoryManagementController::class, 'destroy']);

            // 3) Rutas dinámicas de una experiencia individual
            Route::get('experiencias/{experience}',       [ExperienceManagementController::class, 'show']);
            Route::put('experiencias/{experience}/pausar', [ExperienceManagementController::class, 'pause']);
            Route::put('experiencias/{experience}',      [ExperienceManagementController::class, 'update']);
            Route::delete('experiencias/{experience}',      [ExperienceManagementController::class, 'destroy']);


            // ↑↑↑ fin de EXPERIENCIAS ↓↑↑


            Route::get('reports/sales',        [ReportController::class, 'salesBy']);
            Route::get('reports/usage',        [ReportController::class, 'usageMetrics']);
            Route::get('config',               [SuperadminConfigController::class, 'show']);
            Route::put('config',               [SuperadminConfigController::class, 'update']);
            Route::get('security/logs',        [SecurityController::class, 'logs']);
            Route::get('security/audit',       [SecurityController::class, 'auditTrail']);
            Route::post('crear-usuario-emprendedor', [SuperadminController::class, 'crearUsuarioEmprendedor']);

            Route::get('empresas/lista',             [SuperadminController::class, 'listarEmpresas']);
            Route::get('empresas/pendientes',        [SuperadminController::class, 'listarEmpresasPendientes']);

            //Gestion de empresa
            Route::get('/empresas/pendientes', [SuperadminController::class, 'listarEmpresasPendientes']);
            Route::put('/aprobar-empresa/{id}', [SuperadminController::class, 'aprobarEmpresa']);
            Route::put('/rechazar-empresa/{id}', [SuperadminController::class, 'rechazarEmpresa']);
            Route::get('/empresas/lista', [SuperadminController::class, 'listarTodasLasEmpresas']);
            Route::post('portal',                    [PortalController::class, 'store']);
            Route::get('portales',                   [PortalController::class, 'index']);
            Route::get('portal/{id}/diseño',         [PortalDesignController::class, 'show']);
            Route::post('portal/diseño',             [PortalDesignController::class, 'save']);
            Route::put('portal/diseño/{id}',         [PortalDesignController::class, 'update']);
            Route::delete('portal/diseño/{id}',      [PortalDesignController::class, 'destroy']);
        });





    // Emprendedor
    Route::middleware(['auth:sanctum', 'role:emprendedor'])->prefix('emprendedor')->group(function () {
        Route::apiResource('blogs', App\Http\Controllers\Emprendedor\BlogController::class);
        Route::apiResource('promotions', App\Http\Controllers\Emprendedor\PromotionController::class);
        Route::apiResource('servicios', App\Http\Controllers\Emprendedor\ServicioController::class);
        Route::apiResource('bookings', App\Http\Controllers\Emprendedor\BookingController::class);
        Route::put('bookings/{booking}/status', [App\Http\Controllers\Emprendedor\BookingController::class, 'updateStatus']);
    });






    // Turista
    Route::middleware(['auth:sanctum', 'role:turista'])->prefix('turista')->group(function () {
        Route::apiResource('reservations', App\Http\Controllers\Turista\ReservationController::class);
        Route::apiResource('reviews', App\Http\Controllers\Turista\ReviewController::class);
        Route::apiResource('promotions', App\Http\Controllers\Turista\PromotionController::class)->only(['index']);
        Route::apiResource('bookings', App\Http\Controllers\Turista\BookingController::class);
        Route::post('bookings/{booking}/pay', [App\Http\Controllers\Turista\BookingController::class, 'pay']);
        Route::post('reservations/{reservation}/pay', [App\Http\Controllers\Turista\ReservationController::class, 'pay']);
    });
});




// checkout
Route::middleware(['auth:sanctum', 'role:turista'])
    ->post('checkout', [\App\Http\Controllers\Publico\CheckoutController::class, 'checkout']);

// Ruta para calendar de servicios (usada en CalendarControllerTest)
Route::get('services/{service}/calendar', [App\Http\Controllers\Publico\CalendarController::class, 'occupiedDates']);

// --- RUTAS SUPERADMIN REPORTS ---
Route::middleware(['auth:sanctum', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('reports/sales-by', [App\Http\Controllers\Superadmin\ReportController::class, 'salesBy']);
    Route::get('reports/usage-metrics', [App\Http\Controllers\Superadmin\ReportController::class, 'usageMetrics']);
});
