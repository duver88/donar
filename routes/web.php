<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    PetRegistrationController,
    BloodRequestController,
    SuperAdminController,
    VeterinarianController,
    TutorController,
    ActiveRequestsController,        // NUEVO
    DonationResponseController       // NUEVO
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
};

// ========================================
// RUTAS PÚBLICAS
// ========================================

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Página pública de solicitudes activas (NUEVA)
Route::get('/solicitudes-activas', [ActiveRequestsController::class, 'publicIndex'])
    ->name('active-requests.public');

// ========================================
// RUTAS DE AUTENTICACIÓN MANUALES (Laravel 11)
// ========================================

// Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Register (deshabilitado - solo registro de veterinarios)
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// Password Reset
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Registro de veterinarios (público)
Route::get('/veterinario/registro', [VeterinarianController::class, 'register'])->name('veterinarian.register');
Route::post('/veterinario/registro', [VeterinarianController::class, 'store'])->name('veterinarian.store');

// Postulación de mascotas (público)
Route::get('/postular-mascota', [PetRegistrationController::class, 'create'])->name('pets.create');
Route::post('/postular-mascota', [PetRegistrationController::class, 'store'])->name('pets.store');

// Verificar email (público)
Route::post('/check-email', [PetRegistrationController::class, 'checkEmail'])->name('check.email');

// ========================================
// RUTAS PÚBLICAS PARA SOLICITUDES ACTIVAS
// ========================================

// Página pública con todas las solicitudes activas
Route::get('/solicitudes-activas', [App\Http\Controllers\PublicRequestsController::class, 'index'])->name('public.active-requests');

// Página específica para una mascota con solicitudes compatibles
Route::get('/mascotas/{pet}/solicitudes-activas', [App\Http\Controllers\PublicRequestsController::class, 'forPet'])->name('pets.active-requests');

// Aceptar una donación (público)
Route::post('/donacion/{bloodRequest}/aceptar', [App\Http\Controllers\PublicRequestsController::class, 'acceptDonation'])->name('public.donation.accept');

// Declinar una donación (público)
Route::post('/donacion/{bloodRequest}/declinar', [App\Http\Controllers\PublicRequestsController::class, 'declineDonation'])->name('public.donation.decline');

// ========================================
// RUTAS PROTEGIDAS POR AUTENTICACIÓN
// ========================================

Route::middleware(['auth'])->group(function () {
    
    // ========================================
    // REDIRECCIÓN DESPUÉS DEL LOGIN
    // ========================================
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('admin.dashboard');
            case 'veterinarian':
                if ($user->status === 'approved') {
                    return redirect()->route('veterinarian.dashboard');
                } else {
                    return redirect()->route('home')->with('error', 'Tu cuenta está pendiente de aprobación.');
                }
            case 'tutor':
                return redirect()->route('tutor.dashboard');
            default:
                return redirect()->route('home');
        }
    })->name('dashboard');

    // ========================================
    // RUTAS GENERALES (TODOS LOS USUARIOS AUTENTICADOS)
    // ========================================
    
    // Mascotas del usuario
    Route::get('/mis-mascotas', [PetRegistrationController::class, 'index'])->name('pets.index');
    Route::get('/mis-mascotas/{pet}', [PetRegistrationController::class, 'show'])->name('pets.show');
    Route::get('/mis-mascotas/{pet}/editar', [PetRegistrationController::class, 'edit'])->name('pets.edit');
    Route::put('/mis-mascotas/{pet}', [PetRegistrationController::class, 'update'])->name('pets.update');
    
    // Solicitudes activas para mascota específica (NUEVA)
    Route::get('/pets/{pet}/active-requests', [ActiveRequestsController::class, 'index'])
        ->name('pets.active-requests');
    
    // Respuestas a solicitudes de donación (NUEVAS)
    Route::post('/donation/{bloodRequest}/accept', [DonationResponseController::class, 'accept'])
        ->name('donation.accept');
    Route::post('/donation/{bloodRequest}/decline', [DonationResponseController::class, 'decline'])
        ->name('donation.decline');
    
    // Historial de respuestas del usuario (NUEVA)
    Route::get('/mis-respuestas-donacion', [DonationResponseController::class, 'myResponses'])
        ->name('donation.my-responses');

    // ========================================
    // RUTAS DEL SUPER ADMIN
    // ========================================
    
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        // Gestión de Veterinarios
        Route::get('/veterinarios', [SuperAdminController::class, 'veterinarians'])->name('veterinarians');
        Route::get('/veterinarios/crear', [SuperAdminController::class, 'createVeterinarian'])->name('veterinarians.create');
        Route::post('/veterinarios', [SuperAdminController::class, 'storeVeterinarian'])->name('veterinarians.store');
        Route::get('/veterinarios/{id}/revisar', [SuperAdminController::class, 'reviewVeterinarian'])->name('veterinarians.review');
        Route::get('/veterinarios/{id}', [SuperAdminController::class, 'showVeterinarian'])->name('veterinarians.show');
        Route::get('/veterinarios/{id}/editar', [SuperAdminController::class, 'editVeterinarian'])->name('veterinarians.edit');
        Route::put('/veterinarios/{id}', [SuperAdminController::class, 'updateVeterinarian'])->name('veterinarians.update');
        Route::delete('/veterinarios/{id}', [SuperAdminController::class, 'destroyVeterinarian'])->name('veterinarians.destroy');
        Route::post('/veterinarios/{id}/aprobar', [SuperAdminController::class, 'approveVeterinarian'])->name('veterinarians.approve');
        Route::post('/veterinarios/{id}/rechazar', [SuperAdminController::class, 'rejectVeterinarian'])->name('veterinarians.reject');
        Route::post('/veterinarios/{id}/reenviar-email', [SuperAdminController::class, 'resendPasswordSetupEmail'])->name('veterinarians.resend-email');

        // Gestión de Tutores
        Route::get('/tutores', [SuperAdminController::class, 'tutors'])->name('tutors');
        Route::get('/tutores/{id}', [SuperAdminController::class, 'showTutor'])->name('tutors.show');
        Route::get('/tutores/{id}/editar', [SuperAdminController::class, 'editTutor'])->name('tutors.edit');
        Route::put('/tutores/{id}', [SuperAdminController::class, 'updateTutor'])->name('tutors.update');
        Route::delete('/tutores/{id}', [SuperAdminController::class, 'destroyTutor'])->name('tutors.destroy');

        // Gestión de Mascotas
        Route::get('/mascotas', [SuperAdminController::class, 'pets'])->name('pets');
        Route::get('/mascotas/{id}', [SuperAdminController::class, 'showPet'])->name('pets.show');
        Route::get('/mascotas/{id}/editar', [SuperAdminController::class, 'editPet'])->name('pets.edit');
        Route::put('/mascotas/{id}', [SuperAdminController::class, 'updatePet'])->name('pets.update');
        Route::delete('/mascotas/{id}', [SuperAdminController::class, 'destroyPet'])->name('pets.destroy');

        // Gestión de Solicitudes
        Route::get('/solicitudes', [SuperAdminController::class, 'bloodRequests'])->name('blood_requests');
        Route::get('/solicitudes/{id}', [SuperAdminController::class, 'showBloodRequest'])->name('blood_requests.show');
        Route::put('/solicitudes/{id}/estado', [SuperAdminController::class, 'updateBloodRequestStatus'])->name('blood_requests.update_status');

        // Rutas legacy para compatibilidad
        Route::post('/veterinarios/{id}/aprobar', [SuperAdminController::class, 'approveVeterinarian'])->name('approve_veterinarian');
        Route::post('/veterinarios/{id}/rechazar', [SuperAdminController::class, 'rejectVeterinarian'])->name('reject_veterinarian');
    });

    // ========================================
    // RUTAS DEL VETERINARIO
    // ========================================
    
    Route::middleware(['veterinarian'])->prefix('veterinario')->name('veterinarian.')->group(function () {
        Route::get('/dashboard', [VeterinarianController::class, 'dashboard'])->name('dashboard');
        Route::get('/solicitar-donacion', [BloodRequestController::class, 'create'])->name('blood_request.create');
        Route::post('/solicitar-donacion', [BloodRequestController::class, 'store'])->name('blood_request.store');
        Route::get('/solicitud/{id}', [VeterinarianController::class, 'showBloodRequest'])->name('blood_request.show');
        Route::post('/solicitud/{id}/cancelar', [BloodRequestController::class, 'cancel'])->name('blood_request.cancel');

        // Marcar donación como completada (NUEVA)
        Route::post('/donation-response/{donationResponse}/completed', [DonationResponseController::class, 'markCompleted'])
            ->name('donation.mark-completed');
    });

    // ========================================
    // RUTAS DEL TUTOR
    // ========================================
    
    Route::middleware(['tutor'])->prefix('tutor')->name('tutor.')->group(function () {
        Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
        Route::post('/responder-donacion/{request}', [TutorController::class, 'respondToDonationRequest'])->name('respond_donation');
        Route::post('/completar-donacion/{response}', [TutorController::class, 'markDonationCompleted'])->name('complete_donation');
    });
});

// ========================================
// RUTAS API (OPCIONALES)
// ========================================

Route::prefix('api')->name('api.')->group(function () {
    // Estadísticas públicas de solicitudes activas
    Route::get('/active-requests/stats', [ActiveRequestsController::class, 'stats'])
        ->name('active-requests.stats');
    
    // Búsqueda AJAX para mascotas (requiere autenticación)
    Route::middleware(['auth'])->group(function () {
        Route::get('/pets/{pet}/search-requests', [ActiveRequestsController::class, 'searchForPet'])
            ->name('pets.search-requests');
        Route::post('/requests/mark-viewed', [ActiveRequestsController::class, 'markAsViewed'])
            ->name('requests.mark-viewed');
    });
});