<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Notice;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\Mailer\Transport;
// use Symfony\Component\Mailer\Mailer;
// use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->query('item_id');
        return $id;
    }

    /**
     * Display the specified resource.
     */
    public function create_order(Request $request, string $id)
    {
        // return $request;
        if ($request->method() !== 'POST') {
            return redirect('/');
        }

        $item = Item::find($id);
        $user = Auth::user();

        if ($user->email_verified_at == null){
            return redirect()->route('email_verify_form', ['item_id' => $id]);
        }
        $carts = Cart::where('item_id', $id)->get();
        if (!$item) {
            return redirect('/')->with('sold_out', 'Sorry, We deleted this.');
        }
        if ($item->item_count < $request->count) {
            return back()->with('item_left', 'This is only ' . $item->item_count . ' left.');
        }

        $emailuser = new \stdClass();

        if (!$user) {
            // $user_name = $request->name;
            // $user_id = $request->email;

            // $emailuser->name = $user_name;
            // $emailuser->email = $user_id;
            return redirect('/login');
        } else {
            $user_name = $user->name;
            $user_id = $user->id;

            $emailuser = $user;
        }

        if ($request->price == 'price') {
            $item_price = $item->price;
        } else {
            $item_price = $item->reduced_price;
        }
        $count = (int) RequestFacade::get('count');
        $price = filter_var($item_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $pattern = '/^([A-Za-z]+)|([A-Za-z]+)$/';

        if (preg_match($pattern, $item_price, $matches)) {
            $currency_symbol = $matches[0];
            $total = intval($price) * intval($count) . $currency_symbol;
        } else {
            return back()->with('cart_item_left', 'Something went wrong.Please Contact us!');
        }
        $item_count = $item->item_count;// - $count
        $item->item_count = $item_count;
        $item->update();

        $order = Order::where('item_id', $item->id)
            ->where('user_id', $user_id)
            ->latest()
            ->first();
        if ($order && $order->status === 'reviewing') {
            return back()->with('cart_item_left', 'You have already placed your order!');
            // $cartcount_total = $order->count + $count;
            // $order->count = $cartcount_total;

            // $pricetotal = filter_var($order->total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            // $pricetotal = intval($pricetotal);

            // $itemTotal = filter_var($total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            // $itemTotal = intval($itemTotal);

            // $order->total = $pricetotal + $itemTotal . $currency_symbol;
            // $order->update();
        } elseif ($order && $order->status === 'cancelled') {
            $order->status = 'reviewing';
            $order->save();
        } else {
            $order = Order::create([
                'user_id' => $user_id,
                'user_name' => $user_name,
                'item_id' => $item->id,
                'status' => 'reviewing',
                'note' => $request->note,
                'total' => $total,
                'count' => $count,
            ]);
        }

        try {
        Mail::send([], [], function (Message $message) use ($order, $emailuser) {
            $message
                ->to('nextpjofficial@gmail.com')
                ->subject('You have a new order!')
                ->html(view('auth.mail_style.email-order', ['order' => $order, 'user' => $emailuser])->render(), 'text/html');
        });

        foreach ($carts as $cart) {
            // if ($item_count <= $cart->count) {
            //     $cart->count = $item_count;
            //     $total = intval($price) * intval($cart->count) . $currency_symbol;
            //     $cart->total = $total;
            // }
            // $cart->update();
            if ($item_count == 0) {
                $cart->delete();
            }
        }

        } catch (\Exception $e) {
            $item_count = $item->item_count; // + $count
            $item->item_count = $item_count;
            $item->update();

            $order_2 = Order::where('item_id', $item->id)
                ->where('user_id', $user_id)
                ->latest()
                ->first();
            if ($order_2) {
                // $cartcount_total = $order_2->count - $count;
                // $order_2->count = $cartcount_total;

                // $pricetotal = filter_var($order_2->total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                // $pricetotal = intval($pricetotal);

                // $itemTotal = filter_var($total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                // $itemTotal = intval($itemTotal);

                // $order_2->total = $pricetotal - $itemTotal . $currency_symbol;
                // $order_2->update();

                // if ($cartcount_total == 0) {
                //    $order_2->delete();
                // }
                $order_2->delete();
            }

            return view('auth.error_page');
        }

        return back()->with('seccess_order', 'We will mail to you.');
    }

    public function show(){

    }

    public function create_order_cart(Request $request)
    {
        $inputData = [];

         $user = Auth::user();

        if ($user->email_verified_at == null){
            return redirect()->route('email_verify_form', ['cart' => 'cart']);
        }
        // foreach ($request->input() as $key => $value) {
        //     if (is_array($value)) {
        //         $nestedItem = [];
        //         foreach ($value as $nestedKey => $nestedValue) {
        //             $nestedItem[$nestedKey] = $nestedValue;
        //         }
        //         $inputData[$key] = $nestedItem;
        //     } else {
        //         $inputData[$key] = $value;
        //     }
        // }

        foreach ($request->input('item_data', []) as $itemId => $item) {
            if (!isset($item['id'])) {
                continue;
            }

            $id = $item['id'];
            $count = 1; //$item['count']
            $cart_id = $item['cart_id'];
            $item = Item::find($id);
            $carts = Cart::where('item_id', $id)->get();
            $user = Auth::user();
            if (!$item) {
                return redirect('/')->with('sold_out', 'Sorry,this one is sold out,please buy another one.');
            }
            if ($item->item_count < $count) {
                return back()->with('item_left', 'This is only ' . $item->item_count . ' left.');
            }
            $emailuser = new \stdClass();

            if (!$user) {
                return redirect('/login');
            } else {
                $user_name = $user->name;
                $user_id = $user->id;

                $emailuser->name = $user_name;
                $emailuser->email = $user->email;
            }

            $check_cart_price = Cart::findOrfail($cart_id);

            if ($check_cart_price->check_price == 'org_price') {
                $item_price = $item->price;
            } else {
                $item_price = $item->reduced_price;
            }
            $count = (int) $count;
            $price = filter_var($item_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $pattern = '/^([A-Za-z]+)|([A-Za-z]+)$/';
            if (preg_match($pattern, $item_price, $matches)) {
                $currency_symbol = $matches[0];
                $total = intval($price) * intval($count) . $currency_symbol;
            } else {
                return back()->with('cart_item_left', 'Something went wrong.PLease Contact us!');
            }

            $item_count = $item->item_count; // - $count
            $item->item_count = $item_count;
            $item->update();

            $order = Order::where('item_id', $item->id)
                ->where('user_id', $user->id)
                ->latest()
                ->first();
            if ($order && $order->status === 'reviewing') {
                $order = Order::update([
                    'user_id' => $user->id,
                    'user_name' => $user_name,
                    'item_id' => $item->id,
                    'status' => 'reviewing',
                    'total' => $total,
                    'note' => $request->note,
                    'count' => $count,
                ]);
                // continue;
                // $cartcount_total = $order->count + $count;
                // $order->count = $cartcount_total;

                // $pricetotal = filter_var($order->total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                // $pricetotal = intval($pricetotal);

                // $itemTotal = filter_var($total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                // $itemTotal = intval($itemTotal);

                // $order->total = $pricetotal + $itemTotal . $currency_symbol;
                // $order->save();
            } elseif ($order && $order->status === 'cancelled') {
                $order->status = 'reviewing';
                $order->save();
            } else {
                $order = Order::create([
                    'user_id' => $user->id,
                    'user_name' => $user_name,
                    'item_id' => $item->id,
                    'status' => 'reviewing',
                    'total' => $total,
                    'note' => $request->note,
                    'count' => $count,
                ]);
            }

            $inputData['item_data'][$itemId]['id'] = $id;
            $inputData['item_data'][$itemId]['count'] = $count;
            $inputData['item_data'][$itemId]['cart_id'] = $cart_id;
            $inputData['item_data'][$itemId]['order_id'] = $order->id;
        }
        // return $inputData;
        try {
            Mail::send([], [], function (Message $message) use ($inputData, $request) {
                $message
                    ->to('nextpjofficial@gmail.com')
                    ->subject('You have a new order! From Cart.')
                    ->html(view('auth.mail_style.email-cart-order', ['inputData' => $inputData, 'note' => $request->note])->render(), 'text/html');
            });

            // $carts_user = Cart::find($cart_id);

            // if ($carts_user->count == 0) {
            //   $carts_user->delete();
            // }
            // $cart_count_total = $carts_user->count - $count;
            // $carts_user->count = $cart_count_total;
            // $total = intval($price) * intval($carts_user->count) . $currency_symbol;
            // $carts_user->total = $total;
            // $carts_user->update();

            // foreach ($carts as $cart) {
            //     // if ($cart->count <= $item_count) {
            //     //     $cart->count = $item_count;
            //     //     $total = intval($price) * intval($cart->count) . $currency_symbol;
            //     //     $cart->total = $total;
            //     // }
            //     // $cart->update();
            //     if ($item_count == 0) {
            //         $cart->delete();
            //     }
            // }
        } catch (\Exception $e) {
            foreach ($inputData['item_data'] as $itemId => $item) {
                if (!isset($item['id'])) {
                    continue;
                }
                $id = $item['id'];
                $count = $item['count'];
                $cart_id = $item['cart_id'];
                $item = Item::find($id);
                $carts = Cart::where('item_id', $id)->get();
                $user = Auth::user();

                $check_cart_price = Cart::find($cart_id);

                if ($check_cart_price->check_price == 'org_price') {
                    $item_price = $item->price;
                } else {
                    $item_price = $item->reduced_price;
                }
                $count = (int) $count;
                $price = filter_var($item_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pattern = '/^([A-Za-z]+)|([A-Za-z]+)$/';
                if (preg_match($pattern, $item_price, $matches)) {
                    $currency_symbol = $matches[0];
                    $total = intval($price) * intval($count) . $currency_symbol;
                } else {
                    return back()->with('cart_item_left', 'Something went wrong.PLease Contact us!');
                }

                $item_count = $item->item_count;//+ $count
                $item->item_count = $item_count;
                $item->update();

                $order_2 = Order::where('item_id', $item->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($order_2) {
                    // $cartcount_total = $order_2->count - $count;
                    // $order_2->count = $cartcount_total;

                    // $pricetotal = filter_var($order_2->total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    // $pricetotal = intval($pricetotal);

                    // $itemTotal = filter_var($total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    // $itemTotal = intval($itemTotal);

                    // $order_2->total = $pricetotal - $itemTotal . $currency_symbol;
                    // $order_2->update();

                    // if ($cartcount_total == 0) {
                        // $order_2->delete();
                    // }
                    $order_2->delete();
                }

                // $carts_user = Cart::find($cart_id);
                // $cart_count_total = $carts_user->count;
                // $carts_user->count = $cart_count_total;
                // $total = intval($price) * intval($carts_user->count) . $currency_symbol;
                // $carts_user->total = $total;
                // $carts_user->update();

                // foreach ($carts as $cart) {
                //     if ($cart->count <= $item_count) {
                //         $cart->count = $item_count;
                //         $total = intval($price) * intval($cart->count) . $currency_symbol;
                //         $cart->total = $total;
                //     }
                //     $cart->update();
                // }
            }
            return view('auth.error_page');
        }
        foreach ($inputData['item_data'] as $key => $item) {
            $cart_id = $item['cart_id'];
            $cart = Cart::find($cart_id);
            $cart->delete();
        }
        return back()->with('seccess_order', 'We will mail to you.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->method() !== 'POST') {
            return redirect('/');
        }

        $validator = $request->validate([
            'email' => ['required', 'unique:users'],
        ]);

        $user = User::find($id);
        $user->update([
            'email' => $request->email,
        ]);
        Session::put('check_add_or_not', true);
        Session::put('item_id', $request->item_id);
        return redirect()->route('verification.notice');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            if (!$order) {
                return back();
            }

            $order->status = 'cancelled';
            $order->update();
            // $item = Item::find($order->item_id);
            // $item_count = $item->item_count + $order->count;
            // $item->item_count = $item_count;

            // $item->update();
            // $order->delete();

            return back()->with('success', 'Done');
        } catch (\Exception $e) {
            return view('auth.error_page');
        }
    }
}
