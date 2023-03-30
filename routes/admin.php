<?php

use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\CompaniesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PlansController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolePermissionsController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\UsersController;
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

        Route::group(['namespace' => 'Dashboard' ,'middleware' => ['auth:admin','verified'] , 'as'=>'admin.' , 'prefix' => 'admin'],function(){


            Route::get('/',[DashboardController::class,'index'])->name('dashboard');


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

            });

            Route::group(['prefix' => 'users' ], function () {
                Route::get('/', [UsersController::class, 'index'])->name('user.index');
                Route::get('create', [UsersController::class, 'create'])->name('user.create');
                Route::post('store', [UsersController::class, 'store'])->name('user.store');
                Route::get('edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
                Route::post('update/{id}', [UsersController::class, 'update'])->name('user.update');
                Route::get('view/{id}', [UsersController::class, 'view'])->name('user.view');
                Route::delete('delete/{id}', [UsersController::class, 'delete'])->name('user.delete');

            });

            Route::group(['prefix' => 'categories' ], function () {
                Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
                Route::get('create', [categoriesController::class, 'create'])->name('categories.create');
                Route::post('store', [categoriesController::class, 'store'])->name('categories.store');
                Route::get('edit/{id}', [categoriesController::class, 'edit'])->name('categories.edit');
                Route::post('update/{id}', [categoriesController::class, 'update'])->name('categories.update');
                Route::get('show/{category}', [categoriesController::class, 'show'])->name('categories.show');
                Route::delete('delete/{id}', [categoriesController::class, 'destroy'])->name('categories.destroy');
                Route::get('/trash',[CategoriesController::class, 'trash'])->name('categories.trash');
                Route::put('/{category}/restore',[CategoriesController::class, 'restore'])->name('categories.restore');
                Route::delete('/{category}/force-delete',[CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
            });


            Route::group(['prefix' => 'products' ], function () {
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
                Route::delete('/variant/delete/{id}',[ProductsController::class, 'delete_variant'])->name('products.delete_variant');
            });



            Route::group(['prefix' => 'suppliers' ], function () {
                Route::get('/', [SupplierController::class, 'index'])->name('suppliers.index');
                Route::get('create', [SupplierController::class, 'create'])->name('suppliers.create');
                Route::post('store', [SupplierController::class, 'store'])->name('suppliers.store');
                Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
                Route::post('update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
                Route::get('show/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
                Route::delete('destroy/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
                Route::get('/trash',[SupplierController::class, 'trash'])->name('suppliers.trash');
                Route::put('/{supplier}/restore',[SupplierController::class, 'restore'])->name('suppliers.restore');
                Route::delete('/{supplier}/force-delete',[SupplierController::class, 'forceDelete'])->name('suppliers.force-delete');
            });


            Route::group(['prefix' => 'clients' ], function () {
                Route::get('/', [ClientController::class, 'index'])->name('clients.index');
                Route::get('create', [ClientController::class, 'create'])->name('clients.create');
                Route::post('store', [ClientController::class, 'store'])->name('clients.store');
                Route::get('edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
                Route::post('update/{id}', [ClientController::class, 'update'])->name('clients.update');
                Route::get('show/{client}', [ClientController::class, 'show'])->name('clients.show');
                Route::delete('destroy/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
                Route::get('/trash',[ClientController::class, 'trash'])->name('clients.trash');
                Route::put('/{client}/restore',[ClientController::class, 'restore'])->name('clients.restore');
                Route::delete('/{client}/force-delete',[ClientController::class, 'forceDelete'])->name('clients.force-delete');
            });



            Route::group(['prefix' => 'companies' ], function () {
                Route::get('/', [CompaniesController::class, 'index'])->name('companies.index');
                Route::get('create', [CompaniesController::class, 'create'])->name('companies.create');
                Route::post('store', [CompaniesController::class, 'store'])->name('companies.store');
                Route::get('edit/{id}', [CompaniesController::class, 'edit'])->name('companies.edit');
                Route::post('update/{id}', [CompaniesController::class, 'update'])->name('companies.update');
                Route::get('show/{company}', [CompaniesController::class, 'show'])->name('companies.show');
                Route::delete('destroy/{id}', [CompaniesController::class, 'destroy'])->name('companies.destroy');
                Route::get('/trash',[CompaniesController::class, 'trash'])->name('companies.trash');
                Route::put('/{company}/restore',[CompaniesController::class, 'restore'])->name('companies.restore');
                Route::delete('/{company}/force-delete',[CompaniesController::class, 'forceDelete'])->name('companies.force-delete');
            });

            Route::group(['prefix' => 'tags' ], function () {
                Route::get('/', [TagController::class, 'index'])->name('tags.index');
                Route::get('create', [TagController::class, 'create'])->name('tags.create');
                Route::post('store', [TagController::class, 'store'])->name('tags.store');
                Route::get('edit/{id}', [TagController::class, 'edit'])->name('tags.edit');
                Route::post('update/{id}', [TagController::class, 'update'])->name('tags.update');
                Route::delete('destroy/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
            });

            Route::group(['prefix' => 'attributes' ], function () {
                Route::get('/', [AttributeController::class, 'index'])->name('attributes.index');
                Route::get('create', [AttributeController::class, 'create'])->name('attributes.create');
                Route::post('store', [AttributeController::class, 'store'])->name('attributes.store');
                Route::get('edit/{id}', [AttributeController::class, 'edit'])->name('attributes.edit');
                Route::post('update/{id}', [AttributeController::class, 'update'])->name('attributes.update');
                Route::delete('destroy/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
            });


            Route::group(['prefix' => 'plans'],function(){
                Route::get('/', [PlansController::class, 'index'])->name('plans.index');
                Route::get('create', [PlansController::class, 'create'])->name('plans.create');
                Route::post('store', [PlansController::class, 'store'])->name('plans.store');
                Route::get('edit/{id}', [PlansController::class, 'edit'])->name('plans.edit');
                Route::post('update/{id}', [PlansController::class, 'update'])->name('plans.update');
                Route::delete('destroy/{id}', [PlansController::class, 'destroy'])->name('plans.destroy');
            });


            Route::group(['prefix' => 'subscriptions'],function(){
                Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
                Route::get('create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
                Route::post('store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
                Route::get('edit/{id}', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
                Route::post('update/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
                Route::delete('destroy/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
            });



        });





        // // Route::get('/', function () {
        // //     return view('welcome');
        // // });

        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->middleware(['auth:admin', 'verified'])->name('dashboard');

        // Route::middleware('auth')->group(function () {
        //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // });


});



require __DIR__.'/authadmin.php';
