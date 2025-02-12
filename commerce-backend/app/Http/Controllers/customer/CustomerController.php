<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function lockAndUnlock($id){
        if (!Auth::user()->isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customer = Customer::where('user_id', $id)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        $customer->is_locked = !$customer->is_locked;
        $customer->save();
        return response()->json(['message' => 'Customer lock status updated successfully']);
    }

    public function showCustomer($id)
    {
        // Fetch the user by ID with additional related data if needed (e.g., roles, posts, etc.)
        $user = User::with(['customer', 'loginSessions', 'logs', 'customerAddresses'])->findOrFail($id);

        return response()->json($user);
    }

    public function storeOrUpdateCustomerAddresses(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'customer_id' => 'required|uuid|exists:users,user_id',
            'billing_address' => 'required|array',
            'billing_address.address_line_1' => 'required|string',
            'billing_address.address_line_2' => 'nullable|string',
            'billing_address.city' => 'required|string',
            'billing_address.state' => 'required|string',
            'billing_address.postal_code' => 'required|string',
            'billing_address.country' => 'required|string',
            'shipping_address' => 'required|array',
            'shipping_address.address_line_1' => 'required|string',
            'shipping_address.address_line_2' => 'nullable|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.postal_code' => 'required|string',
            'shipping_address.country' => 'required|string',
        ]);

        // Check if the customer already has a billing address
        $billingAddress = CustomerAddress::where('customer_id', $validatedData['customer_id'])
        ->where('address_type', 'billing')
        ->first();

        if ($billingAddress) {
            // Update the existing billing address
            $billingAddress->update($validatedData['billing_address']);
        } else {
            // Create a new billing address
            CustomerAddress::create([
                'customer_id' => $validatedData['customer_id'],
                'address_type' => 'billing',
                'address_line_1' => $validatedData['billing_address']['address_line_1'],
                'address_line_2' => $validatedData['billing_address']['address_line_2'],
                'city' => $validatedData['billing_address']['city'],
                'state' => $validatedData['billing_address']['state'],
                'postal_code' => $validatedData['billing_address']['postal_code'],
                'country' => $validatedData['billing_address']['country'],
            ]);
        }

        // Check if the customer already has a shipping address
        $shippingAddress = CustomerAddress::where('customer_id', $validatedData['customer_id'])
        ->where('address_type', 'shipping')
        ->first();

        if ($shippingAddress) {
            // Update the existing shipping address
            $shippingAddress->update($validatedData['shipping_address']);
        } else {
            // Create a new shipping address
            CustomerAddress::create([
                'customer_id' => $validatedData['customer_id'],
                'address_type' => 'shipping',
                'address_line_1' => $validatedData['shipping_address']['address_line_1'],
                'address_line_2' => $validatedData['shipping_address']['address_line_2'],
                'city' => $validatedData['shipping_address']['city'],
                'state' => $validatedData['shipping_address']['state'],
                'postal_code' => $validatedData['shipping_address']['postal_code'],
                'country' => $validatedData['shipping_address']['country'],
            ]);
        }

        return response()->json(['message' => 'Addresses saved or updated successfully.']);
    }
}
