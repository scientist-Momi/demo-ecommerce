<template>
    <DecisionModal :show-modal="showModal" @close="closeModal"
        :question="'Are you sure you want to delete page? User would not be able to access page again.'"
        :loading-message="'Deleting page......'" :header="'Page Delete'" @confirmed="handleConfirmed" />


    <div class="bg-white p-6 rounded-md shadow-md mt-4">
        <h2 class="text-lg font-medium">Pages & Permissions</h2>
        <div class="py-4">
            <!-- Display a message if no permissions are available -->
            <div v-if="permissions.length === 0" class="text-center text-gray-500">
                No permissions available.
            </div>

            <!-- Display permissions data in a table if available -->
            <div v-else>
                <div v-if="!showNewPage" class="flex justify-end space-x-4">
                    <button v-if="isChanged" @click="initiateUpdateAll(userId)"
                        class="flex text-sm rounded-sm hover:bg-gray-300 p-2 bg-white text-gray-700 border-2 border-gray-500">

                        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <span v-if="!loading">Save Changes</span>
                        <span v-else>Updating permissions...</span>
                    </button>
                    <button @click="showNewPage = true"
                        class="text-sm rounded-sm hover:bg-red-500 p-2 bg-red-600 text-white">New Permission
                    </button>
                </div>
                <div v-if="showNewPage" class="rounded-lg bg-gray-200">
                    <div class="bg-gray-200 p-1 rounded-t-lg"></div>
                    <div class="bg-white p-2 pe-4 rounded-t-lg flex justify-between items-end">
                        <small>Select all pages you want user to have access to.</small>
                        <span @click="showNewPage = false"
                            class="cursor-pointer material-symbols-outlined hover:text-red-700">
                            close
                        </span>
                    </div>

                    <ul class="text-sm font-medium text-gray-900 bg-white border-gray-200">
                        <!-- Check if notPermitteds is empty -->
                        <li v-if="notPermitteds.length === 0"
                            class="w-full border-b border-gray-200 rounded-t-lg py-2 text-center">
                            <p class="text-gray-500">No pages available to assign permissions.</p>
                        </li>

                        <!-- Loop through notPermitteds if not empty -->
                        <li v-for="page in notPermitteds" :key="page.id"
                            class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600 py-2">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" :id="'page-checkbox-' + page.id" :value="page.id"
                                    v-model="selectedPages"
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer" />
                                <label :for="'page-checkbox-' + page.id"
                                    class="w-full py-3 ms-2 text-sm font-medium cursor-pointer">
                                    <p>{{ page.name }}</p>
                                    <!-- <small class="text-red-400">{{ page.description }}</small> -->
                                </label>
                            </div>
                        </li>
                    </ul>

                    <div class="flex justify-end p-2 pe-4 bg-white">
                        <!-- <button class="text-sm rounded-sm hover:bg-blue-500 p-2 bg-blue-600 text-white">Save Changes
                        </button> -->

                        <button type="button" @click="initiateUpdate(userId)" :disabled="!isFormValid"
                            class="group relative w-fit flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium text-white "
                            :class="{
        'cursor-not-allowed bg-indigo-300': !isFormValid,
        'hover:bg-blue-600 bg-blue-700': isFormValid,
    }">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>

                            <span v-if="!loading">Save Changes</span>
                            <span v-else>Updating permissions...</span>
                        </button>
                    </div>

                </div>
                <table v-else class="min-w-full bg-white">
                    <tbody>

                        <tr v-for="permission in permissions" :key="permission.id" class="border-b">
                            <td>
                                <!-- <span @click="deletePage(permission.page.id, userId)" -->
                                <span @click="confirmDelete(permission.page.id, userId)"
                                    class="material-symbols-outlined text-base cursor-pointer text-left hover:text-red-600 rounded-full">
                                    delete
                                </span>

                            </td>
                            <td class="p-4 font-semibold text-sm text-left">{{ permission.page.name }}</td>
                            <td class="p-4 ">
                                <label class="flex items-center">
                                    <input type="checkbox"
                                        @change="handleCheckboxChange(permission, 'can_view', $event)"
                                        class="form-checkbox" :checked="permission.can_view === 1" />
                                    <span class="ml-2 text-sm">View</span>
                                </label>
                            </td>
                            <td class="p-4">
                                <label class="flex items-center">
                                    <input type="checkbox" :checked="permission.can_add === 1"
                                        @change="handleCheckboxChange(permission, 'can_add', $event)"
                                        class="form-checkbox" />
                                    <span class="ml-2 text-sm">Add</span>
                                </label>
                            </td>
                            <td class="p-4">
                                <label class="flex items-center">
                                    <input type="checkbox" :checked="permission.can_edit === 1"
                                        @change="handleCheckboxChange(permission, 'can_edit', $event)"
                                        class="form-checkbox" />
                                    <span class="ml-2 text-sm">Edit</span>
                                </label>
                            </td>
                            <td class="p-4">
                                <label class="flex items-center">
                                    <input type="checkbox" :checked="permission.can_delete === 1"
                                        @change="handleCheckboxChange(permission, 'can_delete', $event)"
                                        class="form-checkbox" />
                                    <span class="ml-2 text-sm">Delete</span>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, defineEmits, defineProps, computed } from 'vue';
import { useRoute } from 'vue-router';
import axiosClient from "@/axios";
import store from '@/store';
import DecisionModal from "@/components/admin/DecisionModal.vue"

const props = defineProps({
    userId: {
        type: String,
    },
    permissions: {
        type: Object,
        required: true
    },
    notPermitteds: {
        type: Object,
        required: true
    }
});
const selectedPages = ref([])
const emit = defineEmits(['fetchBack'])

const isChanged = ref(false)
const showModal = ref(false)
const showNewPage = ref(false)
const loading = ref(false)

const handleCheckboxChange = (permission, key, event) => {
    permission[key] = event.target.checked ? 1 : 0;
    isChanged.value = true;
};

const deletePage = async (pageId, userId) => {
    try {
        const response = await axiosClient.delete(`/admin-users/${userId}/permissions/${pageId}`)
        console.log(response)
        // fetchPermissionsById(userId)
        emit('fetchBack', userId)
    } catch (error) {
        console.error("Error deleting page:", error)
    }
}

const pageIdToDelete = ref('')
const userIdToDelete = ref('')

const confirmDelete = (pageId, user) => {
    showModal.value = true
    pageIdToDelete.value = pageId
    userIdToDelete.value = user
}

const closeModal = () => {
    showModal.value = false;
}

const handleConfirmed = () => {
    setTimeout(() => {
        if (store.state.decision.isConfirmed) {
            deletePage(pageIdToDelete.value, userIdToDelete.value);
            console.log('deleted');
            closeModal()
        }
    }, 3000);
};

const isFormValid = computed(() => {
    return (
        selectedPages.value.length > 0
    );

});

const initiateUpdate = (userId) => {
    loading.value = true
    setTimeout(() => {
        updatePermissions(userId)
    }, 3000)
}
const initiateUpdateAll = (userId) => {
    loading.value = true
    setTimeout(() => {
        updatePermissionsAll(userId)
    }, 3000)
}

const updatePermissions = async (userId) => {
    try {
        const response = await axiosClient.post(`/admin-users/${userId}/permissions`, {
            pages: selectedPages.value
        })
        console.log(response)
        loading.value = false
        showNewPage.value = false
        selectedPages.value = []
        emit('fetchBack', userId)
    } catch (error) {
        console.error("Error deleting page:", error)
    }
}

const updatePermissionsAll = async (userId) => {
    try {
        const updatedPermissions = props.permissions.map((permission) => ({
            page_id: permission.page.id,
            can_view: permission.can_view,
            can_add: permission.can_add,
            can_edit: permission.can_edit,
            can_delete: permission.can_delete,
        }));
        console.log(updatedPermissions)
        const response = await axiosClient.post(`/admin-users/${userId}/permissions`, {
            permissions: updatedPermissions
        })
        console.log(response)
        loading.value = false
        showNewPage.value = false
        selectedPages.value = []
        emit('fetchBack', userId)
    } catch (error) {
        console.error("Error deleting page:", error)
    }
}

</script>