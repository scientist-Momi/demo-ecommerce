<template>
    <!-- <ErrorCard v-if="errorMessage" ref="errorCard">
        <p>{{ errorMessage }}</p>
        <ul v-if="typeof errorMessage2 === 'object'">
            <li v-for="(messages, field) in errorMessage2" :key="field" class="list-none">
                <div v-for="message in messages" :key="message" class="inline-flex items-center">
                    <span class="mr-2">&#8226;</span>
                    <span>{{ message }}</span>
                </div>
            </li>
        </ul>

    </ErrorCard> -->
    <form class="space-y-4">
        <div v-if="showFirstForm" class="overflow-auto  max-h-[60vh] mt-5">
            <!-- <InfoCard v-if="!errorMessage">
                <p>
                    Email provided is subject to verification. Make sure you have access to email to receive
                    verification code.
                </p>
            </InfoCard> -->
            <!-- {{ selectedPages }} -->
            <div class="mb-4">
                <h1 class="mb-6 font-semibold text-lg">Billing Address</h1>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address Line
                        1
                    </label>
                    <input type="text" v-model="billingAddress.address_line_1"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address Line
                        2
                    </label>
                    <input type="text" v-model="billingAddress.address_line_2"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>

                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City
                    </label>
                    <input type="text" v-model="billingAddress.city"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="mb-4 flex space-x-2 w-full">
                    <div class="flex-1">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State/Province
                        </label>
                        <input type="text" v-model="billingAddress.state"
                            class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div class="flex-1">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post Code
                        </label>
                        <input type="text" v-model="billingAddress.postal_code"
                            class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>

                </div>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country
                    </label>
                    <input type="text" v-model="billingAddress.country"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
            </div>

            <div class="mb-4 border bg-blue-100">
                <div class="flex items-center ps-3">
                    <input type="checkbox" id="adressCheck" v-model="isSimilar" @change="handleCheckboxChange"
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer" />
                    <label for="adressCheck" class="w-full py-3 ms-2 text-sm font-medium cursor-pointer">
                        <p>Is shipping address same as billing address?</p>

                    </label>
                </div>
            </div>

            <div class="mb-4 border-t pt-4">
                <h1 class="mb-6 font-semibold text-xl">Shipping Address</h1>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Line Address
                        1
                    </label>
                    <input type="text" v-model="shippingAddress.address_line_1"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Line Address
                        2
                    </label>
                    <input type="text" v-model="shippingAddress.address_line_2"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>

                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City
                    </label>
                    <input type="text" v-model="shippingAddress.city"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="mb-4 flex space-x-2 w-full">
                    <div class="flex-1">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State/Province
                        </label>
                        <input type="text" v-model="shippingAddress.state"
                            class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div class="flex-1">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post
                            Code
                        </label>
                        <input type="text" v-model="shippingAddress.postal_code"
                            class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>

                </div>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country
                    </label>
                    <input type="text" v-model="shippingAddress.country"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
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
            <span>Saving customer address...</span>
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
                class="w-fit text-white bg-red-600  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="button" @click="saveAddress" :disabled="!isFormValid"
                class="group relative w-fit flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium text-white "
                :class="{
            'cursor-not-allowed bg-indigo-300': !isFormValid,
            'hover:bg-blue-600 bg-blue-800': isFormValid,
        }">

                <span>Submit</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, watch, computed, inject, onMounted, defineProps } from 'vue'
import store from '@/store';
import axiosClient from "@/axios";
import InfoCard from '@/components/admin/InfoCard.vue'
import ErrorCard from '@/components/admin/ErrorCard.vue'
import router from "@/router";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    address: {
        type: Object,
        default: () => ({}), // Provide a default empty object
    },
    shippingAddress: {
        type: Object,
        default: () => ({}), // Provide a default empty object
    },
    billingAddress: {
        type: Object,
        default: () => ({}), // Provide a default empty object
    },
})

const billingAddress = ref({
    address_line_1: props.billingAddress?.address_line_1 || '',
    address_line_2: props.billingAddress?.address_line_2 || '',
    city: props.billingAddress?.city || '',
    state: props.billingAddress?.state || '',
    postal_code: props.billingAddress?.postal_code || '',
    country: props.billingAddress?.country || ''
});

const shippingAddress = ref({
    address_line_1: props.shippingAddress?.address_line_1 || '',
    address_line_2: props.shippingAddress?.address_line_2 || '',
    city: props.shippingAddress?.city || '',
    state: props.shippingAddress?.state || '',
    postal_code: props.shippingAddress?.postal_code || '',
    country: props.shippingAddress?.country || ''
});

const userId = ref(props.user.user_id || '');
// const bAddress2 = ref(props.address?.address || '');
// const bAddress1 = ref(props.address?.address || '');
// const bCity = ref(props.address?.city || '');
// const bState = ref(props.address?.state || '');
// const bPostCode = ref(props.address?.postal_code || '');
// const bCountry = ref(props.address?.country || '');
// const sAddress2 = ref(props.address?.address || '');
// const sAddress1 = ref(props.address?.address || '');
// const sCity = ref(props.address?.city || '');
// const sState = ref(props.address?.state || '');
// const sPostCode = ref(props.address?.postal_code || '');
// const sCountry = ref(props.address?.country || '');
const showFirstForm = ref(true)
const isSimilar = ref(false)
const closeModal = inject('closeModal');
const showProcessing = ref(false)
const operationSuccessful = ref(false)
const operationUnsuccessful = ref(false)

const handleCheckboxChange = () => {
    if (isSimilar.value) {
        // Copy billing address to shipping address if checkbox is checked
        shippingAddress.value.address_line_1 = billingAddress.value.address_line_1;
        shippingAddress.value.address_line_2 = billingAddress.value.address_line_2;
        shippingAddress.value.city = billingAddress.value.city;
        shippingAddress.value.state = billingAddress.value.state;
        shippingAddress.value.postal_code = billingAddress.value.postal_code;
        shippingAddress.value.country = billingAddress.value.country;
    } else {
        // Clear shipping address if checkbox is unchecked
        shippingAddress.value.address_line_1 = ''
        shippingAddress.value.address_line_2 = ' '
        shippingAddress.value.city = ' '
        shippingAddress.value.state = ' '
        shippingAddress.value.value.postal_code = ' '
        shippingAddress.value.value.country = ' '
    }
};

const isFormValid = computed(() => {
    return (
        billingAddress.value.address_line_1.trim() !== '' &&
        billingAddress.value.city.trim() !== '' &&
        billingAddress.value.state.trim() !== '' &&
        billingAddress.value.postal_code.trim() !== '' &&
        billingAddress.value.country.trim() !== '' &&
        shippingAddress.value.address_line_1.trim() !== '' &&
        shippingAddress.value.city.trim() !== '' &&
        shippingAddress.value.state.trim() !== '' &&
        shippingAddress.value.postal_code.trim() !== '' &&
        shippingAddress.value.country.trim() !== ''
    );
});

const saveAddress = () => {
    showFirstForm.value = false
    showProcessing.value = true

    setTimeout(() => {
        initiateSaveAddress()
    }, 3000);
}

const initiateSaveAddress = async () => {
      try {
          const response = await axiosClient.post('/customer-addresses', {
              customer_id: userId.value,
          billing_address: billingAddress.value,
          shipping_address: shippingAddress.value,
          });
          showProcessing.value = false
          operationSuccessful.value = true
        //   store.dispatch('fetchCustomers', { page: 1 })
          setTimeout(() => {
              closeModal()
              window.location.reload()
          }, 4000);
        console.log('Addresses saved:', response.data);
      } catch (error) {
          console.error('Error saving addresses:', error);
          showProcessing.value = false
          operationUnsuccessful.value = true
      }
    };
</script>