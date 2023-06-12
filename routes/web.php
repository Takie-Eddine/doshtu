<?php

use App\Http\Controllers\InstalationController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\User\ComplaintsController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProductsController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RolePermissionsController;
use App\Http\Controllers\User\StoresController;
use App\Http\Controllers\User\SubscribeController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\UsersController;
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



        // {{asset('assets/profile_images/'.Auth::user('web')->profile->photo)}}

        Route::group(['namespace' => 'User' ,'middleware' => ['auth:web','verified'] , 'as'=>'user.' , 'prefix' => 'user'],function(){


            Route::get('/',[DashboardController::class,'index'])->name('dashboard');

            Route::group(['prefix'=>'subscribe' ],function(){
                Route::get('/create', [SubscribeController::class, 'create'])->name('subscribe.create');
                Route::get('/checkout/{id}', [PaypalController::class, 'checkout'])->name('subscribe.store');
                Route::post('/store_month/{id}', [SubscribeController::class, 'storeM'])->name('subscribe.storeM');
                Route::post('/store_year/{id}', [SubscribeController::class, 'storeY'])->name('subscribe.storeY');
                Route::post('/free/{id}', [SubscribeController::class, 'free'])->name('subscribe.free');
                Route::get('/payment', [SubscribeController::class, 'payment'])->name('subscribe.payment');
                Route::post('/payment/store', [SubscribeController::class, 'store'])->name('subscribe.payment.store');
            });


            Route::group(['prefix'=>'profile' ],function(){
                Route::get('/', [ProfileController::class, 'index'])->name('profile');
                Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
                Route::get('/security', [ProfileController::class, 'security'])->name('profile.security');
                Route::patch('/security/update', [ProfileController::class, 'security_update'])->name('profile.security.update');
            });

            Route::group(['prefix' =>'roles-permission','middleware'=>['store']], function () {
                Route::get('/roles-permissions', [RolePermissionsController::class, 'rolepermission'])->name('role-permissions.index');
                Route::get('/create', [RolePermissionsController::class, 'create'])->name('role-permissions.create');
                Route::post('/store', [RolePermissionsController::class, 'store'])->name('role-permissions.store');
                Route::get('/edit/{id}', [RolePermissionsController::class, 'edit'])->name('role-permissions.edit');
                Route::post('/update/{id}', [RolePermissionsController::class, 'update'])->name('role-permissions.update');
                Route::delete('/delete/{id}', [RolePermissionsController::class, 'delete'])->name('role-permissions.delete');

            });

            Route::group(['prefix' => 'users','middleware'=>['store','creation'] ], function () {
                Route::get('/', [UsersController::class, 'index'])->name('user.index');
                Route::get('create', [UsersController::class, 'create'])->name('user.create');
                Route::post('store', [UsersController::class, 'store'])->name('user.store');
                Route::get('edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
                Route::post('update/{id}', [UsersController::class, 'update'])->name('user.update');
                Route::get('view/{id}', [UsersController::class, 'view'])->name('user.view');
                Route::delete('delete/{id}', [UsersController::class, 'delete'])->name('user.delete');

            });


            Route::group(['prefix' => 'subscription','middleware'=>['store'] ], function () {
                Route::get('/', [SubscriptionController::class, 'index'])->name('subscription');
                Route::get('upgrade/{id}', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
                Route::get('cancel/{id}', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
                Route::post('update-monthly/{id}', [SubscriptionController::class, 'updateM'])->name('subscription.updateM');
                Route::post('update-annual/{id}', [SubscriptionController::class, 'updateY'])->name('subscription.updateY');
            });


            Route::group(['prefix' => 'stores' ,'middleware'=>['store'] ], function () {
                Route::get('/', [StoresController::class, 'index'])->name('stores.index')->middleware('store');
                Route::get('create', [StoresController::class, 'create'])->name('stores.create');
                Route::post('store', [StoresController::class, 'store'])->name('stores.store');
                Route::get('edit/{id}', [StoresController::class, 'edit'])->name('stores.edit');
                Route::post('update/{id}', [StoresController::class, 'update'])->name('stores.update');
                Route::get('view/{id}', [StoresController::class, 'view'])->name('stores.view');
                Route::delete('delete/{id}', [StoresController::class, 'delete'])->name('stores.delete');
                Route::get('default/{id}', [StoresController::class, 'default'])->name('stores.default');
                Route::get('change/{id}', [StoresController::class, 'change'])->name('stores.change');
            });



            Route::group(['prefix' => 'complaints','middleware'=>['store','creation'] ], function () {

                Route::get('/', [ComplaintsController::class, 'index'])->name('complaints.index');
                Route::get('/respond/{id}', [ComplaintsController::class, 'respond'])->name('complaints.respond');
                Route::post('/create', [ComplaintsController::class, 'create'])->name('complaints.create');
                Route::get('/newcomplaint', [ComplaintsController::class, 'newcomplaint'])->name('complaints.newcomplaint');
                Route::post('/send', [ComplaintsController::class, 'send'])->name('complaints.send');
                Route::get('/view/{id}', [ComplaintsController::class, 'view'])->name('complaints.view');

            });



            Route::group(['prefix' => 'products','middleware'=>['store','creation'] ], function () {
                Route::get('/', [ProductsController::class, 'index'])->name('products.index');
                Route::get('/details/{slug}', [ProductsController::class, 'details'])->name('products.details');
                Route::post('/importlist/{slug}', [ProductsController::class, 'importliststore'])->name('products.importlist.store');
                Route::get('/importlist', [ProductsController::class, 'importlist'])->name('products.importlist');
                Route::post('/remove-importlist/{id}', [ProductsController::class, 'remove_importlist'])->name('products.importlist.remove');
                Route::get('/products-in-store', [ProductsController::class, 'product_instore'])->name('products.products');
                Route::post('/products-in-store/delete', [ProductsController::class, 'remove_product_instore'])->name('products.delete');
                Route::get('/product/{slug}', [ProductsController::class, 'pushtostore'])->name('products.pushtostore');
                Route::post('/product', [ProductsController::class, 'push'])->name('products.push');
                Route::get('/variants/{slug}', [ProductsController::class, 'variant'])->name('products.variant');
                Route::post('/variant', [ProductsController::class, 'pushvariant'])->name('products.pushvariant');
            });

        });

});


// Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->middleware(['auth', 'verified'])->name('dashboard');

        // Route::middleware('auth')->group(function () {
        //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // });



require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/supplier.php';
