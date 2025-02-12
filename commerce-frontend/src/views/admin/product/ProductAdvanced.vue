<template>
    <div class="p-4 ps-6 bg-white mt-5 rounded-lg">
        <div class="py-4">
            <h1 class="font-bold text-xl">Inventory</h1>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2">Quantity</label>
            <input type="text" placeholder="Product name"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <small class="text-gray-400">Enter the product quantity.</small>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2">Allow Backorders</label>
            <div class="flex items-center space-x-2 mb-2">
                <input type="checkbox" placeholder="Product name"
                    class="w-6 h-6 text-blue-600 bg-gray-500 border-gray-300 rounded cursor-pointer" />
                <small class="text-gray-400 font-bold">Yes</small>
            </div>

            <small class="text-gray-400">Allow customers to purchase products that are out of stock.</small>
        </div>

    </div>

    <div class="p-4 ps-6 bg-white mt-5 rounded-lg">
        <div class="py-4">
            <h1 class="font-bold text-xl">Variations</h1>
        </div>


        <div v-for="(field, index) in customFields" :key="index" class="mb-4">
            <div class="flex justify-start items-center mb-2">
                <label class="text-gray-700 font-semibold mr-2">{{ field.name }}</label>
                <span @click="removeField(index)"
                    class=" material-symbols-outlined cursor-pointer bg-red-200 text-red-600 text-base p-1 rounded hover:bg-red-600 hover:text-white">
                    close
                </span>
            </div>
            <div class="flex justify-start items-center w-full">
                <component :is="field.component" v-model="product.customFields[field.name]"></component>
            </div>

        </div>

        <div class="mb-4 relative inline-block text-left">
            <small class="text-gray-400">Add Product Variations.</small>
            <div>
                <button @click="toggleDropdown" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add Field
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.292 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div v-if="dropdownOpen"
                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <a @click.prevent="addField('Size')" href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Size</a>
                    <a @click.prevent="addField('Color')" href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Color</a>
                    <a @click.prevent="addField('Material')" href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Material</a>
                    <a @click.prevent="addField('Dimension')" href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Dimension</a>
                    <a @click.prevent="addField('Weight')" href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Weight</a>
                </div>
            </div>
        </div>


    </div>

</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import SizeField from '../product/optionalFields/SizeField.vue';
import ColorField from '../product/optionalFields/ColorField.vue';
import DimensionField from '../product/optionalFields/DimensionField.vue';
import MaterialField from '../product/optionalFields/MaterialField.vue';
import WeightField from '../product/optionalFields/WeightField.vue';


const dropdownOpen = ref(false);
const fields = ref([]);

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

const product = reactive({
    title: '',
    description: '',
    price: '',
    customFields: {}
});
const customFields = ref([]);

const addField = (type) => {
    let component;
    if (type === 'Size') {
        component = SizeField;
    } else if (type === 'Color') {
        component = ColorField;
    } else if (type === 'Weight') {
        component = WeightField;
    } else if (type === 'Dimension') {
        component = DimensionField;
    } else if (type === 'Material') {
        component = MaterialField;
    }

    if (component) {
        customFields.value.push({ name: type, component });
        dropdownOpen.value = false;
    }
};

const removeField = (index) => {
    customFields.value.splice(index, 1);
};


const submitForm = () => {
    // Handle form submission, e.g., send data to the server
    console.log('Product data:', product);
};
</script>