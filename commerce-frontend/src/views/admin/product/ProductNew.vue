<template>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl">Add New Product</h1>
        <div class="flex space-x-2">
            <router-link :to="{ name: 'app.product' }">
                <div
                    class="border border-gray-500  bg-white text-sm p-2 px-2 space-x-1 cursor-pointer flex items-center">
                    <p>Cancel</p>
                </div>
            </router-link>

            <div class="bg-blue-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center">
                <span class="material-symbols-outlined">
                    add
                </span>
                <p>Save Product</p>
            </div>
        </div>

    </div>



    <div class="flex flex-col lg:flex-row space-x-6 mt-5 max-h-screen ">
        <div class="lg:w-[30%] w-full max-h-screen ">
            <div class="max-w-sm mx-auto">
                <div class="bg-white rounded-lg p-10 shadow-md pb-14 mb-4">
                    <div class="text-lg font-semibold mb-10">Thumbnail</div>
                    <div class="relative flex flex-col items-center justify-center w-full h-48"
                        @click="triggerFileInput">
                        <template v-if="imageUrl">
                            <img :src="imageUrl" alt="Thumbnail" class="object-cover w-full h-full rounded-lg" />
                        </template>
                        <template v-else>
                            <div class="bg-white shadow-2xl p-5 text-center rounded-lg mb-3">
                                <span class="material-symbols-outlined text-9xl text-gray-300">
                                    photo_prints
                                </span>
                            </div>

                            <div class="text-center text-xs text-gray-500 mt-2 px-4">
                                Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image
                                files are accepted
                            </div>
                        </template>

                        <div class="absolute top-[-45px] right-[7px] m-2 cursor-pointer">
                            <div
                                class="w-10 h-10 bg-white shadow-lg text-center flex justify-center items-center rounded-full hover:bg-gray-300">
                                <input type="file" ref="fileInput" @change="handleFileUpload" hidden />
                                <span class="material-symbols-outlined text-xl text-gray-600">
                                    edit
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-lg p-8 shadow-md pb-10 mb-4">
                    <div class="flex justify-between mb-4 items-center">
                        <h1 class="font-semibold text-xl">Status</h1>
                        <div v-if="statusOption === 'inactive'" class="bg-red-600 p-2 rounded-full"></div>
                        <div v-if="statusOption === 'published'" class="bg-blue-600 p-2 rounded-full"></div>
                        <div v-if="statusOption === 'draft'" class="bg-green-600 p-2 rounded-full"></div>
                        <div v-if="statusOption === 'scheduled'" class="bg-orange-400 p-2 rounded-full"></div>
                    </div>

                    <div class="mb-4">
                        <select class="border block p-2.5 w-full text-sm rounded-lg" v-model="statusOption">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <small class="text-gray-400">Set the product status.</small>
                    </div>

                    <div v-if="statusOption === 'scheduled'" class="">
                        <small>Select publishing date and time</small>
                        <VueCtkDateTimePicker v-model="date" />
                    </div>

                </div>
                <div class="bg-white rounded-lg p-8 shadow-md pb-10 mb-4">
                    <div class="flex justify-between mb-4 items-center">
                        <h1 class="font-semibold text-xl">Product Details</h1>
                    </div>

                    <div class="mb-4">
                        <small>Categories</small>
                        <select class="border block p-2.5 w-full text-sm rounded-lg">
                            <option selected value="">Select an option</option>
                            <option value="published">Computers</option>
                            <option value="draft">Watches</option>
                            <option value="scheduled">Headphones</option>
                            <option value="inactive">Footwear</option>
                        </select>

                        <small class="text-gray-400">Add product to a category.</small>
                    </div>
                    <div class="mb-4">
                        <small>Tags</small>

                        <TagsInput />

                        <small class="text-gray-400">Add tags to a product.</small>
                    </div>

                </div>
            </div>

        </div>





        <div class="lg:w-[70%] w-full max-h-screen ">


            <div class="border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                    <li class="me-2">
                        <router-link :to="{ name: 'app.product.new.general' }">
                            <div :class="[
            'inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group',
            isActiveRoute('app.product.new.general') ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent hover:text-gray-600 hover:border-gray-300'
        ]">
                                <span
                                    :class="['material-symbols-outlined me-2', isActiveRoute('app.product.new.general') ? 'text-blue-600' : '']">
                                    ballot
                                </span>
                                General
                            </div>
                        </router-link>
                    </li>
                    <li class="me-2">
                        <router-link :to="{ name: 'app.product.new.advanced' }">
                            <div :class="[
            'inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group',
            isActiveRoute('app.product.new.advanced') ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent hover:text-gray-600 hover:border-gray-300'
        ]">
                                <span
                                    :class="['material-symbols-outlined me-2', isActiveRoute('app.product.new.advanced') ? 'text-blue-600' : '']">
                                    width_wide
                                </span>
                                Advanced
                            </div>
                        </router-link>
                    </li>

                    <li>
                        <a
                            class="inline-block p-4 text-gray-400 rounded-t-lg cursor-not-allowed dark:text-gray-500">Reviews</a>
                    </li>
                </ul>
            </div>


            <RouterView />

        </div>

    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';

import FileUpload from "../../../components/reusables/FileUpload.vue";
import TagsInput from "../../../components/reusables/TagsInput.vue";
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';


const handleSubmit = (uploadedFiles) => {
    // Custom logic for handling the uploaded files
    alert("Uploaded Files:", uploadedFiles);

    // You can perform additional actions here, such as sending files to a server
};


const date = ref(new Date());

const route = useRoute();

const isActiveRoute = (routeName) => {
    return route.name === routeName;
};

const statusOption = ref("published");

// thumbnail

const fileInput = ref(null);
const imageUrl = ref(null);
const selectedOptions = ref([]);

const toggleOption = (option) => {
    if (selectedOptions.value.includes(option)) {
        selectedOptions.value = selectedOptions.value.filter(opt => opt !== option);
    } else {
        selectedOptions.value.push(option);
    }
};

const getClass = (option) => {
    return selectedOptions.value.includes(option) ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-900';
};

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
