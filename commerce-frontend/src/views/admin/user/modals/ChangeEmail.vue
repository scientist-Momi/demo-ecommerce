<template>

    <InfoCard>
        <p>
            Email update is subject to verification. Make sure you have access to email to receive verification code.
        </p>
    </InfoCard>
    <form @submit.prevent="submitForm" class="space-y-4">
        <div class="overflow-auto max-h-[60vh]">
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                    Address</label>
                <input type="text" id="name" v-model="email"
                    class="bg-gray-100 border-0 focus:ring-0 focus:bg-gray-200 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>

        </div>
        <div class="flex space-x-4 justify-end border-t py-4">
            <button type="button"
                class="w-fit text-gray-700 bg-red-400  hover:bg-red-300 font-medium  text-sm px-5 py-2.5 text-center">
                Cancel
            </button>
            <button type="button" :disabled="!isFormValid"
                class="w-fit text-white font-medium text-sm px-5 py-2.5 text-center" :class="{
        'cursor-not-allowed bg-indigo-300': !isFormValid,
        'hover:bg-blue-600 bg-blue-800': isFormValid,
    }">
                Submit
            </button>

        </div>

    </form>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits, computed } from 'vue';
import InfoCard from '@/components/admin/InfoCard.vue'

const props = defineProps({
    userEmail: {
        type: String,
        required: true
    }
});

const email = ref(props.userEmail)

watch(() => props.userEmail, (newEmail) => {
    email.value = newEmail;
});

const isFormValid = computed(() => {
    return email.value.trim() !== props.userEmail;
});

</script>
