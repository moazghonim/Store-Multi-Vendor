<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view('front.checkout', ['cart' => $cart]);
    }


    public function store(Request $request, CartRepository $cart)
    {

        $items = $cart->get()->groupBy('product.store_id')->all();
        DB::beginTransaction();
        try {

            foreach ($items as $stroe_id => $cart_items) {

                $order =  Order::create([
                    'store_id' => $stroe_id,
                    'user_id'  => Auth::id(),
                    'payment_method' => 'cod',
                ]);

                foreach ($cart_items as $item) {

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            $cart->empty();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
