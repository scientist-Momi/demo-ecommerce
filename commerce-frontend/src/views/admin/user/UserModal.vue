<template>
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="relative bg-white shadow dark:bg-gray-700 w-full max-w-2xl mx-4">
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add User
                </h3>
                <button @click="closeModal" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-6 pt-10 space-y-4">
                <form class="space-y-4">
                    <div class="overflow-auto  max-h-[60vh] ">
                        <div class="mb-4">
                            <label for="firstname"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                            <input type="text" id="firstname"
                                class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="First name" />
                        </div>
                        <div class="mb-4">
                            <label for="lastname"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                Name</label>
                            <input type="text" id="lastname"
                                class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Last name" />
                        </div>
                        <div class="mb-4" v-if="!showVerifyCodeBox">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <div class="flex items-center space-x-2">
                                <input type="email" v-model="userEmail"
                                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-11/12 p-2.5"
                                    placeholder="name@company.com" :readonly="emailIsVerified" />
                                <div class="w-1/12 flex justify-around">
                                    <span v-if="verificationSuccess"
                                        class="material-symbols-outlined bg-green-300 text-green-600 rounded-full p-1 font-bold">
                                        check
                                    </span>
                                    <span v-if="verificationError"
                                        class="material-symbols-outlined bg-red-300 text-red-600 rounded-full p-1 font-bold">
                                        close
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4" v-if="showVerifyCodeBox">
                            <label for="code" class="block mb-2 text-xs font-extralight text-gray-500 dark:text-white">
                                A code has been sent to <span class="text-green-500 font-medium">{{ userEmail }}</span>.
                                Enter the code below
                            </label>
                            <input type="email" v-model="verificationCode"
                                class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Verification code" />
                        </div>
                        <div class="mb-4" v-if="showVerifyButtons">
                            <div v-if="!showVerifyCodeBox"
                                class="flex justify-between w-full space-x-3 text-center text-sm text-gray-600 mt-2">
                                <div @click="activateEmailVerification"
                                    class="bg-white p-2 border rounded-md hover:bg-gray-200 cursor-pointer w-full">
                                    Verify Email
                                </div>
                                <div @click="clearEmailField"
                                    class="bg-white p-2 border rounded-md hover:bg-gray-200 cursor-pointer w-full">
                                    Clear Email
                                </div>
                            </div>
                        </div>
                        <div v-if="showVerifyCodeBox"
                            class="flex justify-between w-full space-x-3 text-center text-sm text-gray-600 mt-2">
                            <div @click="verifyCode"
                                class="bg-white p-2 border rounded-md hover:bg-gray-200 cursor-pointer w-full">Verify
                                Code
                            </div>
                            <div @click="clearCodeField"
                                class="bg-white p-2 border rounded-md hover:bg-gray-200 cursor-pointer w-full">Clear
                                Code
                            </div>
                        </div>

                        <div class="mb-4 border-t pt-4" v-if="emailIsVerified">
                            <div class=" pb-2">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Your
                                    password</label>
                                <small class="font-extralight text-xs text-green-500">Generate unique password for user.
                                    After saving
                                    user details, password would be sent to user's mail.</small>
                            </div>

                            <div class="flex items-center">
                                <input type="text" v-model="generatedPassword"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg block w-full p-2.5"
                                    required />
                                <div @click="generatePassword"
                                    class="w-4/12 bg-green-400 cursor-pointer text-white text-sm rounded-e-lg border p-2 py-2.5 border-green-400">
                                    Generate password</div>
                            </div>

                        </div>
                        <div class="mb-4 mt-8 border-t pt-4" v-if="emailIsVerified">
                            <div class=" pb-2">
                                <p class="">Role</p>
                                <small class="font-extralight text-xs text-green-500">Set role for user.</small>
                            </div>

                            <ul
                                class="text-sm font-medium text-gray-900 bg-white  border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600 py-2">
                                    <div class="flex items-center ps-3">
                                        <input id="product-checkbox" type="checkbox" value=""
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer">
                                        <label for="product-checkbox"
                                            class="w-full py-3 ms-2 text-sm font-medium cursor-pointer">
                                            <p class="">Customer Relations</p>
                                            <small class="text-green-400">User can add, view, edit and
                                                delete
                                                products.</small>
                                        </label>
                                    </div>
                                </li>
                                <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600 py-2">
                                    <div class="flex items-center ps-3 ">
                                        <input id="order-checkbox" type="checkbox" value=""
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer">
                                        <label for="order-checkbox"
                                            class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">
                                            <p class="">Order</p>
                                            <small class="text-green-400">User can add, view, edit and delete
                                                orders.</small>
                                        </label>
                                    </div>
                                </li>
                                <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600 py-2">
                                    <div class="flex items-center ps-3 cursor-pointer">
                                        <input id="angular-checkbox" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer">
                                        <label for="angular-checkbox"
                                            class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">
                                            <p class="">Customer</p>
                                            <small class="text-green-400">User can add, view, edit and delete
                                                customers.</small>
                                        </label>
                                    </div>
                                </li>
                                <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600 py-2">
                                    <div class="flex items-center ps-3">
                                        <input id="laravel-checkbox" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer">
                                        <label for="laravel-checkbox"
                                            class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">
                                            <p class="">Report</p>
                                            <small class="text-green-400">User can add, view, edit and delete
                                                reports.</small>
                                        </label>
                                    </div>
                                </li>
                            </ul>

                        </div>




                    </div>
                    <button type="submit" :disabled="!emailIsVerified" :class="{
        'w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center': emailIsVerified,
        'w-full text-white bg-blue-300 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center': !emailIsVerified
    }">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const userEmail = ref('');
const firstName = ref('');
const lastName = ref('');
const generatedPassword = ref('');
const verificationCode = ref('');
const emailIsVerified = ref(false);
const showVerifyCodeBox = ref(false);
const verificationSuccess = ref(false);
const verificationError = ref(false);
const showVerifyButtons = ref(true);


watch(userEmail, (newEmail) => {
    emailIsVerified.value = false; // Reset verification status
    if (newEmail) {
        console.log("email is being watched")
    }
});

const clearEmailField = () => {
    userEmail.value = "";
}

const activateEmailVerification = () => {
    showVerifyCodeBox.value = true;
}

const clearCodeField = () => {
    verificationCode.value = "";
}

const verifyCode = () => {
    showVerifyCodeBox.value = false
    if (verificationCode.value == '1234') {
        verificationError.value = false
        verificationSuccess.value = true
        showVerifyButtons.value = false
        emailIsVerified.value = true
    } else {
        verificationSuccess.value = false
        verificationError.value = true
    }
}

const resetModal = () => {
    userEmail.value = "";
    firstName.value = "";
    lastName.value = "";
    password.value = "";
    verificationCode.value = "";
    emailIsVerified.value = false;
    showVerifyCodeBox.value = false;
    verificationSuccess.value = false;
    verificationError.value = false;
    showVerifyButtons.value = true;
}

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:show'])

const showModal = ref(props.show)

watch(() => props.show, (newVal) => {
    showModal.value = newVal
})

watch(showModal, (newVal) => {
    emit('update:show', newVal)
})

const closeModal = () => {
    showModal.value = false
}


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
</script>