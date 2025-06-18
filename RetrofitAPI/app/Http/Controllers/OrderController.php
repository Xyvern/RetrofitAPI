<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
                'created_at' => Carbon::parse($order->created_at)->translatedFormat('d F Y'),
                'updated_at' => Carbon::parse($order->updated_at)->translatedFormat('d F Y'),
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
            'created_at' => \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y'),
            'updated_at' => \Carbon\Carbon::parse($order->updated_at)->translatedFormat('d F Y'),
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
            'total' => $request->input('total'),
            'status' => $request->input('status', 'pending'),
        ]);
        return response()->json(['message' => 'Order created successfully', 'orderID' => $order->orderID], 201);
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
}
