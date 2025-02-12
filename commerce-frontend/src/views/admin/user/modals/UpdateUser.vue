<template>

    <!-- <InfoCard>
        <p>
            Email update is subject to verification. Make sure you have access to email to receive verification code.
        </p>
    </InfoCard> -->
    <form class="space-y-4" v-if="!operationSuccessful && !operationUnsuccessful">

        <div class="overflow-auto max-h-[60vh]">
            <h1 class="font-bold text-base mb-2">User Information</h1>
            <div class="mb-4 flex space-x-2 w-full">
                <div class="flex-1">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                        Name</label>
                    <input type="text" v-model="firstname"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="flex-1">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                        Name</label>
                    <input type="text" v-model="lastname"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>

            </div>

            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                    Number</label>
                <input type="text" v-model="phone"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>


            <h1 class="font-bold text-base mb-2">User Address</h1>
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address
                </label>
                <input type="text" v-model="address"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>

            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City
                </label>
                <input type="text" v-model="city"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4 flex space-x-2 w-full">
                <div class="flex-1">
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State/Province
                    </label>
                    <input type="text" v-model="state"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="flex-1">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post Code
                    </label>
                    <input type="text" v-model="postCode"
                        class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>

            </div>
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country
                </label>
                <input type="text" v-model="country"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>



            <div>
                <!-- Country Selector -->
                <multiselect v-model="selectedCountry" :options="countries" :searchable="true" :close-on-select="true"
                    placeholder="Select a country" label="country_name" track-by="country_short_name"
                    @select="onCountryChange" @open="clearFields">
                </multiselect>

                <!-- State Selector -->
                <multiselect v-model="selectedState" :options="states" :searchable="true" :close-on-select="true"
                    placeholder="Select a state" label="state_name" track-by="state_name" :disabled="!selectedCountry"
                    @select="onStateChange">
                </multiselect>

                <!-- City Selector -->
                <multiselect v-model="selectedCity" :options="cities" :searchable="true" :close-on-select="true"
                    placeholder="Select a city" label="city_name" track-by="city_name" :disabled="!selectedState">
                </multiselect>

                <p>{{ selectedCountry.country_name }}</p>
                <p>{{ selectedCountry.country_name }}</p>
            </div>

        </div>
        <div class="flex space-x-4 justify-end border-t py-4">
            <button type="button" @click="closeModal"
                class="w-fit text-white bg-red-500 hover:bg-red-300 font-medium text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="button" :disabled="!isFormValid" @click="initiateUpdate"
                class="w-fit flex items-center justify-between space-x-1 text-white font-medium text-sm px-5 py-2.5 text-center"
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

                <span v-if="!loading">Save</span>
                <span v-else>Updating user...</span>
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
import { ref, watch, defineProps, inject, computed, onMounted} from 'vue';
import InfoCard from '@/components/admin/InfoCard.vue'
import store from '@/store';
import axios from 'axios';
import ErrorCard from '@/components/admin/ErrorCard.vue'

import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

const countries = ref([]);
const states = ref([]);
const cities = ref([]);

const selectedCountry = ref({});
const selectedState = ref({});
const selectedCity = ref({});

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    address: {
        type: Object,
        default: () => ({}), // Provide a default empty object
    },
})

const loading = ref(false)
const errorMessage = ref('')
const operationSuccessful = ref(false)
const operationUnsuccessful = ref(false)

const closeModal = inject('closeModal');
const userId = ref(props.user.user_id || '');
const firstname = ref(props.user.firstname || '');
const lastname = ref(props.user.lastname || '');
const phone = ref(props.user.phone || '');
const address = ref(props.address?.address || '');
const city = ref(props.address?.city || '');
const state = ref(props.address?.state || '');
const postCode = ref(props.address?.postal_code || '');
const country = ref(props.address?.country || '');

const clearFields = () => {
    // countries.value = []
    states.value = []
    cities.value = []
}

const getAuthToken = async () => {
    try {
        const response = await axios.get('https://www.universal-tutorial.com/api/getaccesstoken', {
            headers: {
                'Accept': 'application/json',
                'api-token': 'Fmh53Vxcv6zjgzq2ee2xj-r8rfZAddepFM-lofzgvqjpZMMnoK4rumLqYz64fxyxpDQ',
                'user-email': 'momi.official33@outlook.com'
            }
        });
        return response.data.auth_token;
    } catch (error) {
        console.error('Error fetching auth token:', error);
        throw error;
    }
};

const getCountries = async (token) => {
    try {
        const response = await axios.get('https://www.universal-tutorial.com/api/countries/', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching countries:', error);
        throw error;
    }
};

const getStates = async (countryName, token) => {
    try {
        const response = await axios.get(`https://www.universal-tutorial.com/api/states/${countryName}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching states:', error);
        throw error;
    }
};

const getCities = async (stateName, token) => {
    try {
        const response = await axios.get(`https://www.universal-tutorial.com/api/cities/${stateName}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching cities:', error);
        throw error;
    }
};

const fetchInitialData = async () => {
    try {
        const token = await getAuthToken();
        countries.value = await getCountries(token);
    } catch (error) {
        console.error('Error initializing data:', error);
    }
};

const onCountryChange = async (country) => {
    if (country) {
        selectedCountry.value = country;
        console.log('got here on country change')
        try {
            const token = await getAuthToken();
            states.value = await getStates(country.country_name, token);
            selectedState.value = null; // Reset selected state
            cities.value = []; // Clear cities as state has changed
        } catch (error) {
            console.error('Error fetching states:', error);
        }
    }
};

const onStateChange = async (state) => {
    if (state) {
        selectedState.value = state; // Update the selected state
        try {
            const token = await getAuthToken();
            cities.value = await getCities(state.state_name, token);
        } catch (error) {
            console.error('Error fetching cities:', error);
        }
    }
};

onMounted(fetchInitialData);










// const isFormValid = computed(() => {
//     return (
//         firstname.value?.trim() !== props.user.firstname ||
//         lastname.value?.trim() !== props.user.lastname ||
//         phone.value?.trim() !== props.user.phone ||
//         address.value?.trim() !== props.address?.address || 
//         city.value?.trim() !== props.address?.city ||     
//         state.value?.trim() !== props.address?.state || 
//         postCode.value?.trim() !== props.address?.postal_code || 
//         country.value?.trim() !== props.address?.country  
//     );
// });

const isFormValid = computed(() => {
    return (
        (firstname.value?.trim() || '') !== (props.user.firstname || '') ||
        (lastname.value?.trim() || '') !== (props.user.lastname || '') ||
        (phone.value?.trim() || '') !== (props.user.phone || '') ||
        (address.value?.trim() || '') !== (props.address?.address || '') ||
        (city.value?.trim() || '') !== (props.address?.city || '') ||
        (state.value?.trim() || '') !== (props.address?.state || '') ||
        (postCode.value?.trim() || '') !== (props.address?.postal_code || '') ||
        (country.value?.trim() || '') !== (props.address?.country || '')
    );
});

const initiateUpdate = () => {
    loading.value = true;
    setTimeout(() => {
        errorMessage.value = '';
        updateUser()
    }, 3000);

}

const updateUser = async () => {
    try {
        const response = await store.dispatch('updateUser', {
            userId: userId.value,
            firstname: firstname.value,
            lastname: lastname.value,
            phone: phone.value,
            address: address.value,
            city: city.value,
            state: state.value,
            postal_code: postCode.value,
            country: country.value,
        });

        console.log('User updated:', response); // Log the response data
        operationSuccessful.value = true;
        setTimeout(() => {
            closeModal()
            window.location.reload()
        }, 4000);
    } catch (error) {
        console.error('Failed to update user:', error);
        operationUnsuccessful.value = true;
        errorMessage.value = 'Failed to update user. Please try again.';
        setTimeout(() => {
            closeModal()
        }, 4000);
    } finally {
        loading.value = false;
    }
};





</script>
<!-- Fmh53Vxcv6zjgzq2ee2xj-r8rfZAddepFM-lofzgvqjpZMMnoK4rumLqYz64fxyxpDQ -->