<template>
    <div class="bg-red-300">
        <div class="max-w-screen-xl mx-auto p-4">

            <div class="max-w-sm mx-auto text-center">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-14 mx-auto" alt="Flowbite Logo">
                <div class="p-4 mt-5 font-bold text-3xl mx-auto">Log into Migratee</div>
            </div>

            <!-- <div v-if="successMsg" class="bg-green-200 p-1">{{ successMsg }}</div> -->
            <form class="max-w-sm mx-auto" method="POST" @submit.prevent="login">

                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                        email</label>
                    <input type="email" id="email" v-model="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="mail@mailer.com" />
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                        password</label>
                    <input type="password" id="password" v-model="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="********" />
                </div>

                <!-- <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button> -->


                <div v-if="errorMsg"
                    class="flex items-center justify-between py-1 px-5 bg-red-500 text-white rounded font-normal text-sm mb-3">
                    <ul>
                        <template v-if="typeof errorMsg === 'object'">
                            <li v-for="(messages, field) in errorMsg" :key="field">
                                <div v-for="message in messages" :key="message">{{ message }}</div>
                            </li>
                        </template>
                        <template v-else>
                            <li>{{ errorMsg }}</li>
                        </template>
                    </ul>

                    <span @click="errorMsg = ''"
                        class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
                <div>
                    <button type="submit" :disabled="!isFormValid"
                        class="group relative w-full flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white "
                        :class="{
                'cursor-not-allowed bg-indigo-300': !isFormValid,
                'hover:bg-indigo-500 bg-indigo-600': isFormValid,
            }">
                        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span v-if="!isFormValid" class="absolute left-0 inset-y-0 flex items-center pl-3">

                            <span class="material-symbols-outlined h-5 w-5 text-gray-100 group-hover:text-indigo-400">
                                lock
                            </span>
                        </span>
                        <span v-if="!loading">Sign in</span>
                        <span v-else>Authenticating</span>
                    </button>
                </div>
            </form>
        </div>

        <div v-if="isAuthenticated">
            <p>User: {{ getUser }}</p>
            <p>Token: {{ getToken }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive } from 'vue'
import store from "../../store";
import router from "../../router";

const isAuthenticated = computed(() => store.getters.isAuthenticated);
const getUser = computed(() => store.getters.getUser);
const getToken = computed(() => store.getters.getToken);

let loading = ref(false);
let errorMsg = ref("");
let successMsg = ref("");
const email = ref("")
const password = ref("")

const user = {
    email: email.value,
    password: password.value
}


const isFormValid = computed(() => {
    return email.value.trim() !== '' && password.value.trim() !== '';
});

const login = () => {
    loading.value = true;
    store.dispatch('login', {
        email: email.value,
        password: password.value
    })
         .then(result => {
            // loading.value = false;
             router.push({ name: 'admin-app' })
             console.log(result)
            //  errorMsg.value = result;
        })
        .catch(({ response }) => {
            loading.value = false;
            // errorMsg.value = response.data.error;

            if (response && response.data) {
                if (typeof response.data === 'object' && response.data.error) {
                    errorMsg.value = response.data.error; // Handle structured error message
                } else if (typeof response.data === 'object') {
                    errorMsg.value = response.data; // Handle field errors
                } else {
                    errorMsg.value = response.data; // Handle simple string message
                }
            } else {
                errorMsg.value = 'An error occurred'; // General error message
            }
            console.error(response);
        })
}
</script>