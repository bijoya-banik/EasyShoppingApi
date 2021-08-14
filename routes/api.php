<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;  
use App\Http\Controllers\categoryController;    
use App\Http\Controllers\ProductController;    
use App\Http\Controllers\FileController;    
use App\Http\Controllers\CommonController;    
use App\Http\Controllers\OrderController;    
use App\Http\Controllers\SuggestionController;    
use App\Http\Controllers\FeedbackController;    

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

; 

Route::post('/register',[userController::class, 'register']);
Route::post('/login',[userController::class, 'login']);


Route::group(['middleware' => ['jwt.verify']], function() {

Route::post('/editUser',[userController::class, 'editUser']);
Route::post('/editPassword',[userController::class, 'editPassword']);
Route::post('/logout',[userController::class, 'logout']);
Route::post('/uploadImage',[FileController::class, 'uploadImage']);


Route::get('/totalData',[commonController::class, 'totalData']);

Route::post('/addCategory',[categoryController::class, 'addCategory']);
Route::get('/showAllCategory',[categoryController::class, 'showAllCategory']);
Route::post('/editCategory',[categoryController::class, 'editCategory']);
Route::post('/deleteCategory',[categoryController::class, 'deleteCategory']);

Route::post('/addProduct',[productController::class, 'addProduct']);
Route::get('/showAllProduct',[productController::class, 'showAllProduct']);
Route::get('/showOfferProduct',[productController::class, 'showOfferProduct']);
Route::get('/showAvailableProduct',[productController::class, 'showAvailableProduct']);
Route::get('/showStockOutProduct',[productController::class, 'showStockOutProduct']);

Route::get('/showProductsByCategory/{categoryId}',[productController::class, 'showProductsByCategory']);
Route::get('/searchProduct/{value}',[productController::class, 'searchProduct']);
Route::post('/editProduct',[productController::class, 'editProduct']);
Route::post('/deleteProduct',[productController::class, 'deleteProduct']);


Route::post('/addOrder',[OrderController::class, 'addOrder']);
Route::get('/showOrders',[OrderController::class, 'showOrders']);
Route::get('/showOrdersType/{value}',[OrderController::class, 'showOrdersType']);
Route::get('/showMyOrders/{value}',[OrderController::class, 'showMyOrders']);
Route::post('/editOrderStatus',[OrderController::class, 'editOrderStatus']);

Route::post('/addSuggestion',[SuggestionController::class, 'addSuggestion']);

Route::post('/addFeed',[FeedbackController::class, 'addFeed']);

}); 