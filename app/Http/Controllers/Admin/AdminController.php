<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index()
    {
        $notices = Notice::all();
        $items = Item::all();
        $sevenDaysAgo = Carbon::today()->subDays(6); // Adjust the number of days as needed

        $orderCounts = Order::selectRaw('DATE(updated_at) as date, status, COUNT(*) as count')->where('updated_at', '>=', $sevenDaysAgo)->groupBy('date', 'status')->orderBy('date')->get();

        // Initialize arrays to store counts for each status
        $reviewingCounts = [];
        $doneCounts = [];
        $cancelledCounts = [];
        $labels = [];

        $currentDate = $sevenDaysAgo->copy();
        $endDate = Carbon::today();

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');
            // Find counts for each status for the current date
            $reviewingCount = $orderCounts->where('date', $formattedDate)->where('status', 'reviewing')->first();
            $doneCount = $orderCounts->where('date', $formattedDate)->where('status', 'done')->first();
            $cancelledCount = $orderCounts->where('date', $formattedDate)->where('status', 'cancelled')->first();

            // Store counts for each status
            $reviewingCounts[] = $reviewingCount ? $reviewingCount->count : 0;
            $doneCounts[] = $doneCount ? $doneCount->count : 0;
            $cancelledCounts[] = $cancelledCount ? $cancelledCount->count : 0;

            $labels[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Prepare chart data
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Reviewing',
                    'data' => $reviewingCounts,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Done',
                    'data' => $doneCounts,
                    'backgroundColor' => '#00ffbf',
                    'borderColor' => '#00ffbf',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Cancelled',
                    'data' => $cancelledCounts,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];

        foreach ($items as $item) {
            $order = Order::where('item_id', $item->id)->first();

            if ($item->item_count == 0 && $order == null) {
                $item->delete();
            }
        }

        foreach ($notices as $notice) {
            if ($notice->expires_at <= Carbon::now()) {
                $notice->delete();
            }
        }
        return view('admin_panel.admin_home', compact('chartData'));
    }

    public function create()
    {
        return view('admin_panel.admin_create_item');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'item_img/';
            $item_img = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $item_img);
            $image = "$item_img";
        }

        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'about' => 'nullable',
        ]);

        Item::create([
            'item_image' => $image,
            'title' => $request->title,
            'about' => $request->about,
            'price' => $request->price,
            'item_count' => $request->count,
        ]);

        return redirect('/admin/create')->with('success', 'Done');
    }

    public function items()
    {
        $items = Item::latest()->paginate(10);
        return view('admin_panel.admin_items', compact('items'));
    }
    public function show(Request $request)
    {
        $status = $request->input('status', 'reviewing');
        $orders = Order::where('status', '=', $status)->paginate(10);
        return view('admin_panel.admin_orders_item', compact('orders'));
    }

    public function edit($id)
    {
        $item = Item::find($id);
        return view('admin_panel.admin_edit_item', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $input = $request->all();
        if ($request->hasfile('image') && $request->has('image')) {
            $filepath = 'item_img/' . $item->image;
            if (File::exists($filepath)) {
                File::delete($filepath);
            }
            $image = $request->file('image');
            $destinationPath = 'item_img/';
            $item_img = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $item_img);
            $image = "$item_img";
            $item->item_image = $image;
        }
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required',
            'about' => 'required',
            'count' => 'required',
            'price' => 'required',
        ]);

        $item->title = $request->title;
        $item->about = $request->about;
        $item->price = $request->price;
        $item->item_count = $request->count;
        $item->created_at = now();

        if ($request->has('reduced_price')) {
            $item->reduced_price = $request->reduced_price;
        } else {
            $item->reduced_price = null;
        }
        $item->update();

        //cart
        if ($item->reduced_price != null) {
            $item_price = $item->price;
        } else {
            $item_price = $item->reduced_price;
        }
        $price = filter_var($item_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $pattern = '/^([A-Za-z]+)|^(\$)/';
        if (preg_match($pattern, $item_price, $matches)) {
            $currency_symbol = $matches[0];
            // $total = $currency_symbol . intval($price) * intval($count);
        }

        $carts = Cart::where('item_id', $item->id)->get();
        foreach ($carts as $cart) {
            if ($item->item_count <= $cart->count) {
                $cart->count = $item->item_count;
                $total = $currency_symbol . intval($price) * intval($cart->count);
                $cart->total = $total;
            }
            $cart->update();
            if ($item->item_count == 0) {
                $cart->delete();
            }
        }

        return back()->with('success', 'Done');
    }

    public function destroy(Request $request)
    {
        $itemIds = $request->input('item_ids');

        foreach ($itemIds as $itemId) {
            $item = Item::find($itemId);

            if (!$item) {
                continue;
            }

            $filepath = 'item_img/' . $item->item_image;
            if (File::exists($filepath)) {
                File::delete($filepath);
            } else {
                return view('auth.error_page');
            }
            
            $orders = Order::where('item_id', $itemId)->get();
            $carts = Cart::where('item_id', $itemId)->get();

            foreach ($orders as $order) {
                Notice::create([
                    'user_id' => $order->user_id,
                    'title' => 'Cancelled Order',
                    'message' => 'Your ' . $item->title . ' order has been cancelled.',
                ]);

                $order->delete();
            }

            foreach ($carts as $cart) {
                Notice::create([
                    'user_id' => $cart->user_id,
                    'title' => 'Deleted Cart Item',
                    'message' => 'Your ' . $item->title . ' cart has been deleted.',
                ]);

                $cart->delete();
            }

            $item->delete();
        }

        return back()->with('success', 'Items deleted successfully');
    }

    public function cancel_order(Request $request)
    {
        $orderids = $request->input('order_ids');

        foreach ($orderids as $id) {
            $order = Order::find($id);
            if (!$order) {
                continue;
            }

            $item = Item::find($order->item_id);
            Notice::create([
                'user_id' => $order->user_id,
                'title' => 'Cancelled Order',
                'message' => 'Your ' . $item->title . ' order has been cancelled.',
            ]);
            // $item_count = $item->item_count + $order->count;
            // $item->item_count = $item_count;
            $item->update();
            $order->status = 'cancelled';
            $order->save();

        }
        return back()->with('success', 'Done');
    }

    public function done_order(Request $request)
    {
        $orderids = $request->input('order_ids');

        foreach ($orderids as $id) {
            $order = Order::findOrFail($id);
            if (!$order) {
                continue;
            }

            $item = Item::find($order->item_id);
            $noti = Notice::create([
                'user_id' => $order->user_id,
                'title' => 'Thank You for Your Order',
                'message' => 'Thank you for your order of ' . $item->title . '! We appreciate your business and hope you enjoy your purchase.',
            ]);

            $item_sales = $item->sales + 1;
            $item->sales = $item_sales;
            $item->update();
            $order->status = 'done';
            $order->save();

        }
        return back()->with('success', 'Done');
    }
}