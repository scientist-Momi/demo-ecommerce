<template>
    <div>
        <!-- <label class="block text-gray-700 font-bold mb-2">Dimension</label> -->
        <div class="flex justify-evenly items-center space-x-2 mb-2">
            <input type="text" v-model="dimension.width" placeholder="Width (w)"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <input type="text" v-model="dimension.height" placeholder="Height (h)"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <input type="text" v-model="dimension.length" placeholder="Length (l)"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);

const dimension = ref(props.modelValue || { width: '', height: '', length: '' });

watch(dimension, (newDimension) => {
    emit('update:modelValue', newDimension);
}, { deep: true });
</script>

<style scoped>
/* Additional styles if needed */
</style>
