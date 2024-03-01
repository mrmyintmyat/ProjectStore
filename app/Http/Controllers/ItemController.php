<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Notice;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request as RequestFacade;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Item::where('item_count', '!=', 0)
            ->latest()
            ->paginate(28);
        // $discount_items = Item::where('item_count', '!=', 0)
        // ->whereNotNull('reduced_price')
        // ->get();
        if ($request->ajax()) {
            $page = $request->input('page');
            $items = Item::where('item_count', '!=', 0)
                ->latest()
                ->paginate(28, ['*'], 'page', $page);

            return view('search-results', ['items' => $items])->render();
        }
        return view('index', compact('items'));
    }

    public function cart()
    {
        $carts = null;
        if (Auth::check()) {
            $user = Auth::user();
            $carts = $user->carts()
                ->latest()
                ->get();
        }

        foreach ($carts as $cart) {
            if ($cart->count == 0) {
                $cart->delete();
            }
        }

        return view('carts', compact('carts'));
    }

    public function cart_delete(Request $request)
    {
        // Retrieve the selected item IDs from the request
        $selectedItems = $request->input('item_data');

        // Perform the deletion logic
        foreach ($selectedItems as $title => $item) {
            if (!isset($item['id'])) {
                continue;
            }
            $itemId = $item['id'];
            $cart = Cart::where('item_id', $itemId)->first();

            if ($cart) {
                $cart->delete();
            } else {
                continue;
            }
        }
        return back()->with('success', 'Done');
    }

    public function notice()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $notices = $user->notices()
                ->latest()
                ->paginate(10);
            $expirationDate = Carbon::now()->addDays(1);
            foreach ($notices as $notice) {
                $notice->is_checked = 1;
                if ($notice->expires_at == null) {
                    $notice->expires_at = $expirationDate;
                }

                $notice->save();
            }
        }
        return view('notice', compact('notices'));
    }
    /**
     * Show the form for creating a new resource.
     */

    public function search(Request $request)
    {
        $query = $request->input('query');

        $items = Item::where('title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->get();
        $html = view('search-results', ['items' => $items])->render();
        return response()->json(['html' => $html]);
    }

    //  public function getMoreItems(Request $request)
    //  {
    //      $page = $request->input('page');
    //      $items = Item::paginate(10, ['*'], 'page', $page);

    //      return view('search-results', ['items' => $items])->render();
    //  }

    //add to cart create
    public function create(Request $request)
    {
        $item = Item::find($request->item_id);
        $user = Auth::user();
        if (!$item) {
            return redirect('/')->with('sold_out', 'Sorry,this one is sold out.');
        }
        if ($item->item_count < $request->count) {
            return back()->with('cart_item_left', 'This is only ' . $item->item_count . ' left.');
        }
        if (!$user) {
            return back()->with('cart_item_left', 'Error');
        }

        if ($request->price == 'price') {
            $item_price = $item->price;
        } else {
            $item_price = $item->reduced_price;
        }
        $count = 1; //(int) RequestFacade::get('count')
        $price = filter_var($item_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $pattern = '/^([A-Za-z]+)|([A-Za-z]+)$/';

        if (preg_match($pattern, $item_price, $matches)) {
            $currency_symbol = $matches[0];
            $total = intval($price) * intval($count) . $currency_symbol;
        } else{
            return back()->with('cart_item_left', 'Something went wrong.PLease Contact us!');
        }

        $cart = Cart::where('item_id', $item->id)
            ->where('user_id', $user->id)
            ->first();
        if ($cart) {
            return back()->with('cart_item_left', 'Already added.');
            $cartcount_total = $cart->count + $count;
            if ($cartcount_total <= $item->item_count) {
                $cart->count = $cartcount_total;

                $cartTotal = filter_var($cart->total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $cartTotal = intval($cartTotal);

                $itemTotal = filter_var($total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $itemTotal = intval($itemTotal);

                $cart->total = $itemTotal * $cartcount_total . $currency_symbol;

                if ($request->price == 'price') {
                    $check_price = 'org_price';
                } else {
                    $check_price = 'reduced_price';
                }

                $cart->check_price = $check_price;
                $cart->save();
            } elseif ($item->item_count <= $cartcount_total) {
                $cartcount_total = $item->item_count - $cart->count;
                return back()->with('cart_item_left', 'Already added.');
            }
        } else {
            if ($request->price == 'price') {
                $check_price = 'org_price';
            } else {
                $check_price = 'reduced_price';
            }
            Cart::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'total' => $total,
                'count' => $count,
                'check_price' => $check_price,
            ]);
        }

        return back()->with('success', 'Check Your Cart');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::findOrfail($id);
        $reduced_items = Item::where('item_count', '!=', 0)
            ->whereNotNull('reduced_price')
            ->paginate(6);
        if (!$item) {
            $item = (object) [
                "id" => 16,
                "title" => "Item Not Found Or",
                "about" => "Sold Out!",
                "price" => "MMK0",
                "reduced_price" => null,
                "item_image" => "notfound.avif",
                "item_count" => "0",
                "created_at" => "2023-06-21T05:25:01.000000Z",
                "updated_at" => "2023-06-21T05:25:01.000000Z"
            ];
            return view('detail', compact('item', 'reduced_items'));
        }

        if ($item->item_count == 0) {
            $item = (object) [
                "id" => 16,
                "title" => "Sold out!",
                "about" => "Sold out!",
                "price" => "MMK0",
                "reduced_price" => null,
                "item_image" => "soldout.png",
                "item_count" => "0",
                "created_at" => "2023-06-21T05:25:01.000000Z",
                "updated_at" => "2023-06-21T05:25:01.000000Z"
            ];
            return view('detail', compact('item', 'reduced_items'));
        }

        return view('detail', compact('item', 'reduced_items'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
