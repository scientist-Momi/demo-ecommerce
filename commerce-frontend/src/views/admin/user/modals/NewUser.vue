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
            <!-- {{ selectedPages }} -->
            <div class="mb-4">
                <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                    Name</label>
                <input type="text" v-model="firstname"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                     />
            </div>
            <div class="mb-4">
                <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                    Name</label>
                <input type="text" v-model="lastname"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                     />
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
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                     />
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

            <div class="mb-4 mt-8 border-t pt-4">
                <div class="flex justify-between items-end">
                    <div class=" pb-2">
                        <p class="">Permissions</p>
                        <small class="font-light text-xs text-blue-800 ">Choose pages user would be able to see.</small>
                    </div>
                    <button type="button" @click="viewPages"
                        class="w-fit text-white bg-red-600  hover:bg-red-500 font-medium  text-sm px-3 py-2 h-min text-center rounded">
                        Manage Permissions
                    </button>
                </div>


                <ul
                    class="text-sm font-medium text-gray-900 bg-white border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li v-for="page in pages" :key="page.id"
                        class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600 py-2">
                        <div class="flex items-center ps-3">
                            <input type="checkbox" :id="'page-checkbox-' + page.id" :value="page.id"
                                v-model="selectedPages"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer" />
                            <label :for="'page-checkbox-' + page.id"
                                class="w-full py-3 ms-2 text-sm font-medium cursor-pointer">
                                <p>{{ page.name }}</p>
                                <!-- <small class="text-red-400">{{ page.description }}</small> -->
                            </label>
                        </div>
                    </li>
                </ul>


            </div>

        </div>
        <div v-if="showVerifyForm" class="">
            <InfoCard>
                <p>
                    A 6-digit code has been sent to <span class="text-green-500">{{ userEmail }}.</span>
                    Enter token below.
                </p>
            </InfoCard>
            <input type="text" v-model="tokenToBeVerified"
                class="mt-2 bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                placeholder="Enter verify token" />
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
            <span>Saving user details...</span>
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
            <button type="button" @click="sendVerifyToken" :disabled="!isFormValid"
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
                <span v-else>Verifying email...</span>
            </button>
        </div>




        <div v-if="showVerifyForm" class="flex space-x-4 justify-end border-t py-4">
            <button type="button" @click="closeModal"
                class="w-fit text-white bg-red-400  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="button" @click="changeMail"
                class="w-fit text-white bg-gray-900  hover:bg-gray-700 font-medium  text-sm px-5 py-2.5 text-center">
                Change Email
            </button>
            <button type="button" @click="verifyToken" :disabled="!isVerifyFormValid"
                class="group relative w-fit flex items-center justify-between space-x-2 py-2 px-4 border border-transparent text-sm font-medium text-white "
                :class="{
        'cursor-not-allowed bg-indigo-300': !isVerifyFormValid,
        'hover:bg-blue-600 bg-blue-800': isVerifyFormValid,
    }">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span v-if="!loading">Verify</span>
                <span v-else>Verifying token...</span>
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
const tokenToBeVerified = ref('')
const generatedPassword = ref('')
const loading = ref(false)
const selectedPages = ref([])
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
        generatedPassword.value.trim() !== '' &&
        selectedPages.value.length > 0
    );

});

const isVerifyFormValid = computed(() => {
    return tokenToBeVerified.value.trim() !== '' && tokenToBeVerified.value.trim().length == 6;
});

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

const sendVerifyToken = () => {
    loading.value = true;
    setTimeout(() => {
        loading.value = false;
        
        initiateMail();
    }, 3000);

}

const verifyToken = () => {
    loading.value = true;
    setTimeout(() => {
        loading.value = false;

        initiateVerification();
    }, 3000);
}

const changeMail = () => {
    showFirstForm.value = true
    showVerifyForm.value = false
}

const inititateUserCreation = () => {
    store.dispatch('createUser', {
        firstname: firstname.value,
        lastname: lastname.value,
        email: userEmail.value,
        phone: phone.value,
        password: generatedPassword.value,
        pages: selectedPages.value
    }).then(data => {
        console.log(data)
        showProcessing.value = false
        operationSuccessful.value = true
        store.dispatch('fetchAdminUsers', { page: 1 })
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
                tokenToBeVerified.value = ''
            }, 5000);
        }
    })
}

const initiateVerification = () => {
    store.dispatch('verifyToken', {
        email: userEmail.value,
        token: tokenToBeVerified.value
    })
        .then(data => {
            loading.value = false;
            // verifyToken.value = token;
            console.log(data)
            errorMessage.value = ''
            showFirstForm.value = false
            showVerifyForm.value = false;
            showProcessing.value = true;

            setTimeout(() => {
                inititateUserCreation();
            }, 3000);
            //  errorMsg.value = result;
        })
        .catch(({ response }) => {
            loading.value = false;
            // alert('error')
            if (response && response.status == 422) {
                // alert('Please check your email.')
                errorMessage.value = 'Something went wrong. Please input a valid email.'

            }
            if (response && response.status == 400) {
                // alert('Please check your email.')
                errorMessage.value = 'You entered the wrong code.'

            }
            console.error(response);
        })
}

const initiateMail = () => {
    store.dispatch('sendVerifyToken', {
        email: userEmail.value
    })
        .then(data => {
            // loading.value = false;
            // verifyToken.value = token;
            console.log(data)
            errorMessage.value = ''
            showFirstForm.value = false;
            showVerifyForm.value = true;
            //  errorMsg.value = result;
        })
        .catch(({ response }) => {
            loading.value = false;
            // alert('error')
            if (response && response.status == 422) {
                // alert('Please check your email.')
                errorMessage.value = 'Something went wrong. Please input a valid email.'
                
            }
            console.error(response);
        })
}

const viewPages = () => {
    closeModal()
    router.push({ name: 'app.page' })
}

onMounted(() => {
    loadPages();
})

const loadPages = async () => {
    try {
        const response = await store.dispatch('fetchPages');
        console.log('Pages:', response);
    } catch (error) {
        console.error('Failed to fetch pages:', error);
    }
}

const pages = computed(() => store.state.pages);

</script>