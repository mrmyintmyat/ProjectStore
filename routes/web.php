<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Orders\OrdersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\SMSNotification;
use Illuminate\Support\Facades\Auth;
use App\Helpers\VerificationHelper;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('/', ItemController::class)->names('items');
Route::get('/', [ItemController::class, 'index'])->name('items.data');
Route::get('/notice', [ItemController::class, 'notice'])->middleware('auth');

Route::get('/detail/{id}', [ItemController::class, 'show'])->name('item.detail');
Route::get('/cart', [ItemController::class, 'cart'])->middleware('auth');
Route::post('/cart/delete', [ItemController::class, 'cart_delete'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile');
Route::put('/profile/{id}', [ProfileController::class, 'update'])->middleware('auth');

// Route::get('/delete/item', function () {
//     return redirect('/');
// });
Route::post('/delete/item', 'App\Http\Controllers\Admin\AdminController@destroy');
Route::get('/admin/items', [AdminController::class, 'items']);
Route::post('/admin/cancel_order', [AdminController::class, 'cancel_order']);
Route::post('/admin/done_order', [AdminController::class, 'done_order']);
Route::resource('/admin', AdminController::class);

Route::resource('/orders', OrdersController::class);
Route::post('/order/{id}', [OrdersController::class, 'create_order'])->name('order.create_order');

Route::post('/carts/order', [OrdersController::class, 'create_order_cart']);

// Route::post('/carts/order', [OrdersController::class, 'create_order_cart']);
Route::post('/user/update/{id}', [OrdersController::class, 'update'])->name('user.update');

Route::post('/search',  [ItemController::class, 'search'])->name('search');
// Route::get('/get-more-items', 'ItemController@getMoreItems');
//email verify
Auth::routes();

Route::get('/verify-email', function (Request $request) {
    $user = Auth::user();
    if ($user) {
        if ($user->email_verified_at == null) {
            $verificationCode = Session::get('verification_email_code');

            if (!$verificationCode) {
                try {
                   $user->notify(new VerifyEmailNotification);
                } catch (\Throwable $th) {
                    return view('auth.error_page');
                }
            }
            Session::put('item_id', $request->input('item_id'));
            return view('auth.verify');
        } else {
            return redirect('/');
        }
    } else {
        return redirect()->route('register');
    }
})->name('email_verify_form');

Route::post('/email_verify', function (Request $request)
{
    $item_id = Session::get('item_id');

      $isVerified = VerificationHelper::verifyEmailCode($request->verification_code);

      if (!$isVerified) {
          return back()->withErrors(['verification_code' => 'Invalid verification code.'])->withInput();
      }
      if ($item_id) {
        Session::forget('item_id');
        return redirect('detail/'. $item_id)->with('success', 'Email verification successful.');
      }
      return redirect('/')->with('success', 'Email verification successful.');
})->name('verify_email');


Route::post('/email/verification-notification', function (Request $request) {
    $user = Auth::user();

    if (!$user) {
        return redirect('/')->with('error', 'User not found');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/')->with('success', 'Email already verified');
    }

    $user->notify(new VerifyEmailNotification);

    return back()->with('success', 'Verification code sent! Please check your email.')->with('resendVerification', true);
})->middleware(['throttle:6,1'])->name('resend_code');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
