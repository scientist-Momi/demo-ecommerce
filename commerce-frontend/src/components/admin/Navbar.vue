<template>


    <ConfirmationModal ref="confirmationModal" :showModal="showConfirmModal" @close="showConfirmModal = false"
        @confirm="logout" @cancel="handleCancel">
        <template #icon>
            <span class="material-symbols-outlined">
                logout
            </span>
        </template>
        <template #header>
            Confirm Logout
        </template>
        <template #default>
            <div v-if="!operationUnsuccessful">
                Are you sure you want to logout?
            </div>


            <div v-if="operationUnsuccessful" class="flex flex-col items-center justify-center py-8">
                <span class=" animate-bounce material-symbols-outlined font-bold text-5xl text-red-700">
                    person_cancel
                </span>
                <!-- <span>{{ errorMessage }}</span> -->
            </div>
        </template>

    </ConfirmationModal>








    <nav class="fixed top-0 left-0 bg-blue-800 shadow-lg border-b-[0.5px] border-black z-50 w-full">
        <div class=" mx-auto flex justify-between items-center p-4">
            <div class="flex items-start">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
            </div>
            <div class="flex items-center text-white">
                <div class="flex items-center">
                    <router-link :to="{ name: 'app.user.profile' }">

                        <!-- <span class="material-icons cursor-pointer">
                            person
                        </span> -->

                        <div
                            class="relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-100 rounded-full">
                            <span class="font-medium text-gray-600">
                                {{ initials }}
                            </span>
                        </div>

                    </router-link>
                    <!-- <span class="material-icons">
                        arrow_drop_down
                    </span> -->
                </div>

                <span @click="confirmLogout" title="Log out" class="material-icons ml-3 cursor-pointer">
                    logout
                </span>
            </div>
        </div>
    </nav>
</template>

<script setup>
import store from '../../store'
import router from "../../router";
import { computed, ref } from 'vue';
import ConfirmationModal from '@/components/admin/ConfirmationModal.vue'
import Logout from '@/views/admin/Logout.vue'

const showConfirmModal = ref(false)
const currentUser = computed(() => store.state.user.data);
const operationUnsuccessful = ref(false)

const initials = computed(() => {
    const firstName = currentUser.value?.firstname || '';
    const lastName = currentUser.value?.lastname || ''; 
    const firstInitial = firstName.charAt(0).toUpperCase();
    const lastInitial = lastName.charAt(0).toUpperCase();
    return `${firstInitial}${lastInitial}`;
});

const confirmLogout = () => {
    showConfirmModal.value = true;
}


const logout = () => {
    store.dispatch('logout').then(() => {
        console.log('Logged out successfully');
        router.push({ name: 'admin-login' })
    }).catch(error => {
        console.error('Error during logout:', error);
    });
}

const navigateToUser = (userId) => {
    router.push({ name: 'app.user.detail', params: { userId } });
};

const handleCancel = () => {
    showConfirmModal.value = false;
};
</script>