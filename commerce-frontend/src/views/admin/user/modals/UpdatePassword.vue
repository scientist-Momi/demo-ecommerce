<!-- UserEditModal.vue -->
<template>
    <ErrorCard v-if="errorMessage" ref="errorCard">
        <p>{{ errorMessage }}</p>
        <ul v-if="typeof errorMessage2 === 'object'">
            <li v-for="(messages, field) in errorMessage2" :key="field" class="list-none">
                <div v-for="message in messages" :key="message" class="inline-flex items-center">
                    <span class="mr-2">&#8226;</span>
                    <span>{{ message }}</span>
                </div>
            </li>
        </ul>

    </ErrorCard>
    <form class="space-y-4" v-if="!operationSuccessful && !operationUnsuccessful">
        <InfoCard>
            <p>
                User won't have access to their account after password is changed. Password can be automatically
                generated. {{ userId }}
            </p>
        </InfoCard>
        <div class="overflow-auto max-h-[60vh]">

            <div class="mb-4 border-t pt-4">
                <div class=" pb-2">
                    <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">New
                        password</label>
                    <!-- <small class="font-extralight text-xs text-red-500">Generate unique password for user.
                        After saving
                        user details, password would be sent to user's mail.</small> -->
                </div>

                <div class="flex items-center">
                    <input type="text" v-model="generatedPassword"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-s-lg block w-full p-2.5"
                        required />
                    <div @click="generatePassword"
                        class="w-4/12 bg-red-500 cursor-pointer text-white text-sm rounded-e-lg border p-2 py-2.5 border-red-400">
                        Generate password</div>
                </div>

            </div>
            <div class="mb-4">
                <div class="flex items-center border p-1 ps-2">
                    <input id="send-password-checkbox" type="checkbox" v-model="sendPasswordToUser"
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer">
                    <label for="send-password-checkbox" class="w-full py-3 ms-2 text-xs font-light cursor-pointer">
                        <p>Send Password to user's email.</p>
                    </label>
                </div>
            </div>


        </div>
        <div class="flex space-x-4 justify-end border-t py-4">
            <button type="button" @click="closeModal"
                class="w-fit text-white bg-red-500  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <!-- <button type="submit"
                class="w-fit text-white bg-blue-800 hover:bg-blue-600 font-medium text-sm px-5 py-2.5 text-center">
                Save
            </button> -->
            <button type="button" :disabled="!generatedPassword" @click="initiateUpdate"
                class="w-fit flex items-center justify-between space-x-1 text-white font-medium text-sm px-5 py-2.5 text-center"
                :class="{
                    'cursor-not-allowed bg-indigo-300': !generatedPassword,
                    'hover:bg-blue-600 bg-blue-800': generatedPassword,
                }">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span v-if="!loading">Save</span>
                <span v-else>Updating password...</span>
            </button>

        </div>

    </form>



    <div v-if="operationSuccessful" class="flex flex-col items-center justify-center py-8">
        <span class=" animate-bounce material-symbols-outlined font-bold text-5xl text-green-700">
            check
        </span>
        <span>Update Successful. Redirecting.....</span>
    </div>

    <div v-if="operationUnsuccessful" class="flex flex-col items-center justify-center py-8">
        <span class=" animate-bounce material-symbols-outlined font-bold text-5xl text-red-700">
            person_cancel
        </span>
        <span>Encountered an error. Please try again.....</span>
    </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits, inject } from 'vue';
import InfoCard from '@/components/admin/InfoCard.vue'
import store from "@/store";
import ErrorCard from '@/components/admin/ErrorCard.vue'

const closeModal = inject('closeModal');
const generatedPassword = ref('')
const loading = ref(false)
const errorMessage = ref('')
const sendPasswordToUser = ref(false)
const operationSuccessful = ref(false)
const operationUnsuccessful = ref(false)

import { useRoute } from 'vue-router';
const route = useRoute();
const userId = (route.params.userId) || (route.params.customerId);

const generateRandomPassword = (length = 12) => {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?';
    let password = '';
    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        password += chars[randomIndex];
    }
    return password;
};

const generatePassword = () => {
    generatedPassword.value = generateRandomPassword();
};

const initiateUpdate = () => {
    loading.value = true;
    setTimeout(() => {
        errorMessage.value = '';
        updatePassword()
    }, 3000);

}

const updatePassword = async () => {
    try {
        const response = await store.dispatch('updateUserPassword', {
            userId: userId,
            password: generatedPassword.value,
            sendPasswordToUser: sendPasswordToUser.value,
        });

        console.log('Password updated:', response); // Log the response data
        operationSuccessful.value = true;
        setTimeout(() => {
            closeModal()
        }, 4000);
    } catch (error) {
        console.error('Failed to update password:', error);
        operationUnsuccessful.value = true;
        errorMessage.value = 'Failed to update password. Please try again.';
        setTimeout(() => {
            closeModal()
        }, 4000);
    } finally {
        loading.value = false;
    }
};


</script>
