<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $orders = Order::with('user')->get()->map(function ($order) {
            return [
                'orderID' => $order->orderID,
                'userID' => $order->userID,
                'customer_name' => $order->user->name ?? 'Unknown',
                'customer_phone' => $order->user->phone ?? 'Unknown',
                'subtotal' => $order->subtotal,
                'shipping_fee' => $order->shipping_fee,
                'total' => $order->total,
                'status' => $order->status,
                'prep_time' => $order->prep_time,
                'created_at' => Carbon::parse($order->created_at)->translatedFormat('d F Y H:i'),
                'updated_at' => Carbon::parse($order->updated_at)->translatedFormat('d F Y H:i'),
                'order_details' => $order->orderDetails->map(function ($detail) {
                    return [
                        'orderDetailID' => $detail->orderDetailID,
                        'productID' => $detail->productID,
                        'product_name' => $detail->product->name ?? 'Unknown',
                        'quantity' => $detail->quantity,
                        'price' => $detail->price,
                        'total' => $detail->quantity * $detail->price,
                        'addons' => $detail->orderAddons->map(function ($addon) {
                            return [
                                'orderAddonID' => $addon->orderAddonID,
                                'addon_name' => $addon->addon_name,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json($orders, 200);
    }

    public function getOrderById($id)
    {
        $order = Order::with([
            'user',
            'orderDetails.product',
            'orderDetails.orderAddons'
        ])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $formattedOrder = [
            'orderID' => $order->orderID,
            'userID' => $order->userID,
            'customer_name' => $order->user->name ?? 'Unknown',
            'customer_phone' => $order->user->phone ?? 'Unknown',
            'subtotal' => $order->subtotal,
            'shipping_fee' => $order->shipping_fee,
            'total' => $order->total,
            'status' => $order->status,
            'prep_time' => $order->prep_time,
            'created_at' => \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i'),
            'updated_at' => \Carbon\Carbon::parse($order->updated_at)->translatedFormat('d F Y H:i'),
            'order_details' => $order->orderDetails->map(function ($detail) {
                return [
                    'orderDetailID' => $detail->orderDetailID,
                    'productID' => $detail->productID,
                    'product_name' => $detail->product->name ?? 'Unknown',
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total' => $detail->quantity * $detail->price,
                    'addons' => $detail->orderAddons->map(function ($addon) {
                        return [
                            'orderAddonID' => $addon->orderAddonID,
                            'addon_name' => $addon->addon_name,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($formattedOrder, 200);
    }
    
    public function getOrderByUserID($userid)
    {
        $orders = Order::with('orderDetails.orderAddons')->where('userID', $userid)->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found for this user'], 404);
        }
        return response()->json($orders, 200);
    }
    public function createOrder(Request $request)
    {
        $order = Order::create([
            'userID' => $request->input('userID'),
            'subtotal' => $request->input('subtotal'),
            'shipping_fee' => $request->input('shipping_fee', 0),
            'prep_time' => $request->input('prep_time'),
            'total' => $request->input('total'),
            'status' => $request->input('status', 'pending'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        foreach ($request->order_details as $detail) {
            $orderdetail = OrderDetail::create([
                'productID' => $detail['productID'],
                'quantity' => $detail['quantity'],
                'price' => $detail['price'],
                'orderID' => $order->orderID,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            OrderAddon::create([
                'orderDetailID' => $orderdetail->orderDetailID,
                'addon_name' => $detail['addons']['addon_name'],
            ]);

            $user = User::find($request->input('userID'));
            if ($user) { 
                $orderTotal = $request->input('total');
                $user->credit -= $orderTotal; 
                $user->save(); 
            }   
        
            
        }
        return response()->json(['message' => 'Order created successfully'], 201);
    
    }
    public function updateOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update([
            'userID' => $request->input('userID', $order->userID),
            'subtotal' => $request->input('subtotal', $order->subtotal),
            'shipping_fee' => $request->input('shipping_fee', $order->shipping_fee),
            'total' => $request->input('total', $order->total),
            'status' => $request->input('status', $order->status),
        ]);
        return response()->json(['message' => 'Order updated successfully'], 200);
    }
    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
    public function rejectOrder($id)
    {
        $order = Order::find($id);
        if (!$order || $order->status !== 'pending') {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update(['status' => 'rejected']);
        return response()->json(['message' => 'Order rejected successfully'], 200);
    }

    public function acceptOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order || $order->status !== 'pending') {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update(['status' => 'cooking', 'prep_time' => $request->input('prep_time', $order->prep_time)]);
        return response()->json(['message' => 'Order accepted successfully'], 200);
    }

    public function shipOrder($id)
    {
        $order = Order::find($id);
        if (!$order || $order->status !== 'cooking') {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update(['status' => 'shipping']);
        return response()->json(['message' => 'Order shipped successfully'], 200);
    }

    public function completeOrder($id)
    {
        $order = Order::find($id);
        if (!$order || $order->status !== 'shipping') {
            return response()->json(['message' => 'Order not found or not in the correct status'], 404);
        }
        $order->update(['status' => 'completed']);
        return response()->json(['message' => 'Order completed successfully'], 200);
    }

    public function getPendingOrders(){
        $orders = Order::with('user')
            ->where('status', 'pending')
            ->get()
            ->map(function ($order) {
            return [
                'orderID' => $order->orderID,
                'userID' => $order->userID,
                'customer_name' => $order->user->name ?? 'Unknown',
                'customer_phone' => $order->user->phone ?? 'Unknown',
                'subtotal' => $order->subtotal,
                'shipping_fee' => $order->shipping_fee,
                'total' => $order->total,
                'status' => $order->status,
                'prep_time' => $order->prep_time,
                'created_at' => Carbon::parse($order->created_at)->translatedFormat('d F Y H:i'),
                'updated_at' => Carbon::parse($order->updated_at)->translatedFormat('d F Y H:i'),
                'order_details' => $order->orderDetails->map(function ($detail) {
                return [
                    'orderDetailID' => $detail->orderDetailID,
                    'productID' => $detail->productID,
                    'product_name' => $detail->product->name ?? 'Unknown',
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total' => $detail->quantity * $detail->price,
                    'addons' => $detail->orderAddons->map(function ($addon) {
                    return [
                        'orderAddonID' => $addon->orderAddonID,
                        'addon_name' => $addon->addon_name,
                    ];
                    }),
                ];
                }),
            ];
            });

        return response()->json($orders, 200);
    }

    public function getActiveOrders(){
        $orders = Order::with('user')
            ->whereIn('status', ['cooking', 'shipping', 'completed', 'rejected'])
            ->get()
            ->map(function ($order) {
                return [
                    'orderID' => $order->orderID,
                    'userID' => $order->userID,
                    'customer_name' => $order->user->name ?? 'Unknown',
                    'customer_phone' => $order->user->phone ?? 'Unknown',
                    'subtotal' => $order->subtotal,
                    'shipping_fee' => $order->shipping_fee,
                    'total' => $order->total,
                    'status' => $order->status,
                    'prep_time' => $order->prep_time,
                    'created_at' => Carbon::parse($order->created_at)->translatedFormat('d F Y H:i'),
                    'updated_at' => Carbon::parse($order->updated_at)->translatedFormat('d F Y H:i'),
                    'order_details' => $order->orderDetails->map(function ($detail) {
                        return [
                            'orderDetailID' => $detail->orderDetailID,
                            'productID' => $detail->productID,
                            'product_name' => $detail->product->name ?? 'Unknown',
                            'quantity' => $detail->quantity,
                            'price' => $detail->price,
                            'total' => $detail->quantity * $detail->price,
                            'addons' => $detail->orderAddons->map(function ($addon) {
                                return [
                                    'orderAddonID' => $addon->orderAddonID,
                                    'addon_name' => $addon->addon_name,
                                ];
                            }),
                        ];
                    }),
                ];
            });

        return response()->json($orders, 200);
    }
}
