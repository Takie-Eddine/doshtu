<?php


use App\Http\Controllers\Supplier\CompanyController;
use App\Http\Controllers\Supplier\ComplaintsController;
use App\Http\Controllers\Supplier\DashboardController;
use App\Http\Controllers\Supplier\ProductsController;
use App\Http\Controllers\Supplier\ProfileController;
use App\Http\Controllers\Supplier\RolePermissionsController;
use App\Http\Controllers\Supplier\UsersController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){



    Route::group(['namespace' => 'Supplier' ,'middleware' => ['auth:supplier','verified'] , 'as'=>'supplier.' , 'prefix' => 'supplier'],function(){


        Route::get('/',[DashboardController::class,'index'])->name('dashboard');



        Route::group(['prefix' => 'company'],function(){

            Route::get('/',[CompanyController::class,'index'])->name('company');
            Route::post('/store',[CompanyController::class,'store'])->name('company.store');
            Route::patch('/update',[CompanyController::class,'update'])->name('company.update');
            Route::post('/remove_image',[CompanyController::class,'remove_image'])->name('company.remove_image');
        });



        Route::group(['prefix'=>'profile' ],function(){
            Route::get('/', [ProfileController::class, 'index'])->name('profile');
            Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('/security', [ProfileController::class, 'security'])->name('profile.security');
            Route::patch('/security/update', [ProfileController::class, 'security_update'])->name('profile.security.update');
        });



        Route::group(['prefix' =>'roles-permission'], function () {
            Route::get('/roles-permissions', [RolePermissionsController::class, 'rolepermission'])->name('role-permissions.index');
            Route::get('/create', [RolePermissionsController::class, 'create'])->name('role-permissions.create');
            Route::post('/store', [RolePermissionsController::class, 'store'])->name('role-permissions.store');
            Route::get('/edit/{id}', [RolePermissionsController::class, 'edit'])->name('role-permissions.edit');
            Route::post('/update/{id}', [RolePermissionsController::class, 'update'])->name('role-permissions.update');
            Route::delete('/delete/{id}', [RolePermissionsController::class, 'delete'])->name('role-permissions.delete');

        });

        Route::group(['prefix' => 'users' ], function () {
            Route::get('/', [UsersController::class, 'index'])->name('user.index');
            Route::get('create', [UsersController::class, 'create'])->name('user.create');
            Route::post('store', [UsersController::class, 'store'])->name('user.store');
            Route::get('edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
            Route::post('store/{id}', [UsersController::class, 'update'])->name('user.update');
            Route::get('view/{id}', [UsersController::class, 'view'])->name('user.view');
            Route::delete('delete/{id}', [UsersController::class, 'delete'])->name('user.delete');

        });

        Route::group(['prefix' => 'products', 'middleware' => ['company'] ], function () {
            Route::get('/', [ProductsController::class, 'index'])->name('products.index');
            Route::get('create', [ProductsController::class, 'create'])->name('products.create');
            Route::post('store', [ProductsController::class, 'store'])->name('products.store');
            Route::get('edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
            Route::post('update/{id}', [ProductsController::class, 'update'])->name('products.update');
            Route::get('show/{product}', [ProductsController::class, 'show'])->name('products.show');
            Route::delete('delete/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
            Route::get('/trash',[ProductsController::class, 'trash'])->name('products.trash');
            Route::put('/{product}/restore',[ProductsController::class, 'restore'])->name('products.restore');
            Route::delete('/{product}/force-delete',[ProductsController::class, 'forceDelete'])->name('products.force-delete');
            Route::get('/add_variant/{product}', [ProductsController::class, 'add_variant'])->name('products.add_variant');
            Route::post('/store_variant', [ProductsController::class, 'store_variant'])->name('products.store_variant');
            Route::get('/inactive-products', [ProductsController::class, 'index'])->name('inactive.products.index');
        });



        Route::group(['prefix' => 'complaints', ], function () {

            Route::get('/', [ComplaintsController::class, 'index'])->name('complaints.index');
            Route::get('/respond/{id}', [ComplaintsController::class, 'respond'])->name('complaints.respond');
            Route::post('/create', [ComplaintsController::class, 'create'])->name('complaints.create');
            Route::get('/newcomplaint', [ComplaintsController::class, 'newcomplaint'])->name('complaints.newcomplaint');
            Route::post('/send', [ComplaintsController::class, 'send'])->name('complaints.send');
            Route::get('/view/{id}', [ComplaintsController::class, 'view'])->name('complaints.view');
        });


    });

});



require __DIR__.'/authsupplier.php';
