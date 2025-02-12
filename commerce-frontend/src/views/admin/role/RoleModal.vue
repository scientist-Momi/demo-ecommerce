<template>
    <form @submit.prevent="submitForm" class="space-y-4">
        <div class="overflow-auto max-h-[60vh]">
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role Name*
                    </label>
                <input type="text" id="name" v-model="name"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <!-- <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role Name*
                    </label>
                <input type="text" id="name" v-model="name"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div> -->
            <button @click="addPage">submit</button>
        </div>
    </form>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import axiosClient from "@/axios";

const name = ref('')

// const  addPage = async () => {
//     try {
//         const pageData = {
//             name: name.value,
//         };
//         const response = await axiosClient.post(`/page`, pageData);
//         console.log('Page created successfully:', response.data);
//     } catch (error) {
//         if (error.response) {
//             console.error('Error response:', error.response.data);
//         } else if (error.request) {
//             console.error('No response received:', error.request);
//         } else {
//             console.error('Error setting up the request:', error.message);
//         }
//     }
// };
</script>