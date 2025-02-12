<template>
    <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
        <img :src="image" alt="Card Image" class="w-full h-48 object-cover">

        <div class="absolute top-4 right-4">
            <button @click="toggleMenu"
                class="flex items-center justify-center text-white bg-blue-700 rounded-full w-10 h-10 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 ">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:rotate-45">
                    more_vert
                </span>
                <span class="sr-only">Open actions menu</span>
            </button>

            <div v-if="menuOpen"
                class="absolute mt-2 w-15 rounded-lg shadow-lg bg-white border border-gray-200 dark:border-gray-600 dark:bg-gray-700">

                <router-link :to="{ name: 'app.product.new' }">
                    <button type="button" title="Open Product" data-tooltip-target="tooltip-download"
                        data-tooltip-placement="left"
                        class="rounded-t-lg w-full px-[0.8rem] py-[0.2rem] text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                        <span class="material-symbols-outlined w-4 h-4 text-xl">
                            open_in_new
                        </span>
                    </button>
                </router-link>

                <!-- <button type="button" title="Edit Product" data-tooltip-target="tooltip-share"
                    data-tooltip-placement="left"
                    class="w-full px-[0.8rem] py-[0.2rem] text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                    <span class="material-symbols-outlined w-4 h-4 text-xl">
                        edit
                    </span>
                </button> -->

                <button type="button" title="Archive Product" data-tooltip-target="tooltip-print"
                    data-tooltip-placement="left"
                    class="w-full px-[0.8rem] py-[0.2rem] text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                    <span class="material-symbols-outlined w-4 h-4 text-xl">
                        visibility_off
                    </span>
                    <!-- <span class="material-symbols-outlined">
                        visibility
                    </span> -->
                </button>

                <button type="button" title="Delete Product" data-tooltip-target="tooltip-copy"
                    data-tooltip-placement="left"
                    class="rounded-b-lg w-full px-[0.8rem] py-[0.2rem] text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                    <span class="material-symbols-outlined w-4 h-4 text-xl">
                        delete
                    </span>
                </button>
            </div>
        </div>

        <!-- Card Content -->
        <div class="p-4">
            <h2 class="font-bold text-base mb-2">{{ productTitle }}</h2>
            <div class="flex items-center space-x-2 justify-between mb-1">
                <p class="text-gray-900 text-base font-semibold">£{{ price }}</p>
                <div v-if="status === 'published'" class="bg-blue-200 p-1 rounded-lg text-[0.6rem] text-blue-600">
                    published
                </div>
                <div v-if="status === 'scheduled'" class="bg-orange-200 p-1 rounded-lg text-[0.6rem] text-orange-600">
                    scheduled
                </div>
                <div v-if="status === 'inactive'" class="bg-red-200 p-1 rounded-lg text-[0.6rem] text-red-600">
                    inactive
                </div>
                <div v-if="status === 'draft'" class="bg-green-200 p-1 rounded-lg text-[0.6rem] text-green-600">
                    draft
                </div>
            </div>

            <div class="flex items-center space-x-2 justify-between">
                <p class="text-gray-700 text-sm">QTY: {{ available }}</p>
                <div v-if="soldOut" class="bg-red-200 text-[0.6rem] text-red-600 p-[0.15rem] rounded-lg px-1">
                    Sold out
                </div>
                <div v-else-if="lowOnStock"
                    class="bg-yellow-200 text-[0.6rem] text-yellow-600 p-[0.15rem] rounded-lg px-1">
                    Low on stock
                </div>
            </div>



            <div class="flex">
                <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
                <svg class="w-4 h-4 ms-1 text-gray-300 dark:text-gray-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
    image: String,
    productTitle: String,
    price: String,
    sold: Number,
    available: Number,
    status: String
});

const menuOpen = ref(false);

const soldOut = computed(() => props.available == 0);
const lowOnStock = computed(() => props.available > 0 && props.available <= 10);

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};


</script>
