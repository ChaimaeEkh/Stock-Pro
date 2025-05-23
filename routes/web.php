<?php
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;

// Public routes
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'handleLogin'])->name('handleLogin');

// Registration routes (should be available to guests)
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('handleRegister');

// Secured routes for admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Customer routes - full CRUD operations
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Other existing routes
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/category', [ProductController::class, 'byCategory'])->name('products.byCategory');
    Route::get('/orders/customer', [OrderController::class, 'byCustomer'])->name('orders.byCustomer');

    //export excel route
    Route::get('products-export', [ProductController::class, 'export'])->name('products.export');

    //import excel route
    Route::post('products-import', [ProductController::class, 'import'])->name('products.import');

    //Mail route
    Route::get('/testmail', function() {
        $name = "Chaimae";
        // The email sending is done using the to method on the Mail facade
        Mail::to('chaimaeelkhatib317@gmail.com')->send(new MyTestMail($name));
        return 'mail sent';
    });

    //Language routes
    Route::get('/changeLocale/{locale}', function (string $locale) {
        if (in_array($locale, ['en', 'es', 'fr', 'ar'])) {
            session()->put('locale', $locale);
         }
        return redirect()->back();
    });

    //cookies
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::post('/save-name', 'App\Http\Controllers\DashboardController@saveName')->name('save.name');

    //sessions
    Route::post('/save-session-name', 'App\Http\Controllers\DashboardController@saveSessionName')->name('save.session.name');

    //upload
    Route::post('/upload-avatar', 'App\Http\Controllers\DashboardController@uploadAvatar')->name('upload.avatar');

    //logout
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('custom.logout');
});
