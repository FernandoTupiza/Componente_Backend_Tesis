<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\AvatarController;
use App\Http\Controllers\Account\ProfileController;

use App\Http\Controllers\Carreras\CarrerasAdminController;
use App\Http\Controllers\Carreras\CarrerasEstudianteController;

use App\Http\Controllers\Semestres\SemestresAdminController;
use App\Http\Controllers\Semestres\SemestresEstudianteController;
use App\Http\Controllers\Materias\MateriasEstudianteController;
use App\Http\Controllers\Materias\MateriasAdminController;

use App\Http\Controllers\Documentos\DocumentosAdminController;
use App\Http\Controllers\Documentos\DocumentosEstudianteController;

use App\Http\Controllers\Comentarios\ComentariosSistemaController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\DocumentosController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function ()
{
    // Hacer uso del archivo auth.php
    require __DIR__ . '/auth.php';

    // Se hace uso de grupo de rutas y que pasen por el proceso de auth con sanctum
    Route::middleware(['auth:sanctum'])->group(function ()
    {
        // Se hace uso de grupo de rutas
        Route::prefix('profile')->group(function ()
        {
            Route::controller(ProfileController::class)->group(function ()
            {
                Route::get('/', 'show')->name('profile');
                Route::post('/', 'store')->name('profile.store');
            });
            Route::post('/avatar', [AvatarController::class, 'store'])->name('profile.avatar');
           


        });
        ///AQUI ENTRA LALS RUTAS A PROTEGER 

        //RUTAS DE CARRERAS PARA EL ADMINISTRADOR

            Route::post('/carreras/admin', [CarrerasAdminController::class, 'store_admin']);
            Route::get('/carreras/admin', [CarrerasAdminController::class, 'index_admin']);
            Route::get('/carreras/adminE', [CarrerasAdminController::class, 'index_adminE']);
            Route::get('/carreras/admin/{id}', [CarrerasAdminController::class, 'show_admin']);
            Route::post('/carreras/admin/{id}', [CarrerasAdminController::class, 'update_admin']);
            Route::get('/carreras/desactiva/admin/{carreras}', [CarrerasAdminController::class, 'destroy_admin']);



            // RUTAS DE SEMESTRES PARA EL ADMINISTRADOR 

            Route::post('/semestres/admin/{carreras}', [SemestresAdminController::class, 'store_admin']);
            Route::get('/semestres/admin', [SemestresAdminController::class, 'index_admin']);
            Route::get('/semestres/adminE', [SemestresAdminController::class, 'index_adminE']);
            Route::get('/semestres/admin/{id}', [SemestresAdminController::class, 'show_admin']);
            Route::post('/semestres/admin/update/{semestres}', [SemestresAdminController::class, 'update_admin']);
            Route::get('/semestres/desactiva/admin/{semestres}', [SemestresAdminController::class, 'destroy_admin']);

            
            // RUTAS DE MATERIAS PARA EL ADMINISTRADOR


            Route::post('/materias/admin/{semestres}', [MateriasAdminController::class, 'store_admin']);
            Route::get('/materias/admin', [MateriasAdminController::class, 'index_admin']);
            Route::get('/materias/adminE', [MateriasAdminController::class, 'index_adminE']);
            Route::get('/materias/admin/{id}', [MateriasAdminController::class, 'show_admin']);
            Route::post('/materias/admin/update/{id}', [MateriasAdminController::class, 'update_admin']);
            Route::get('/materias/desactiva/admin/{materias}', [MateriasAdminController::class, 'destroy_admin']);
 
            
            //GESTION COMENTARIOS ADMINISTRADOR

            Route::post('/comentarios/sistema/{materias}', [ComentariosSistemaController::class, 'store_admin']);
            Route::post('/comentarios/sistema/cambio/{semestres}', [ComentariosSistemaController::class, 'store_adminCambio']);
            Route::get('/comentarios/sistema/', [ComentariosSistemaController::class, 'index_admin']);
            Route::get('/comentarios/sistema/{id}', [ComentariosSistemaController::class, 'show_admin']);
            Route::post('/comentarios/sistema/actualizar/{id}', [ComentariosSistemaController::class, 'update_admin']);
            Route::delete('/comentarios/sistema/{id}', [ComentariosSistemaController::class, 'delete_admin']);
 
       
            //GESTION DOCUMENTOS ADMINISTRADOR

            Route::post('/documentos/admin/{materias}', [DocumentosAdminController::class, 'store_admin']);
            Route::post('/documentos/admin/actualizar/{documentos}', [DocumentosAdminController::class, 'update_admin']);
            Route::get('/documentos/admin/{id}', [DocumentosAdminController::class, 'show_admin']);
            Route::get('/documentos/admin', [DocumentosAdminController::class, 'index_admin']);
            Route::delete('/documentos/admin/{id}', [DocumentosAdminController::class, 'delete_admin']);

            //USUARIOS

            Route::get('/usuarios', [RegisterController::class, 'index_usuario']);
            Route::get('/usuarios/{id}', [RegisterController::class, 'show_usuario']);



    });
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Hacer uso del archivo auth.php
require __DIR__ . '/auth.php';






