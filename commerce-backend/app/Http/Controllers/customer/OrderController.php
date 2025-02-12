<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orderStatus = request('order_status', '');
        $perPage = request('per_page', 10);
        $search = request('search', '');


        $query = Order::with('customer')
            ->when($orderStatus, function ($query, $orderStatus) {

                $query->where('order_status', $orderStatus);
            })
            ->when($search, function ($query, $search) {

                $query->whereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return OrderResource::collection($query);
    }

    public function getCustomerOrders($customerId)
    {
        $orderStatus = request('status', '');
        $perPage = request('per_page', 10);
        $search = request('search', '');

        $query = Order::where('customer_id', $customerId)
            ->when($orderStatus, function ($query, $orderStatus) {

                $query->where('status', $orderStatus);
            })
            ->when($search, function ($query, $search) {

                $query->where('order_id', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return OrderResource::collection($query);
    }


}
