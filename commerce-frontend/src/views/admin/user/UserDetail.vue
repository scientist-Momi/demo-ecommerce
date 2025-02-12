<template>
    <UserEditModal :show="showEditModal" :user="user" @close="showEditModal = false" @update="updateUser" />

    <Modal :showModal="showFirstModal" @close="showFirstModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                manage_accounts
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Update Password</h3>
        </template>
        <UpdatePassword />
    </Modal>

    <Modal :showModal="showThirdModal" @close="showThirdModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                manage_accounts
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Update User Details</h3>
        </template>
        <UpdateUser :user="user" :address="address" />
    </Modal>



    <!-- <div class="flex justify-between mb-4">
        <h1 class="text-2xl mb-2">Users </h1>
        <div @click="showThirdModal = true"
            class="bg-red-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center">
            <span class="material-symbols-outlined">
                manage_accounts
            </span>
            <p>Edit User</p>
        </div>
    </div> -->


    <div class="flex flex-col lg:flex-row space-x-2 mb-4 mt-4">


        <div class="bg-white p-6 w-[30%] rounded-md shadow-md">
            <div class="flex justify-between">
                <h1 class="font-semibold">User Details </h1>
                <div @click="showThirdModal = true"
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
            <h1 class="font-semibold">User Details </h1>
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
                    <p class="text-sm">Role</p>
                </div>
                <p class="text-sm font-semibold uppercase">{{ admin?.role }}</p>
            </div>


        </div>


        <div class="bg-white p-6 w-[40%] rounded-md shadow-md">
            <h1 class="font-semibold">User Address</h1>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1 border-b">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        input
                    </span>
                    <p class="text-sm">Last Login</p>
                </div>
                <p class="text-sm font-semibold">{{ user.lastLogin }}</p>
            </div>
            <div class="flex justify-between items-start text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        home_pin
                    </span>
                    <p class="text-sm">Address</p>
                </div>
                <div class="">
                    <p class="text-sm"> {{ address?.address }}, </p>
                    <p class="text-sm">{{ address?.postal_code }} {{
                        address?.city }}, {{ address?.state }}</p>
                    <p class="text-sm">{{ address?.country }}</p>
                </div>

            </div>
        </div>
    </div>

    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
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
            <li class="me-2 cursor-pointer" @click="activeTab = 'permission'">
                <div
                    :class="['inline-flex items-center justify-center p-4 py-2 border-b-2 rounded-t-lg group space-x-1', activeTab === 'permission' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300']">
                    <span class="material-symbols-outlined">
                        passkey
                    </span>
                    <p>Permissions</p>
                </div>
            </li>
        </ul>
    </div>


    <div v-if="activeTab === 'security'">
        <div class="bg-white p-6 rounded-md shadow-md">
            <p class="text-lg font-medium">Sign-in Method</p>
            <div class="flex mt-1 py-3 items-center justify-between">
                <span>
                    <p class="text-sm font-semibold">Password</p>
                    <p class="text-xs text-gray-500">************</p>
                </span>
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 w-fit mx-auto mt-1 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Change Password
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
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">LOCATION</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">DEVICE</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">IP ADDRESS</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">TIME</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap">ACTIONS</th>
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

        <div class="bg-white p-6 rounded-md shadow-md mt-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium">Logs</h2>

            </div>
            <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                <tbody>
                    <tr v-if="logs.length === 0" class="bg-white border-b font-bold text-center">
                        <td colspan="3" class="px-6 py-3">No logs available.</td>
                    </tr>
                    <tr v-for="log in logs" :key="log.id" class="flex justify-between items-center border-b py-2">
                        <td class="px-6 py-3 whitespace-nowrap">{{ log.status_code }} {{ log.status_code_text }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ log.method }} {{ log.endpoint }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">{{ log.created_at }}</td>
                        <!-- <p>{{ formatDate(log.created_at) }}</p> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="activeTab === 'permission'">
        <PermissionTab :userId="userId" :permissions="permissions" :notPermitteds="notPermitted"
            @fetchBack="fetchPermissionsById" />

    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import UserEditModal from '../user/UserEditModal.vue'
import { useRoute } from 'vue-router';
import axiosClient from "@/axios";
import Modal from '@/components/admin/Modal.vue'
import UpdateUser from '@/views/admin/user/modals/UpdateUser.vue'
import UpdatePassword from './modals/UpdatePassword.vue'
import PermissionTab from '@/views/admin/user/tabs/PermissionTab.vue'

const showFirstModal = ref(false)
const showThirdModal = ref(false)
const showEditModal = ref(false)
const activeTab = ref('security')
const permissions = ref({})
const notPermitted = ref({})
const showUpdateButton = ref(false);

const user = ref({})
const admin = ref({})
const address = ref({})
const loginSessions = ref({})
const logs = ref({})

const updateUser = (updatedUser) => {
    user.value = { ...updatedUser }
    showEditModal.value = false;
};

const route = useRoute();
const userId = route.params.userId;

onMounted(async () => {
    if (userId) {
        await fetchUserById(userId);
        await fetchPermissionsById(userId);
        // user.value = fetchedUser;
        console.log("usser id provided")
    } else {
        console.error('No userId provided in the route.');
    }
});

const fetchUserById = async (userId) => {
    try {
        const response = await axiosClient.get(`/admin-users/${userId}`);
        console.log("Fetched user data:", response.data);
        user.value = response.data;
        admin.value = response.data.admin;
        address.value = response.data.address;
        loginSessions.value = response.data.login_sessions;
        logs.value = response.data.logs;
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

const fetchPermissionsById = async (userId) => {
    try {
        const response = await axiosClient.get(`/admin-users/${userId}/permissions`);
        console.log("Fetched user permissions:", response.data);
        permissions.value = response.data.permitted
        notPermitted.value = response.data.not_permitted
    } catch (error) {
        console.error("Error fetching user:", error);
    }
}

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

</script>