<!-- UserEditModal.vue -->
<template>
    <form @submit.prevent="submitForm" class="space-y-4">
        <div class="overflow-auto max-h-[60vh]">
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                    Password</label>
                <input type="text" id="name" v-model="currentPassword"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                    Password</label>
                <input type="email" id="email" v-model="newPassword"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                    Password</label>
                <input type="text" id="role" v-model="confirmPassword"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
                
            </div>

        </div>
        <div class="flex space-x-4 justify-end border-t py-4">
            <button type="button" @click="closeModal"
                class="w-fit text-gray-700 bg-red-400  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="submit"
                class="w-fit text-white bg-blue-800 hover:bg-blue-600 font-medium text-sm px-5 py-2.5 text-center">
                Save
            </button>

        </div>

    </form>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits, inject } from 'vue';

const currentPassword = ref("")
const newPassword = ref("")
const confirmPassword = ref("")
const closeModal = inject('closeModal');
</script>
