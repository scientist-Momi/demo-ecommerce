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
    <form class="space-y-4">
        <div v-if="showFirstForm" class="overflow-auto  max-h-[60vh] mt-5">
            <InfoCard v-if="!errorMessage">
                <p>
                    Email provided is subject to verification. Make sure you have access to email to receive
                    verification code.
                </p>
            </InfoCard>
            <div class="mb-4">
                <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                    Name</label>
                <input type="text" v-model="firstname"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
                <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                    Name</label>
                <input type="text" v-model="lastname"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" v-model="userEmail"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    placeholder="name@company.com" />
            </div>
            <div class="mb-4">
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                <input type="text" v-model="phone"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4 border-t pt-4">
                <div class=" pb-2">
                    <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">Your
                        password</label>
                    <small class="font-light text-xs text-blue-800">Generate unique password for user.
                        After saving
                        user details, password would be sent to user's mail.</small>
                </div>

                <div class="flex items-center">
                    <input type="text" v-model="generatedPassword"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-s-lg block w-full p-2.5"
                        required />
                    <div @click="generatePassword"
                        class="w-4/12 bg-blue-700 cursor-pointer text-white text-sm rounded-e-lg border p-2 py-2.5 border-blue-700">
                        Generate password</div>
                </div>

            </div>
        </div>
        <div v-if="showProcessing" class="flex flex-col items-center justify-center py-8">
            <svg class="animate-spin -ml-1 mr-3 h-7 w-7 text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span>Saving customer details...</span>
        </div>

        <div v-if="operationSuccessful" class="flex flex-col items-center justify-center py-8">
            <span class=" animate-bounce material-symbols-outlined font-bold text-5xl text-green-700">
                check
            </span>
            <span>Operation Successful. Redirecting.....</span>
        </div>

        <div v-if="operationUnsuccessful" class="flex flex-col items-center justify-center py-8">
            <span class=" animate-bounce material-symbols-outlined font-bold text-5xl text-red-700">
                person_cancel
            </span>
            <span>Encountered an error. Please try again.....</span>
        </div>


        <div v-if="showFirstForm" class="flex space-x-4 justify-end border-t py-4">
            <button type="button" @click="closeModal"
                class="w-fit text-white bg-red-400  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="button" @click="createCustomer" :disabled="!isFormValid"
                class="group relative w-fit flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium text-white "
                :class="{
        'cursor-not-allowed bg-indigo-300': !isFormValid,
        'hover:bg-blue-600 bg-blue-800': isFormValid,
    }">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span v-if="!loading">Submit</span>
                <span v-else>Verifying details...</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, watch, computed, inject, onMounted } from 'vue'
import store from "@/store";
import InfoCard from '@/components/admin/InfoCard.vue'
import ErrorCard from '@/components/admin/ErrorCard.vue'
import router from "@/router";

const userEmail = ref('')
const firstname = ref('')
const lastname = ref('')
const phone = ref('')
const generatedPassword = ref('')
const loading = ref(false)
const showVerifyForm = ref(false)
const showFirstForm = ref(true)
const errorMessage = ref('')
const showProcessing = ref(false)
const operationSuccessful = ref(false)
const operationUnsuccessful = ref(false)
const errorMessage2 = ref('')
const closeModal = inject('closeModal');

const isFormValid = computed(() => {
    return (
        userEmail.value.trim() !== '' &&
        firstname.value.trim() !== '' &&
        lastname.value.trim() !== '' &&
        generatedPassword.value.trim() !== ''
    );

});

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

const createCustomer = () => {
    showFirstForm.value = false
    showProcessing.value = true

    setTimeout(() => {
        initiateCreateCustomer()
    }, 3000);
}

const initiateCreateCustomer = () => {
    store.dispatch('createCustomer', {
        firstname: firstname.value,
        lastname: lastname.value,
        email: userEmail.value,
        phone: phone.value,
        password: generatedPassword.value,
    }).then(data => {
        console.log(data)
        showProcessing.value = false
        operationSuccessful.value = true
        store.dispatch('fetchCustomers', { page: 1 })
        setTimeout(() => {
            closeModal()
        }, 5000);
    }).catch(({ response }) => {
        console.log(response)
        showProcessing.value = false
        operationUnsuccessful.value = true
        if (response && response.status == 422) {
            // alert('Please check your email.')
            errorMessage.value = 'Something went wrong. Please check your inputs.'
            errorMessage2.value = response.data.error;
            setTimeout(() => {
                operationUnsuccessful.value = false
                showFirstForm.value = true
            }, 5000);
        }
    })
}
</script>