<template>
    <div>
        <!-- Weight Input -->
        <!-- <label class="block text-gray-700 font-bold mb-2">Weight</label> -->
        <div class="flex justify-evenly items-center space-x-2 mb-4">
            <input type="text" v-model="weight" placeholder="Weight"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

// Props and Emits
const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);

const weight = ref(props.modelValue?.weight || '');

watch(weight, (newWeight) => {
    emit('update:modelValue', { ...props.modelValue, weight: newWeight });
});
</script>

<style scoped>
/* Additional styles if needed */
</style>
