<template>
    <div>
        <!-- <label class="block text-gray-700 font-bold mb-2">Materials</label> -->
        <div v-for="(material, index) in materials" :key="index" class="flex items-center mb-2">

            <input type="text" v-model="materials[index]" placeholder="Material"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />


            <button type="button" @click="removeMaterial(index)"
                class="ml-2 text-red-500 hover:text-red-700">Remove</button>
        </div>
        <button type="button" @click="addMaterial"
            class="mt-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Add
            Material</button>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);

const materials = ref(props.modelValue || []);

watch(materials, (newMaterials) => {
    emit('update:modelValue', newMaterials);
}, { deep: true });

const addMaterial = () => {
    materials.value.push('');
};

const removeMaterial = (index) => {
    materials.value.splice(index, 1);
};
</script>
