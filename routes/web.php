<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accesos\GestionController;
use App\Http\Controllers\Accesos\MenuController;
use App\Http\Controllers\Accesos\GestionMenuController;
use App\Http\Controllers\Accesos\PersonaController;
use App\Http\Controllers\Accesos\PerfilController;
use App\Http\Controllers\Accesos\UsuarioController;

use App\Http\Controllers\Bodega\IngresoBodegaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//PERSONA
Route::get('/persona', [PersonaController::class, 'index'])->middleware('validarRuta');
Route::get('/listado-persona', [PersonaController::class, 'listar']);
Route::post('/guardar-persona', [PersonaController::class, 'guardar']);
Route::get('/editar-persona/{id}', [PersonaController::class, 'editar']);
Route::put('/actualizar-persona/{id}', [PersonaController::class, 'actualizar']);
Route::get('/eliminar-persona/{id}', [PersonaController::class, 'eliminar']);


//PERFILES
Route::get('/perfil', [PerfilController::class, 'index']);
Route::get('/listado-rol', [PerfilController::class, 'listar']);
Route::post('/guardar-rol', [PerfilController::class, 'guardar']);
Route::get('/editar-rol/{id}', [PerfilController::class, 'editar']);
Route::put('/actualizar-rol/{id}', [PerfilController::class, 'actualizar']);
Route::get('/eliminar-rol/{id}', [PerfilController::class, 'eliminar']);
Route::get('/acceso-perfil/{id}', [PerfilController::class, 'accesoPerfil']);
Route::get('/acceso-por-perfil/{menu}/{tipo}/{perfil}', [PerfilController::class, 'mantenimientoAccesoPerfil']);
Route::get('/dato-perfil', [PerfilController::class, 'datoPerfil']);



//GESTION
Route::get('/gestion', [GestionController::class, 'index']);
Route::get('/listado-gestion', [GestionController::class, 'listar']);
Route::post('/guardar-gestion', [GestionController::class, 'guardar']);
Route::get('/editar-gestion/{id}', [GestionController::class, 'editar']);
Route::put('/actualizar-gestion/{id}', [GestionController::class, 'actualizar']);
Route::get('/eliminar-gestion/{id}', [GestionController::class, 'eliminar']);

//MENU
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/listado-menu', [MenuController::class, 'listar']);
Route::post('/guardar-menu', [MenuController::class, 'guardar']);
Route::get('/editar-menu/{id}', [MenuController::class, 'editar']);
Route::put('/actualizar-menu/{id}', [MenuController::class, 'actualizar']);
Route::get('/eliminar-menu/{id}', [MenuController::class, 'eliminar']);

//GESTION-MENU
Route::get('/gestion-menu', [GestionMenuController::class, 'index']);
Route::get('/listado-gestion-menu', [GestionMenuController::class, 'listar']);
Route::post('/guardar-gestion-menu', [GestionMenuController::class, 'guardar']);
Route::get('/editar-gestion-menu/{id}', [GestionMenuController::class, 'editar']);
Route::put('/actualizar-gestion-menu/{id}', [GestionMenuController::class, 'actualizar']);
Route::get('/eliminar-gestion-menu/{id}', [GestionMenuController::class, 'eliminar']);


//USUARIO
Route::get('/usuario', [UsuarioController::class, 'index'])->middleware('validarRuta');
Route::get('/listado-usuario', [UsuarioController::class, 'listar']);
Route::post('/guardar-usuario', [UsuarioController::class, 'guardar']);
Route::get('/editar-usuario/{id}', [UsuarioController::class, 'editar']);
Route::put('/actualizar-usuario/{id}', [UsuarioController::class, 'actualizar']);
Route::get('/eliminar-usuario/{id}', [UsuarioController::class, 'eliminar']);
Route::post('/cambiar-clave', [UsuarioController::class, 'cambiarClave']);
Route::get('/resetear-password/{id}', [UsuarioController::class, 'resetearPassword']);


//BODEGA-INGRESO
Route::get('/ingreso-bodega', [IngresoBodegaController::class, 'index']);
Route::get('/buscar-producto', [IngresoBodegaController::class, 'buscarProducto']);
Route::get('/buscar-proveedor', [IngresoBodegaController::class, 'buscarProveedor']);
Route::get('/info-producto/{id}', [IngresoBodegaController::class, 'infoProducto']);
Route::post('/guarda-ingreso-bodega', [IngresoBodegaController::class, 'guardaIngreso']);


Route::get('/listado-gestion-menu', [IngresoBodegaController::class, 'listar']);
Route::post('/guardar-gestion-menu', [IngresoBodegaController::class, 'guardar']);
Route::get('/editar-gestion-menu/{id}', [IngresoBodegaController::class, 'editar']);
Route::put('/actualizar-gestion-menu/{id}', [IngresoBodegaController::class, 'actualizar']);
Route::get('/eliminar-gestion-menu/{id}', [IngresoBodegaController::class, 'eliminar']);




