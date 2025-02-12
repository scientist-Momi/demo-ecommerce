<template>
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div
            class="relative bg-white shadow dark:bg-gray-700 w-full max-w-2xl mx-4 rounded overflow-auto  max-h-[95vh]">
            <div class="flex items-center justify-between p-4 py-6 border-b rounded-t dark:border-gray-600 bg-blue-800">
                <div class="flex items-center space-x-4 text-white">
                    <slot name="icon">
                        <span class="material-symbols-outlined">
                            manage_accounts
                        </span>
                    </slot>
                    <h3 class="text-xl font-semibold">
                        <slot name="header">Default Header</slot>
                    </h3>
                </div>

                <button @click="closeModal" type="button"
                    class="text-red-500 bg-transparent hover:bg-gray-200 hover:text-red-600 rounded-lg text-xl font-extrabold w-8 h-8 flex justify-center items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-6 pt-5 space-y-4">
                <slot>
                    Default content: Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate nam doloribus
                    nesciunt sit at
                    consectetur sequi eligendi amet voluptates expedita vel ad iste autem perspiciatis, corrupti, dolore
                    animi? Vel, cum.
                </slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, provide } from 'vue';

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};

provide('closeModal', closeModal);
</script>