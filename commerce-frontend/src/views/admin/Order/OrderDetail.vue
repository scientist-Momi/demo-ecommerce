<template>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl">Order</h1>
        <router-link :to="{ name: 'app.product.new' }">
            <div class="bg-blue-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center">
                <span class="material-symbols-outlined">
                    add
                </span>
                <p>New Product</p>
            </div>
        </router-link>
    </div>

    <div class="flex flex-col lg:flex-row space-x-2 mb-4">


        <div class="bg-white p-6 flex-1 rounded-md shadow-md">
            <h1 class="font-semibold">Order Status</h1>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        network_check
                    </span>
                    <p class="text-sm">Current Status</p>
                </div>
                <div class="bg-red-500 p-[0.3rem] rounded-md text-[0.75rem] w-fit text-white">
                    processing
                </div>
            </div>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <p class="text-sm">Update Order Status</p>
                </div>
                <!-- <p class="text-sm font-semibold">03/07/2024</p> -->
                <select class="p-[0.4rem] text-sm bg-gray-200 border-none focus:ring-0 cursor-pointer">
                    <option value="">Status</option>
                    <option value="">Delivered</option>
                    <option value="">Processing</option>
                    <option value="">Cancelled</option>
                    <option value="">Shipped</option>
                </select>
            </div>
            <div class="flex justify-end items-center text-gray-500 py-3 mt-1">
                <div
                    class="bg-blue-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center rounded hover:bg-blue-500">
                    <p>Initiate Update</p>
                </div>
            </div>
        </div>


        <div class="bg-white p-6 flex-1 rounded-md shadow-md">
            <h1 class="font-semibold">Order Details (#{{ orderId }})</h1>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        calendar_month
                    </span>
                    <p class="text-sm">Date Added</p>
                </div>
                <p class="text-sm font-semibold">03/07/2024</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        account_balance_wallet
                    </span>
                    <p class="text-sm">Payment Method</p>
                </div>
                <p class="text-sm font-semibold">Apple Pay</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        local_shipping
                    </span>
                    <p class="text-sm">Shipping Method</p>
                </div>
                <p class="text-sm font-semibold">EVRI</p>
            </div>

        </div>


        <div class="bg-white p-6 flex-1 rounded-md shadow-md">
            <h1 class="font-semibold">Customer Details</h1>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        person
                    </span>
                    <p class="text-sm">Customer</p>
                </div>
                <router-link :to="{ name: 'app.product.new' }">
                    <p class="text-sm font-semibold hover:text-green-500">Jay Srhye</p>
                </router-link>
            </div>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        mail
                    </span>
                    <p class="text-sm">Email</p>
                </div>
                <p class="text-sm font-semibold">03/07/2024</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        call
                    </span>
                    <p class="text-sm">Phone</p>
                </div>
                <p class="text-sm font-semibold">03/07/2024</p>
            </div>
        </div>
    </div>


    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2 cursor-pointer" @click="activeTab = 'list'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'list' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">list_alt</span>
                    <p>List</p>
                </div>
            </li>
            <li class="me-2 cursor-pointer" @click="activeTab = 'history'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'history' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">timeline</span>
                    <p>History</p>
                </div>
            </li>
            <li class="me-2 cursor-pointer" @click="activeTab = 'data'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'data' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">rss_feed</span>
                    <p>Data</p>
                </div>
            </li>
        </ul>
    </div>


    <div class="flex flex-col lg:flex-row space-x-2 mb-4">
        <div class="bg-white p-6 flex-1 rounded-md shadow-md flex justify-between items-center">
            <div>
                <h1 class="font-semibold">Billing Address</h1>
                <div class="flex justify-between mt-3">
                    <div class="text-xs">
                        <p>503 Broadway Residences.</p>
                        <p>105 Broad Street, B15 1BH</p>
                        <p>Birmingham, West Midlands.</p>
                        <p>United Kingdom.</p>
                    </div>

                </div>
            </div>
            <span class="material-symbols-outlined text-9xl text-gray-200">
                payments
            </span>

        </div>
        <div class="bg-white p-6 flex-1 rounded-md shadow-md flex justify-between items-center">
            <div>
                <h1 class="font-semibold">Shipping Address</h1>
                <div class="flex justify-between mt-3">
                    <div class="text-xs">
                        <p>503 Broadway Residences.</p>
                        <p>105 Broad Street, B15 1BH</p>
                        <p>Birmingham, West Midlands.</p>
                        <p>United Kingdom.</p>
                    </div>
                </div>
            </div>

            <span class="material-symbols-outlined text-9xl text-gray-200">
                airport_shuttle
            </span>
        </div>
    </div>


    <div v-if="activeTab === 'list'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <h1 class="font-semibold">Order #{{ orderId }}</h1>

            <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">PRODUCT</th>
                        <th scope="col" class="px-6 py-3">QTY</th>
                        <th scope="col" class="px-6 py-3">UNIT PRICE</th>
                        <th scope="col" class="px-6 py-3">DISCOUNT</th>
                        <th scope="col" class="px-6 py-3">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="relative cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 font-bold">
                        <th scope="row"
                            class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:text-blue-500">
                            <div class="flex items-center space-x-4">
                                <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                                    alt="" class="h-12 w-12 rounded">
                                <div class="text-gray-500">
                                    <h2 class="font-bold mb-1">Product 1</h2>
                                    <p>Delivery Date: 03/07/2024</p>
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">2</td>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">£200.00</td>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">£10.00</td>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">£190.00</td>
                    </tr>
                    <tr
                        class="relative cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 font-bold">
                        <th scope="row"
                            class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:text-blue-500">
                            <div class="flex items-center space-x-4">
                                <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                                    alt="" class="h-12 w-12 rounded">
                                <div class="text-gray-500">
                                    <h2 class="font-bold mb-1">Product 1</h2>
                                    <p>Delivery Date: 03/07/2024</p>
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">2</td>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">£200.00</td>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">£10.00</td>
                        <td class="px-6 py-3 uppercase hover:text-blue-600">£190.00</td>
                    </tr>
                    <tr class="relative bg-white border-b font-bold">
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                        <td class="px-6 py-5">Subtotal</td>
                        <td class="px-6 py-5">£190.00</td>
                    </tr>
                    <tr class="relative bg-white border-b font-bold">
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                        <td class="px-6 py-5">VAT (0%)</td>
                        <td class="px-6 py-5">£0.00</td>
                    </tr>
                    <tr class="relative bg-white border-b font-bold">
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                        <td class="px-6 py-5">Shipping Rate</td>
                        <td class="px-6 py-5">£10.00</td>
                    </tr>
                    <tr class="relative bg-white font-bold">
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                        <td class="px-6 py-5 text-base font-semibold text-black">Grand Total</td>
                        <td class="px-6 py-5 text-base font-semibold text-black">£190.00</td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>





    <div v-if="activeTab === 'history'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <h1 class="font-semibold">Order History</h1>

            <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-lg mt-4">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">DATE ADDED</th>
                        <th scope="col" class="px-6 py-3">COMMENT</th>
                        <th scope="col" class="px-6 py-3">ORDER STATUS</th>
                        <th scope="col" class="px-6 py-3">CUSTOMER NOTIFIED</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="relative cursor-pointer bg-white border-b font-bold">
                        <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                            04/07/2024
                        </th>
                        <td class="px-6 py-3">Order Delivered</td>
                        <td class="px-6 py-3">
                            <div class="bg-red-500 p-[0.3rem] rounded-md text-[0.75rem] w-fit text-white">
                                processing
                            </div>
                        </td>
                        <td class="px-6 py-3">Yes</td>
                    </tr>
                    <tr class="relative cursor-pointer bg-white border-b font-bold">
                        <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                            04/07/2024
                        </th>
                        <td class="px-6 py-3">Order Shipped</td>
                        <td class="px-6 py-3">
                            <div class="bg-green-500 p-[0.3rem] rounded-md text-[0.75rem] w-fit text-white">
                                shipped
                            </div>
                        </td>
                        <td class="px-6 py-3">Yes</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="activeTab === 'data'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <h1 class="font-semibold">Order Data</h1>
            <div class="border-b flex justify-between text-sm py-4">
                <p class="text text-gray-500">IP Address</p>
                <p>172.89.789.00</p>
            </div>
            <div class="border-b flex justify-between text-sm py-4">
                <p class="text text-gray-500">Forwarded IP</p>
                <p>82.89.789.00</p>
            </div>
            <div class="flex justify-between text-sm py-4">
                <p class="text text-gray-500">User Agent</p>
                <p>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110
                    Safari/537.36</p>
            </div>
        </div>
    </div>





</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const orderId = ref(route.params.orderId);
const activeTab = ref('list');

// Fetch order details based on the orderId
onMounted(() => {
    console.log('Order ID:', orderId.value);
    // You can use orderId.value to fetch the order details from your API
});
</script>