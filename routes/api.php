<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::get('test',[UserController::class,'test']);

Route::post('edit_siz',[InventoryController::class,'edit_siz']);
Route::group(['middleware'=>['auth:api','checkAdmin']],function(){

    Route::post('change',[UserController::class,'change']);
});

Route::group(['middleware'=>['auth:api']],function(){
    Route::post('edit_siz',[InventoryController::class,'edit_siz']);
    Route::post('logout',[UserController::class,'logout']);
    Route::post('product',[InventoryController::class,'product']);
    Route::post('review/{date}',[InventoryController::class,'review']);
    Route::get('dateImport',[InventoryController::class,'dateImport']);
    Route::get('dateExport',[InventoryController::class,'dateExport']);
    Route::post('lostIn',[InventoryController::class,'lostIn']);
    Route::get('dateLost',[InventoryController::class,'dateLost']);
    Route::post('import',[InventoryController::class,'import']);
    Route::post('export/{method}',[InventoryController::class,'export']);
    Route::post('cost',[InventoryController::class,'cost']);
    Route::get('count',[InventoryController::class,'product_count']);
    Route::get('name',[InventoryController::class,'product_name']);
    Route::post('add_employee',[InventoryController::class,'add_employee']);
    Route::post('inventory',[InventoryController::class,'inventory']);
});
