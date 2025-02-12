<template>
    <!-- <ChangePasswordModal :show="showPasswordModal" /> -->
    <Modal :showModal="showFirstModal" @close="showFirstModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                manage_accounts
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Change Password</h3>
        </template>
        <ChangePassword />
    </Modal>
    <Modal :showModal="showSecondModal" @close="showSecondModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                manage_accounts
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Change Email</h3>
        </template>
        <ChangeEmail :userEmail="currentUser.email" />
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
        <UpdateUser />
    </Modal>

    <!-- <h1>User Profile</h1> -->

    <div class="flex flex-col lg:flex-row space-x-2 mb-4 mt-4">


        <div class="bg-white p-6 w-[15%] rounded-md shadow-md text-center">
            <span class="material-symbols-outlined text-7xl">
                person
            </span>
            <div>
                <span>
                    {{ currentUser.firstname }} {{ currentUser.lastname }}
                </span>
                <div @click="showThirdModal = true"
                    class="bg-red-500 hover:bg-red-400 w-fit mx-auto mt-1 p-2 px-3 text-xs rounded cursor-pointer text-white font-normal">
                    Edit Profile
                </div>
            </div>

        </div>


        <div class="bg-white p-6 w-[40%] rounded-md shadow-md">
            <h1 class="font-semibold">User Details </h1>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        mail
                    </span>
                    <p class="text-sm">Email</p>
                </div>
                <p class="text-sm font-semibold">{{ currentUser.email }}</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 border-b py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        call
                    </span>
                    <p class="text-sm">Phone</p>
                </div>
                <p class="text-sm font-semibold">{{ currentUser.phone }}</p>
            </div>
            <div class="flex justify-between items-center text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        input
                    </span>
                    <p class="text-sm">Last Login</p>
                </div>
                <p class="text-sm font-semibold">2 days ago</p>
            </div>

        </div>


        <div class="bg-white p-6 w-[45%] rounded-md shadow-md">
            <h1 class="font-semibold">User Address</h1>
            <div class="flex justify-between items-start text-gray-500 py-3 mt-1">
                <div class="flex space-x-2 items-center">
                    <span class="material-symbols-outlined text-xl">
                        home_pin
                    </span>
                    <p class="text-sm">Address</p>
                </div>
                <div class="">
                    <p class="text-sm">503 Broadway Residences. 105 Broad Street, </p>
                    <p class="text-sm">B15 1BH Birmingham, West Midlands. </p>
                    <p class="text-sm">United Kingdom.</p>
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
            <div class="flex mt-3 py-3 items-center justify-between border-b">
                <span>
                    <p class="text-sm font-semibold">Email Address</p>
                    <p class="text-xs text-gray-500">{{ currentUser.email }}</p>
                </span>
                <div @click="showSecondModal = true"
                    class="bg-gray-200 hover:bg-gray-300 w-fit mx-auto mt-1 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Change Email
                </div>
            </div>
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
        <div class="bg-white p-6">
            <p class="text-lg font-medium">Login Sessions</p>
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
    </div>
    <div v-if="activeTab === 'permission'">
    </div>

</template>

<script setup>
import store from '@/store'
// import router from "../../router";
import { computed, ref, watch } from 'vue';
import Modal from '@/components/admin/Modal.vue'
import ChangePassword from './modals/ChangePassword.vue'
import ChangeEmail from './modals/ChangeEmail.vue'
import UpdateUser from './modals/UpdateUser.vue'
import axiosClient from "@/axios";

const activeTab = ref('security');


const showFirstModal = ref(false);
const showSecondModal = ref(false);
const showThirdModal = ref(false);
const loginSessions = ref({})

const currentUser = computed(() => store.state.user.data);


watch(activeTab, (newTab) => {
    if (newTab === 'events') {
        const userId = currentUser.value.id; // Access the user ID from the currentUser

        if (userId) {
            console.log("User ID provided:", userId);
            fetchUserById(userId);  
        } else {
            console.error('No userId found.');
        }
    }
});

const fetchUserById = async (userId) => {
    try {
        const response = await axiosClient.get(`/admin-users/${userId}`);
        console.log("Fetched user data:", response.data);
        // user.value = response.data;
        // admin.value = response.data.admin;
        // address.value = response.data.address;
        loginSessions.value = response.data.login_sessions;
        // logs.value = response.data.logs;

    } catch (error) {
        console.error("Error fetching user:", error);
        // user.value = {
        //     id: '',
        //     name: 'Error fetching user',
        //     email: '',
        //     phone: '',
        //     role: '',
        //     dateJoined: '',
        //     lastLogin: '',
        // };
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

</script>