<template>
    <div>
        <!-- <label class="block text-gray-700 font-bold mb-2">Colors</label> -->
        <div v-for="(color, index) in colors" :key="index" class="flex items-center mb-2">
            <input type="text" v-model="colors[index]" placeholder="Enter color"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="button" @click="removeColor(index)"
                class="ml-2 text-red-500 hover:text-red-700">Remove</button>
        </div>
        <button type="button" @click="addColor" class="mt-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Add
            Color</button>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);

const colors = ref(props.modelValue || []);

watch(colors, (newColors) => {
    emit('update:modelValue', newColors);
}, { deep: true });

const addColor = () => {
    colors.value.push('');
};

const removeColor = (index) => {
    colors.value.splice(index, 1);
};
</script>
