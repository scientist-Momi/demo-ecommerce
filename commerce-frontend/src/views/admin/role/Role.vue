<template>

    <Modal :showModal="showFirstModal" @close="showFirstModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                person_add
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Add New User</h3>
        </template>
        <RoleModal />
    </Modal>

    <div class="flex justify-between items-center">
        <h1 class="text-2xl">Role</h1>
        <div class="bg-red-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center">
            <span class="material-symbols-outlined">
                add
            </span>
            <p>New Role</p>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 p-4 bg-white mt-5">
        <div class="bg-white shadow-md p-4">
            <div class="flex space-x-2 items-center">
                <h2 class="mb-2 font-semibold">Administrator</h2>
                <div class="flex justify-center items-center rounded-full bg-red-600 text-white text-xs w-6 h-6">3</div>
            </div>

            <ul class="text-sm font-medium">
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Products</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Orders</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Users</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Customers</li>
                </div>
            </ul>
            <div class="flex justify-start space-x-2 mt-5">
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    View Role
                </div>
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Edit Role
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md p-4">
            <div class="flex space-x-2 items-center">
                <h2 class="mb-2 font-semibold">Administrator</h2>
                <div class="flex justify-center items-center rounded-full bg-red-600 text-white text-xs w-6 h-6">3</div>
            </div>

            <ul class="text-sm font-medium">
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Products</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Orders</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Users</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Customers</li>
                </div>
            </ul>
            <div class="flex justify-start space-x-2 mt-5">
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    View Role
                </div>
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Edit Role
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md p-4">
            <div class="flex space-x-2 items-center">
                <h2 class="mb-2 font-semibold">Administrator</h2>
                <div class="flex justify-center items-center rounded-full bg-red-600 text-white text-xs w-6 h-6">3</div>
            </div>

            <ul class="text-sm font-medium">
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Products</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Orders</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Users</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Customers</li>
                </div>
            </ul>
            <div class="flex justify-start space-x-2 mt-5">
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    View Role
                </div>
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Edit Role
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md p-4">
            <div class="flex space-x-2 items-center">
                <h2 class="mb-2 font-semibold">Administrator</h2>
                <div class="flex justify-center items-center rounded-full bg-red-600 text-white text-xs w-6 h-6">3</div>
            </div>

            <ul class="text-sm font-medium">
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Products</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Orders</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Users</li>
                </div>
                <div class="flex item-center m-1 space-x-1">
                    <div class="bg-red-500 p-[0.1rem]"></div>
                    <li>Customers</li>
                </div>
            </ul>
            <div class="flex justify-start space-x-2 mt-5">
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    View Role
                </div>
                <div @click="showFirstModal = true"
                    class="bg-gray-200 hover:bg-gray-300 p-2 px-3 text-xs rounded cursor-pointer text-black font-normal">
                    Edit Role
                </div>
            </div>
        </div>


    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import Modal from '@/components/admin/Modal.vue'
import RoleModal from '@/views/admin/role/RoleModal.vue'

const showFirstModal = ref(false)
</script>