<template>
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="relative bg-white shadow dark:bg-gray-700 w-full max-w-2xl mx-4 rounded overflow-auto max-h-[95vh]">
            <div class="flex items-center justify-between p-4 py-6 border-b rounded-t dark:border-gray-600 bg-blue-800">
                <div class="flex items-center space-x-4 text-white">
                    <slot name="icon">
                        <span class="material-symbols-outlined">
                            help
                        </span>
                    </slot>
                    <h3 class="text-xl font-semibold">
                        {{ props.header }}
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

            <div v-if="!loading">
                <div class="p-6 pt-5 space-y-4">
                    {{ props.question }}
                </div>

                <div class="flex justify-end p-6 pt-3 space-x-4 border-t border-gray-200 dark:border-gray-600">
                    <button @click="confirm"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Confirm</button>
                    <button @click="cancel"
                        class="border-2 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</button>
                </div>
            </div>
            <div v-else class="flex flex-col items-center justify-center py-8">
                <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-blue-800 mb-2" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>{{ props.loadingMessage }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import store from '@/store';

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false
    },
    question: {
        type: String
    },
    loadingMessage: {
        type: String
    },
    header: {
        type: String
    }
});

const loading = ref(false)

const emit = defineEmits(['close', 'confirmed']);

const closeModal = () => {
    emit('close');
    loading.value = false
};

const cancel = () => {
    closeModal()
}

const confirm = () => {
    loading.value = true
    store.dispatch('setIsConfirmed', true);
    emit('confirmed')
}

</script>