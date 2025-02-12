<template>
    <div class="relative p-4 bg-white">
        <div class="flex mb-3 justify-between items-center">
            <div class="border flex items-center bg-gray-100 p-2 space-x-2 rounded-[0.25rem]">
                <span class="material-symbols-outlined">
                    search
                </span>
                <input type="text" name="" id="" placeholder="Search Order"
                    class="bg-gray-100 border-0 p-[0.25rem] focus:ring-0 focus:border-0 rounded-[0.25rem] text-sm">
            </div>

            <div class="flex space-x-2 relative">
                <div class="relative border">
                    <div class="flex items-center bg-gray-100 space-x-2 rounded-[0.25rem]">
                        <input v-model="dateRangeText" @focus="showDatePicker = true" type="text"
                            placeholder="Select date range"
                            class="bg-gray-100 border-0 p-2 focus:ring-0 focus:border-0 rounded-[0.25rem] text-sm"
                            readonly />
                        <span class="material-symbols-outlined p-2 hover:bg-gray-200 text-base font-bold cursor-pointer"
                            @click="clearDateRange">
                            close
                        </span>
                    </div>
                </div>

                <div v-if="showDatePicker"
                    class="absolute z-50 mt-12 w-auto p-4 border rounded bg-white shadow-lg text-sm">
                    <div class="flex">
                        <div class="">
                            <label for="start" class="mb-1">Start Date</label>
                            <input v-model="startDate" type="date" id="start" class="text-sm border rounded p-2 mb-2" />
                        </div>
                        <div class="">
                            <label for="end" class="mb-1">End Date</label>
                            <input v-model="endDate" type="date" id="end" class="text-sm border rounded p-2" />
                        </div>
                    </div>
                    <button @click="applyDateRange"
                        class="mt-2 p-2 bg-blue-500 text-white rounded w-full">Apply</button>

                </div>

                <div class="relative">
                    <button @click="statusToggleDropdown"
                        class="bg-gray-100 font-medium rounded text-sm px-5 py-2.5 text-center inline-flex items-center"
                        type="button">
                        {{ selectedStatus }}
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <div v-show="statusDropdownVisible"
                        class="absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li v-for="status in statuses" :key="status">
                                <a href="#" @click.prevent="selectStatus(status)"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                            status }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-lg">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">ORDER ID</th>
                    <th scope="col" class="px-6 py-3">CUSTOMER</th>
                    <th scope="col" class="px-6 py-3">STATUS</th>
                    <th scope="col" class="px-6 py-3">TOTAL</th>
                    <th scope="col" class="px-6 py-3">DATE ADDED</th>
                    <th scope="col" class="px-6 py-3">DATE MODIFIED</th>
                    <th scope="col" class="px-6 py-3">OPERATIONS</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, index) in orders" :key="order.id"
                    class="relative cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 font-bold">
                    <th @click="navigateToOrder(order.id)" scope="row"
                        class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:text-blue-500">
                        #{{ order.id }}
                    </th>
                    <td class="px-6 py-3 uppercase hover:text-blue-600">{{ order.customer }}</td>
                    <td class="px-6 py-3">
                        <!-- {{ order.status }} -->
                        <div v-if="order.status === 'cancelled' || order.status === 'returned'"
                            class="bg-red-500 p-[0.3rem] rounded-md text-[0.75rem] w-fit text-white">
                            {{ order.status }}
                        </div>
                        <div v-else-if="order.status === 'processing'"
                            class="bg-yellow-500 p-1 rounded-lg text-[0.75rem] w-fit text-white">
                            {{ order.status }}
                        </div>
                        <div v-else-if="order.status === 'pending'"
                            class="bg-blue-500 p-1 rounded-lg text-[0.75rem] w-fit text-white">
                            {{ order.status }}
                        </div>

                        <div v-else-if="order.status === 'delivered' || order.status === 'shipped'"
                            class="bg-green-500 p-1 rounded-lg text-[0.75rem] w-fit text-white">
                            {{ order.status }}
                        </div>

                    </td>
                    <td class="px-6 py-3">{{ order.total }}</td>
                    <td class="px-6 py-3">{{ order.dateAdded }}</td>
                    <td class="px-6 py-3">{{ order.dateModified }}</td>
                    <td class="px-6 py-3 relative" v-click-outside="() => closeDropdown(index) ">
                        <button @click="toggleDropdown(index)"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium text-sm px-3 py-2 text-center inline-flex items-center"
                            type="button">
                            Actions
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div v-show="dropdownVisible[index]"
                            class="absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 right-0 mt-2">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, computed, watch, reactive } from 'vue';
import { useRouter } from 'vue-router';
import vClickOutside from '../../../modules/v-click-outside.js';
import { format } from 'date-fns';

// Sample orders data
const orders = ref([
    { id: '1234', customer: 'Silver Rase', status: 'shipped', total: '$2999', dateAdded: '01/01/2022', dateModified: '02/01/2022' },
    { id: '5678', customer: 'Hugh Csee', status: 'pending', total: '$1599', dateAdded: '03/01/2022', dateModified: '04/01/2022' },
    { id: '5678', customer: 'Olurase frorew', status: 'cancelled', total: '$1599', dateAdded: '03/01/2022', dateModified: '04/01/2022' },
    { id: '5678', customer: 'Gold raw', status: 'processing', total: '$1599', dateAdded: '03/01/2022', dateModified: '04/01/2022' },
    // Add more orders here
]);

const dropdownVisible = ref({});

const toggleDropdown = (index) => {
    dropdownVisible.value[index] = !dropdownVisible.value[index];
};

const closeDropdown = (index) => {
    dropdownVisible.value[index] = false;
};

const router = useRouter();

const navigateToOrder = (orderId) => {
    router.push({ name: 'app.order.detail', params: { orderId } });
};
// Reactive references
const startDate = ref('');
const endDate = ref('');
const showDatePicker = ref(false);
const dateRangeText = ref('');

// Function to format date
const formatDate = (dateStr) => {
    const date = new Date(dateStr);
    return format(date, 'dd MMM yyyy'); // Change this format to your desired format
};

// Function to apply date range
const applyDateRange = () => {
    if (startDate.value && endDate.value) {
        const formattedStartDate = formatDate(startDate.value);
        const formattedEndDate = formatDate(endDate.value);
        dateRangeText.value = `${formattedStartDate} - ${formattedEndDate}`;
    }
    showDatePicker.value = false;
};

// Function to clear date range
const clearDateRange = () => {
    startDate.value = '';
    endDate.value = '';
    dateRangeText.value = '';
    closeDatePicker();
};

// Function to close date picker
const closeDatePicker = () => {
    showDatePicker.value = false;
};



const statusDropdownVisible = ref(false);
const selectedStatus = ref('Status');
const statuses = ref(['All', 'Shipped', 'Pending', 'Cancelled', 'Processing']);

const statusToggleDropdown = () => {
    statusDropdownVisible.value = !statusDropdownVisible.value;
};

const selectStatus = (status) => {
    selectedStatus.value = status;
    statusDropdownVisible.value = false; // Close the dropdown after selection
};

</script>