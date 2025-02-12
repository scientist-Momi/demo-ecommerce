<template>
    <DecisionModal :show-modal="showLockModal" @close="closeModal"
        :question="'Are you sure you want to update Customer status?'" :loading-message="'Updating status......'"
        :header="'Status Update'" @confirmed="handleConfirmed" />

    <Modal :showModal="showEditModal" @close="showEditModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                person_add
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Edit Customer Details</h3>
        </template>
        <EditCustomer />
    </Modal>

    <Modal :showModal="showAddressModal" @close="showAddressModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                person_add
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Edit Customer Addresses</h3>
        </template>
        <UpdateAddress :user="user" :address="address" :billing-address="billingAddress" :shipping-address="shippingAddress"/>
    </Modal>
    <Modal :showModal="showPasswordModal" @close="showPasswordModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                person_add
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Change Password</h3>
        </template>
        <ChangePassword />
    </Modal>


    <div v-if="customer.is_locked" class="bg-red-300 p-3 flex space-x-2 text-sm items-center">
        <span class="material-symbols-outlined">
            info
        </span>
        <p>This customer is currently locked, which means they do not have access to making orders.</p>
    </div>
    <div class="flex flex-col lg:flex-row space-x-2 mb-4 mt-4">


        <div class="bg-white p-6 w-[30%] rounded-md shadow-md">
            <div class="flex justify-between">
                <h1 class="font-semibold">Customer Details </h1>
                <div @click="showEditModal = true"
                    class="bg-red-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center rounded">
                    <!-- <span class="material-symbols-outlined">
                        manage_accounts
                    </span> -->
                    <p>Edit User</p>
                </div>
            </div>

            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1 space-x-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        person
                    </span>
                    <p class="text-sm">Name</p>
                </div>
                <p class="text-sm font-semibold">{{ user.firstname }} {{ user.lastname }}</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1 space-x-2">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        mail
                    </span>
                    <p class="text-sm">Email</p>
                </div>
                <p class="text-sm font-semibold">{{ user.email }}</p>
            </div>

        </div>


        <div class="bg-white p-6 w-[30%] rounded-md shadow-md">
            <h1 class="font-semibold">Customer Details </h1>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        call
                    </span>
                    <p class="text-sm">Phone</p>
                </div>
                <p class="text-sm font-semibold">{{ user.phone }}</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        badge
                    </span>
                    <p class="text-sm">Last Order</p>
                </div>
                <!-- <p class="text-sm font-semibold uppercase">{{ admin?.role }}</p> -->
            </div>


        </div>


        <div class="bg-white p-6 w-[40%] rounded-md shadow-md">

            <div class="flex justify-between">
                <h1 class="font-semibold">Customer Address</h1>
                <div @click="showAddressModal = true"
                    class="bg-red-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center rounded">
                    <!-- <span class="material-symbols-outlined">
                        manage_accounts
                    </span> -->
                    <p>Edit Address</p>
                </div>
            </div>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1 border-b">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        home_pin
                    </span>
                    <p class="text-sm">Delivery Address</p>
                </div>
                <div v-if="shippingAddress">
                    <p class="text-sm">{{ shippingAddress.address_line_1 }}</p>
                    <p class="text-sm">{{ shippingAddress.city }}, {{ shippingAddress.state }}</p>
                    <p class="text-sm">{{ shippingAddress.postal_code }}, {{ shippingAddress.country }}</p>
                </div>
            </div>

            <!-- Display Billing Address -->
            <div class="flex justify-between items-start text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        home_pin
                    </span>
                    <p class="text-sm">Billing Address</p>
                </div>
                <div v-if="billingAddress">
                    <p class="text-sm">{{ billingAddress.address_line_1 }}</p>
                    <p class="text-sm">{{ billingAddress.city }}, {{ billingAddress.state }}</p>
                    <p class="text-sm">{{ billingAddress.postal_code }}, {{ billingAddress.country }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2 cursor-pointer" @click="activeTab = 'transaction'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'transaction' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">
                        lock
                    </span>
                    <p>Transactions</p>
                </div>
            </li>
            <li class="me-2 cursor-pointer" @click="activeTab = 'security'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'security' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">
                        lock
                    </span>
                    <p>Security</p>
                </div>
            </li>
            <li class="me-2 cursor-pointer" @click="activeTab = 'events'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'events' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">
                        lists
                    </span>
                    <p>Events & Logs</p>
                </div>
            </li>
        </ul>
    </div>

    <div v-if="activeTab === 'transaction'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <p class="text-lg font-medium">Transaction History</p>


            <div class="relative py-4 bg-white">
                <div class="flex justify-between items-center">
                    <div class="border flex items-center bg-gray-100 p-1 space-x-2 rounded-[0.25rem]">
                        <span class="material-symbols-outlined text-xl ml-1">
                            search
                        </span>
                        <input v-model="searchQuery" @input="onSearch" type="text" placeholder="Search Transactions..."
                            class="bg-gray-100 border-0 p-[0.25rem] focus:ring-0 focus:border-0 rounded-[0.25rem] text-sm">
                    </div>
                    <div class="flex space-x-2">
                        <div v-if="showFilterBlock" class="flex space-x-1">
                            <select v-model="filterQuery" @change="onFilter"
                                class="p-[0.3rem] px-2 space-x-1 rounded text-sm cursor-pointer">
                                <option value="">Filter by Status</option>
                                <option value="0">Active</option>
                                <option value="1">locked</option>
                            </select>

                        </div>
                        <div @click="showFilterBlock = !showFilterBlock"
                            class=" flex items-center text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer border border-blue-700">
                            <span v-if="!showFilterBlock" class="material-symbols-outlined text-blue-700">
                                filter_alt
                            </span>
                            <span v-if="showFilterBlock" class="material-symbols-outlined text-red-700">
                                close
                            </span>
                        </div>

                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="min-w-full text-xs text-left text-gray-500 dark:text-gray-400 mt-2">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-[0.35rem]">ORDER NO</th>
                                <th scope="col" class="px-6 py-[0.35rem]">STATUS</th>
                                <th scope="col" class="px-6 py-[0.35rem]">AMOUNT</th>
                                <th scope="col" class="px-6 py-[0.35rem]">QUANTITY</th>
                                <th scope="col" class="px-6 py-[0.35rem]">DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Show this row when no transactions are available -->
                            <tr v-if="transactions.length === 0" class="bg-white border-b font-bold text-center">
                                <td colspan="6" class="px-6 py-3">No transactions available.</td>
                            </tr>

                            <!-- Loop through transactions and display the data -->
                            <tr v-for="(transaction, index) in transactions" :key="transaction.id"
                                class="bg-white border-b font-bold">
                                <th scope="row" class="px-6 py-[0.4rem] text-gray-900 whitespace-nowrap">
                                    <h2 @click="navigateToOrder(transaction.order_id)"
                                        class="font-medium hover:text-green-500 cursor-pointer">
                                        #{{ transaction.order_id }}
                                    </h2>
                                </th>
                                <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">{{ transaction.status }}</td>
                                <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">{{ transaction.amount }}</td>
                                <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">{{ transaction.quantity }}
                                </td>
                                <td class="px-6 py-[0.4rem] whitespace-nowrap uppercase font-normal">{{
                                    transaction.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <nav aria-label="Page navigation example" class="mt-2">
                    <ul class="inline-flex -space-x-px text-sm">
                        <li>
                            <a href="#" @click.prevent="handlePageChange(currentPage - 1)" :class="[
        'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg',
        currentPage === 1 ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-100 hover:text-gray-700'
    ]" :aria-disabled="currentPage === 1">
                                Previous
                            </a>
                        </li>
                        <li v-for="page in totalPages" :key="page">
                            <a href="#" @click.prevent="handlePageChange(page)" :class="[
        'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300',
        page === currentPage ? 'text-blue-600 border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : 'hover:bg-gray-100 hover:text-gray-700'
    ]" :aria-current="page === currentPage ? 'page' : undefined">
                                {{ page }}
                            </a>
                        </li>
                        <li>
                            <a href="#" @click.prevent="handlePageChange(currentPage + 1)" :class="[
        'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg',
        currentPage === totalPages ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-100 hover:text-gray-700'
    ]" :aria-disabled="currentPage === totalPages">
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    <div v-if="activeTab === 'security'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <p class="text-lg font-medium">Sign-in Method</p>
            <div class="flex mt-1 py-3 items-center justify-between">
                <span>
                    <p class="text-sm font-semibold">Password</p>
                    <p class="text-xs text-gray-500">************</p>
                </span>
                <div @click="showPasswordModal = true"
                    class="bg-gray-200 hover:bg-gray-300 w-fit mx-auto mt-1 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Change Password
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-md shadow-md mt-4">
            <p class="text-lg font-medium">Lock and Unlock Customer</p>
            <div class="flex mt-1 py-3 items-center">
                <p class="text-xs w-[30%] text-blue-500">If customer is locked, customer would be unable to make any
                    order. You can
                    lock and unlock customers by cicking on the corresponding button.</p>
                <div class="w-[70%]">
                    <div @click="confirmLockUpdate(customer.id)" class=" bg-gray-200 hover:bg-gray-300 w-fit mx-auto mt-1 p-2 px-3 text-xs rounded
                        cursor-pointer text-black font-normal">
                        {{ customer.is_locked ? 'Unlock Customer' : 'Lock Customer' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div v-if="activeTab === 'events'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium">Login Sessions</h2>
                <div
                    class="bg-blue-300 text-blue-700 hover:bg-blue-600 hover:text-white text-xs p-[0.3rem] px-3 space-x-1 cursor-pointer flex items-center">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <p>Sign out all sessions</p>
                </div>
            </div>

            <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-[0.35rem] whitespace-nowrap">LOCATION</th>
                        <th scope="col" class="px-6 py-[0.35rem] whitespace-nowrap">DEVICE</th>
                        <th scope="col" class="px-6 py-[0.35rem] whitespace-nowrap">IP ADDRESS</th>
                        <th scope="col" class="px-6 py-[0.35rem] whitespace-nowrap">TIME</th>
                        <th scope="col" class="px-6 py-[0.35rem] whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row for no data -->
                    <tr v-if="loginSessions.length === 0" class="bg-white border-b font-bold text-center">
                        <td colspan="5" class="px-6 py-3">No sessions available.</td>
                    </tr>

                    <!-- Row for each session -->
                    <tr v-for="session in loginSessions" :key="session.id" class="bg-white border-b">
                        <td
                            class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white hover:text-blue-500">
                            {{ session.location || 'Unknown' }}
                        </td>
                        <td class="px-6 py-3">{{ session.device }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ session.ip_address }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ formatTime(session.login_time) }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ session.is_current_session ? 'Current Session' : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>


    </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
// import UserEditModal from '../user/UserEditModal.vue'
import { useRoute } from 'vue-router'
import axiosClient from "@/axios"
import Modal from '@/components/admin/Modal.vue'
import UpdateUser from '@/views/admin/user/modals/UpdateUser.vue'
import ChangePassword from '../user/modals/UpdatePassword.vue'
import EditCustomer from './modal/EditCustomer.vue'
import UpdateAddress from './modal/UpdateAddress.vue'
import DecisionModal from '@/components/admin/DecisionModal.vue'
import store from '@/store';

const showPasswordModal = ref(false)
const showAddressModal = ref(false)
const showEditModal = ref(false)
const activeTab = ref('transaction')
const permissions = ref({})
const notPermitted = ref({})
const showUpdateButton = ref(false);
const currentPage = ref('')
const totalPages = ref('')
const searchQuery = ref('')
const showFilterBlock = ref(false)
const filterQuery = ref(null)

const user = ref({})
const customer = ref([])
const loginSessions = ref({})
const customerAddresses = ref([])

const shippingAddress = computed(() =>
    customerAddresses.value.find(address => address.address_type === 'shipping')
);

const billingAddress = computed(() =>
    customerAddresses.value.find(address => address.address_type === 'billing')
);

// const updateUser = (updatedUser) => {
//     user.value = { ...updatedUser }
//     showEditModal.value = false;
// };

const route = useRoute();
const userId = route.params.customerId;

onMounted( () => {
    if (userId) {
        fetchCustomerById(userId)
        loadCustomerOrders(userId)
        console.log("usser id provided")
    } else {
        console.error('No userId provided in the route.');
    }
});

const transactions = computed(() => store.state.customerOrders.data);

const navigateToOrder = (orderId) => {
    route.push({ name: 'app.order.detail', params: { orderId } });
};

const fetchCustomerById = async (userId) => {
    try {
        const response = await axiosClient.get(`/customer/${userId}`);
        // const response = await store.dispatch('fetchCustomer', { userId })
        console.log("Fetched user data:", response.data);
        user.value = response.data;
        customer.value = response.data.customer;
        customerAddresses.value = response.data.customer_addresses;
        loginSessions.value = response.data.login_sessions;
        // logs.value = response.data.logs;
    } catch (error) {
        console.error("Error fetching user:", error);
        user.value = {
            id: '',
            name: 'Error fetching user',
            email: '',
            phone: '',
            role: '',
            dateJoined: '',
            lastLogin: '',
        };
    }
}

async function loadCustomerOrders(userId, page = 1, search = '', status = '') {
    try {
        const response = await store.dispatch('fetchCustomerOrders', { userId, page, search, status });
        const { data, meta } = response;

        currentPage.value = page;
        totalPages.value = meta.last_page;

        console.log('Fetched orders:', data);
    } catch (error) {
        console.error('Failed to fetch orders:', error);
    }
}


const handlePageChange = (page) => {
    if (page > 0 && page <= totalPages.value) {
        loadCustomerOrders(userId, page, searchQuery.value, filterQuery.value);
    }
}

const onSearch = () => {
    loadCustomerOrders(userId, 1, searchQuery.value, filterQuery.value)
}

const onFilter = () => {
    loadCustomerOrders(userId, 1, searchQuery.value, filterQuery.value)
}

watch(showFilterBlock, (newVal) => {
    if (!newVal) {
        filterQuery.value = '';
        loadCustomerOrders(userId, 1, searchQuery.value, filterQuery.value)
    }
});



const formatTime = (time) => {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    };
    return new Date(time).toLocaleDateString('en-US', options);
}

const formatDate = (time) => {
    const options = {
        year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric'
    };
    return new Date(dateString).toLocaleDateString(undefined, options);
}




// DECISION MODAL PACKAGE ===============================
const showLockModal = ref(false)
const userIdToUpdate = userId;

// MAIN ACTION FUNCTION
const updateStatus = async (userId) => {
    try {
        const response = await axiosClient.put(`/customer/${userId}/lock`)
        console.log(response)
        fetchCustomerById(userId)
        // store.dispatch('fetchCustomers', { page: 1 })
        // fetchPermissionsById(userId)
        // emit('fetchBack', userId)
    } catch (error) {
        console.error("Error updating customer status:", error)
    }
}

const confirmLockUpdate = (user) => {
    showLockModal.value = true
    // userIdToUpdate = user
}

const closeModal = () => {
    showLockModal.value = false;
}

const handleConfirmed = () => {
    setTimeout(() => {
        if (store.state.decision.isConfirmed) {
            updateStatus(userIdToUpdate);
            // console.log('deleted');
            closeModal()
        }
    }, 3000);
};

</script>
