<template>
    <div class="relative p-4 bg-white">
        <div class="flex justify-between items-center">
            <div class="border flex items-center bg-gray-100 p-1 space-x-2 rounded-[0.25rem]">
                <span class="material-symbols-outlined text-xl ml-1">
                    search
                </span>
                <input v-model="searchQuery" @input="onSearch" type="text" placeholder="Search Customers..."
                    class="bg-gray-100 border-0 p-[0.25rem] focus:ring-0 focus:border-0 rounded-[0.25rem] text-sm">
            </div>
            <div class="flex space-x-2">
                <div v-if="showFilterBlock" class="flex space-x-1">
                    <select v-model="filterQuery" @change="onFilter"
                        class="p-[0.3rem] px-2 space-x-1 rounded text-sm cursor-pointer">
                        <option value="">Filter by Status</option>
                        <option value="0">Active</option>
                        <option value="1">locked</option>
                    </select>

                </div>
                <div @click="showFilterBlock = !showFilterBlock"
                    class=" flex items-center text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer border border-blue-700">
                    <span v-if="!showFilterBlock" class="material-symbols-outlined text-blue-700">
                        filter_alt
                    </span>
                    <span v-if="showFilterBlock" class="material-symbols-outlined text-red-700">
                        close
                    </span>
                </div>
                <div @click="showFirstModal = true"
                    class="bg-red-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    <p>New Customer</p>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="min-w-full text-xs text-left text-gray-500 dark:text-gray-400 mt-2">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-[0.35rem]">PRODUCT</th>
                        <th scope="col" class="px-6 py-[0.35rem]">CATEGORY</th>
                        <th scope="col" class="px-6 py-[0.35rem]">PRICE</th>
                        <th scope="col" class="px-6 py-[0.35rem]">QTY</th>
                        <th scope="col" class="px-6 py-[0.35rem]">STATUS</th>
                        <th scope="col" class="px-6 py-[0.35rem]">TOTAL ORDER</th>
                        <th scope="col" class="px-6 py-[0.35rem]">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="users.length === 0" class="bg-white border-b font-bold text-center">
                        <td colspan="6" class="px-6 py-3">No Product available.</td>
                    </tr>
                    <tr v-for="(user, index) in users" :key="user.id" class="bg-white border-b font-bold">
                        <th scope="row" class="px-6 py-[0.4rem] text-gray-900 whitespace-nowrap">
                            <div class="flex items-center space-x-1">
                                <div
                                    class="relative inline-flex items-center justify-center w-[1.75rem] h-[1.75rem] overflow-hidden bg-gray-100 rounded-full">
                                    <span class="font-medium text-gray-600">
                                        {{ extractInitials(user.firstname, user.lastname) }}
                                    </span>
                                </div>
                                <h2 @click="navigateToUser(user.id)"
                                    class="font-medium hover:text-green-500 cursor-pointer">
                                    {{ user.firstname }} {{ user.lastname }}
                                </h2>
                            </div>
                        </th>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">{{ user.email }}</td>

                        <td class="px-6 py-[0.4rem] whitespace-nowrap  font-normal">
                            <span :class="{
                    'bg-green-200 text-green-800 px-2 py-1 rounded': !user.is_locked,
                    'bg-red-200 text-red-800 px-2 py-1 rounded': user.is_locked
                }">
                                {{ user.is_locked ? 'Locked' : 'Active' }}
                            </span>

                            {{ user.status }}
                        </td>


                        <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">{{ user.created_at }}</td>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap uppercase font-normal">{{ user.created_at }}</td>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap ">
                            <div class="flex space-x-1">
                                <span @click="confirmDelete(user)"
                                    class="material-symbols-outlined text-red-500 text-lg border px-1 hover:bg-red-500 hover:text-white cursor-pointer rounded">
                                    delete
                                </span>

                                <span @click="confirmLockUpdate(user.id)"
                                    class="material-symbols-outlined text-lg border px-1 cursor-pointer rounded">
                                    {{ user.is_locked ? 'lock' : 'lock_open_right' }}
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>



        <!-- Pagination Controls -->
        <nav aria-label="Page navigation example" class="mt-2">
            <ul class="inline-flex -space-x-px text-sm">
                <li>
                    <a href="#" @click.prevent="handlePageChange(currentPage - 1)" :class="[
                    'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg',
                    currentPage === 1 ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-100 hover:text-gray-700'
                ]" :aria-disabled="currentPage === 1">
                        Previous
                    </a>
                </li>
                <li v-for="page in totalPages" :key="page">
                    <a href="#" @click.prevent="handlePageChange(page)" :class="[
                    'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300',
                    page === currentPage ? 'text-blue-600 border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : 'hover:bg-gray-100 hover:text-gray-700'
                ]" :aria-current="page === currentPage ? 'page' : undefined">
                        {{ page }}
                    </a>
                </li>
                <li>
                    <a href="#" @click.prevent="handlePageChange(currentPage + 1)" :class="[
                    'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg',
                    currentPage === totalPages ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-100 hover:text-gray-700'
                ]" :aria-disabled="currentPage === totalPages">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
// import NewCustomer from '../customer/modal/NewCustomer.vue'
import Modal from '@/components/admin/Modal.vue'
import ConfirmationModal from '@/components/admin/ConfirmationModal.vue'
import DecisionModal from '@/components/admin/DecisionModal.vue'
import { ref, computed, onMounted, watch } from "vue"
import { useRouter } from 'vue-router';
import store from '@/store';
import axiosClient from "@/axios";

const showFirstModal = ref(false)
const showConfirmModal = ref(false)

const currentPage = ref('')
const totalPages = ref('')
const searchQuery = ref('')
const showFilterBlock = ref(false)
const filterQuery = ref(null)

const users = computed(() => store.state.customers.data);
</script>