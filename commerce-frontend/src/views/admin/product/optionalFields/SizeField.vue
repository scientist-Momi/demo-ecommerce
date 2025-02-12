<template>
    <div>
        <!-- <label class="block text-gray-700 font-bold mb-2">Sizes(Dimension)</label> -->
        <div v-for="(size, index) in sizes" :key="index" class="flex items-center mb-2 space-x-2">

            <input type="text" v-model="sizes[index]" placeholder="Size"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />


            <!-- <button type="button" @click="removeSize(index)"
                class="ml-2 text-red-500 hover:text-red-700">Remove</button> -->

            <span @click="removeSize(index)"
                class=" material-symbols-outlined cursor-pointer bg-red-200 text-red-600 text-base p-1 rounded hover:bg-red-600 hover:text-white">
                close
            </span>
        </div>
        <button type="button" @click="addSize" class="mt-2 p-2 bg-blue-500 text-white hover:bg-blue-700">Add
            Size</button>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);

const sizes = ref(props.modelValue || []);

watch(sizes, (newSizes) => {
    emit('update:modelValue', newSizes);
}, { deep: true });

const addSize = () => {
    sizes.value.push('');
};

const removeSize = (index) => {
    sizes.value.splice(index, 1);
};
</script>
