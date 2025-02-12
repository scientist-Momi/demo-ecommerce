<template>
    <div class="p-4 ps-6 bg-white mt-5 rounded-lg">
        <div class="py-4">
            <h1 class="font-bold text-xl">General</h1>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2">Product Name</label>
            <input v-model="product.title" type="text" placeholder="Product name"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <small class="text-gray-400">A product name is required and recommended to be unique</small>
        </div>

        <div class="mb-2">
            <label class="block text-gray-700 text-sm font-medium mb-2">Description</label>
        </div>

        <div id="editor" class="">
            <!-- <p>Hello World!</p>
            <p>Some initial <strong>bold</strong> text</p>
            <p><br /></p> -->
        </div>
        <small class="text-gray-400">Set a description to the product for better visibility.</small>




    </div>

    <div class="p-4 ps-6 bg-white mt-5 rounded-lg">
        <div class="py-4">
            <h1 class="font-bold text-xl">Media</h1>
        </div>

        <FileUpload :maxFilesToUpload="5" :maxFileSizeToUpload="10"
            :allowedTypes="['image/jpeg', 'image/png', 'application/pdf']" :submitHandler="handleSubmit" />

        <small class="text-gray-400">Set the product media gallery.</small>

    </div>


    <div class="p-4 ps-6 bg-white mt-5 rounded-lg pb-8">
        <div class="py-4">
            <h1 class="font-bold text-xl">Pricing</h1>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-medium mb-2"> Base Price</label>
            <input v-model="product.price" type="number" placeholder="Enter product price"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <small class="text-gray-400">Set the product price.</small>
        </div>

        <h2 class="block text-gray-700 text-sm font-medium mb-3">Discount Type</h2>

        <div class="flex w-full justify-start space-x-5 mb-8">
            <div class="flex items-center px-4 border border-gray-200 rounded dark:border-gray-700">
                <input id="bordered-radio-1" type="radio" value="none" v-model="discountType"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                <label for="bordered-radio-1"
                    class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    No Discount
                </label>
            </div>
            <div class="flex items-center px-4 border border-gray-200 rounded dark:border-gray-700">
                <input id="bordered-radio-2" type="radio" value="percentage" v-model="discountType"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                <label for="bordered-radio-2"
                    class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Percentage
                </label>
            </div>
            <div class="flex items-center px-4 border border-gray-200 rounded dark:border-gray-700">
                <input id="bordered-radio-3" type="radio" value="fixed" v-model="discountType"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                <label for="bordered-radio-3"
                    class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Fixed Price
                </label>
            </div>
        </div>

        <div v-if="discountType === 'percentage'" class="mt-7">
            <label class="block text-sm font-medium text-gray-700 mb-7">Set Percentage Discount</label>
            <div class="text-center font-bold text-4xl mb-8">
                <h1>{{ discountValue }} %</h1>
            </div>
            <input type="range" min="0" max="100" value="10" v-model="discountValue"
                class="slider form-input mt-1 block w-full mb-3" />
            <small class="text-gray-400">Set a percentage discount to be applied on this product.</small>
        </div>


        <div v-if="discountType === 'fixed'" class="mt-2">
            <label class="block text-gray-700 text-sm font-medium mb-2">Fixed Discounted Price</label>
            <input type="number" v-model="discountValue"
                class="form-input mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter fixed price" />
            <small class="text-gray-400">Set the discounted product price. The product will be reduced at the determined
                fixed price.</small>
        </div>


    </div>

</template>



<script setup>
import { ref, reactive, onMounted } from 'vue';
import Quill from 'quill';
import SizeField from '../product/optionalFields/SizeField.vue';
import ColorField from '../product/optionalFields/ColorField.vue';
import FileUpload from "../../../components/reusables/FileUpload.vue";

const product = reactive({
    title: '',
    description: '',
    price: '',
    customFields: {}
});

const customFields = ref([]);

const addField = (type) => {
    let component;
    if (type === 'size') {
        component = SizeField;
    } else if (type === 'color') {
        component = ColorField;
    }

    if (component) {
        customFields.value.push({ name: type, component });
    }
};

const removeField = (index) => {
    customFields.value.splice(index, 1);
};

const submitForm = () => {
    // Handle form submission, e.g., send data to the server
    console.log('Product data:', product);
};

const handleSubmit = (uploadedFiles) => {
    // Custom logic for handling the uploaded files
    alert("Uploaded Files:", uploadedFiles);

    // You can perform additional actions here, such as sending files to a server
};





// note
onMounted(() => {
    const quill = new Quill('#editor', {
        theme: 'snow'
    });
});

const discountType = ref('none');
const discountValue = ref(50);
const sliderValue = ref(50);


// thumbnail

const fileInput = ref(null);
const imageUrl = ref(null);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        imageUrl.value = URL.createObjectURL(file);
        console.log('Uploaded file:', file);
    }
};
</script>



        <!-- <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                    upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div> -->