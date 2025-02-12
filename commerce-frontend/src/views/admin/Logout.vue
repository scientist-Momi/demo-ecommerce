<template>
    <div class="">
        <p>Are you sure you want to logout?</p>

        <div v-if="showVerifyForm" class="flex space-x-4 justify-end border-t py-4">
            <button type="button" @click="closeModal"
                class="w-fit text-white bg-red-400  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="button" @click="initiateLogout"
                class="group relative w-fit flex items-center justify-between space-x-2 py-2 px-4 border border-transparent text-sm font-medium text-white hover:bg-blue-600 bg-blue-800">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span v-if="!loading">Log out</span>
                <span v-else>Logging out...</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed, inject } from 'vue'
import store from "@/store"


const loading = ref(false)
const closeModal = inject('closeModal');


const initiateLogout = () => {
    loading.value = true;
    setTimeout(() => {
        logout()
    }, 3000);
}

const logout = () => {
    store.dispatch('logout').then(() => {
        // console.log('Logged out successfully');
        router.push({ name: 'admin-login' })
    }).catch(error => {
        console.error('Error during logout:', error);
    });
}
</script>