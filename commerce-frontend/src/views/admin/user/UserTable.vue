<template>

    <!-- <UserNewModal v-model:show="showModal" /> -->
    <!-- <UserNewModal v-model:show="showModal" /> -->
    <Modal :showModal="showFirstModal" @close="showFirstModal = false">
        <template #icon>
            <span class="material-symbols-outlined">
                person_add
            </span>
        </template>
        <template #header>
            <h3 class="text-xl font-semibold">Add New User</h3>
        </template>
        <NewUser />
    </Modal>

    <ConfirmationModal ref="confirmationModal" :showModal="showConfirmModal" @close="showConfirmModal = false"
        @confirm="deleteUser" @cancel="handleCancel">
        <template #icon>
            <span class="material-symbols-outlined">delete</span>
        </template>
        <template #header>
            Confirm Deletion
        </template>
        <template #default>
            <div v-if="!operationUnsuccessful">
                Are you sure you want to delete <span class="text-red-400 font-semibold">{{ userToDeleteFirst }} {{
                    userToDeleteLast }}</span>?
            </div>


            <div v-if="operationUnsuccessful" class="flex flex-col items-center justify-center py-8">
                <span class=" animate-bounce material-symbols-outlined font-bold text-5xl text-red-700">
                    person_cancel
                </span>
                <span>{{ errorMessage }}</span>
            </div>
        </template>

    </ConfirmationModal>

    <div class="relative p-4 bg-white">
        <div class="flex justify-between items-center">
            <div class="border flex items-center bg-gray-100 p-1 space-x-2 rounded-[0.25rem]">
                <span class="material-symbols-outlined text-xl ml-1">
                    search
                </span>
                <input v-model="searchQuery" @input="onSearch" type="text" placeholder="Search Users..."
                    class="bg-gray-100 border-0 p-[0.25rem] focus:ring-0 focus:border-0 rounded-[0.25rem] text-sm">
            </div>
            <div class="flex space-x-2">
                <div v-if="showFilterBlock" class="flex space-x-1">
                    <select v-model="filterQuery" @change="onFilter"
                        class="p-[0.3rem] px-2 space-x-1 rounded text-sm cursor-pointer">
                        <option value="">Filter by Status</option>
                        <option value="customer relations">Customer Relations</option>
                        <option value="admin">Admin</option>
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
                    <p>New User</p>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="min-w-full text-xs text-left text-gray-500 dark:text-gray-400 mt-2">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-y-2 border-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-[0.35rem]">USER</th>
                        <th scope="col" class="px-6 py-[0.35rem]">EMAIL</th>
                        <th scope="col" class="px-6 py-[0.35rem]">ROLE</th>
                        <th scope="col" class="px-6 py-[0.35rem]">LAST LOGIN</th>
                        <th scope="col" class="px-6 py-[0.35rem]">JOIN DATE</th>
                        <th scope="col" class="px-6 py-[0.35rem] whitespace-nowrap">CREATED BY</th>
                        <th scope="col" class="px-6 py-[0.35rem]">ACTION</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td class="px-6 py-[0.4rem] whitespace-nowrap uppercase font-normal">{{ user.role }}</td>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">{{ user.created_at }}</td>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap uppercase font-normal">{{ user.created_at }}</td>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap font-normal">Admin {{ user.created_by }}</td>
                        <td class="px-6 py-[0.4rem] whitespace-nowrap ">
                            <div class="flex space-x-1">
                                <!-- <span
                                    class="material-symbols-outlined text-lg px-1 border hover:bg-black hover:text-white cursor-pointer rounded">
                                    edit_square
                                </span> -->
                                <span @click="confirmDelete(user)"
                                    class="material-symbols-outlined text-red-500 text-lg border px-1 hover:bg-red-500 hover:text-white cursor-pointer rounded">
                                    delete
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
import NewUser from './modals/NewUser.vue'
import Modal from '@/components/admin/Modal.vue'
import ConfirmationModal from '@/components/admin/ConfirmationModal.vue'
import { ref, computed, onMounted, watch } from "vue"
import { useRouter } from 'vue-router';
import store from '@/store';

const showFirstModal = ref(false)
const showConfirmModal = ref(false)
const currentPage = ref('')
const totalPages = ref('')
const searchQuery = ref('')
const showFilterBlock = ref(false)
const filterQuery = ref('')

onMounted(() => {
    loadAdminUsers();
})

const users = computed(() => store.state.adminUsers.data);

const router = useRouter();

const navigateToUser = (userId) => {
    router.push({ name: 'app.user.detail', params: { userId } });
};

async function loadAdminUsers(page = 1, search = '', role = '' ) {
    try {
        const response = await store.dispatch('fetchAdminUsers', { page, search, role });

        const { data, meta } = response;

        currentPage.value = page;
        totalPages.value = meta.last_page;
        console.log('Fetched admin users:', data);
    } catch (error) {
        console.error('Failed to fetch admin users:', error);
    }
}

const handlePageChange = (page) => {
    if (page > 0 && page <= totalPages.value) {
        loadAdminUsers(page, searchQuery.value, filterQuery.value);
    }
}

const onSearch = () => {
    loadAdminUsers(1, searchQuery.value, filterQuery.value)
}

const onFilter = () => {
    loadAdminUsers(1, searchQuery.value, filterQuery.value)
}

watch(showFilterBlock, (newVal) => {
    if (!newVal) {
        filterQuery.value = ''; 
        loadAdminUsers(1, searchQuery.value, filterQuery.value)
    }
});

// const initials = computed(() => {
//     const firstName = currentUser.value?.firstname || '';
//     const lastName = currentUser.value?.lastname || '';
//     const firstInitial = firstName.charAt(0).toUpperCase();
//     const lastInitial = lastName.charAt(0).toUpperCase();
//     return `${firstInitial}${lastInitial}`;
// });

const extractInitials = (first, last) => {
    const firstInitial = first.charAt(0).toUpperCase();
    const lastInitial = last.charAt(0).toUpperCase();
    return `${firstInitial}${lastInitial}`;
}

// function getUsers() {
//     store.dispatch("getUsers", {
//         // url,
//         // search: search.value,
//         // per_page: perPage.value,
//         // sort_field: sortField.value,
//         // sort_direction: sortDirection.value
//     });
// }






const userIdToDelete = ref(null);
const userToDeleteFirst = ref('')
const userToDeleteLast = ref('')
const operationUnsuccessful = ref(false)
const errorMessage = ref('')
// const btnLoading = ref(false)

const confirmDelete = (user) => {
    userIdToDelete.value = user.id;
    userToDeleteFirst.value = user.firstname;
    userToDeleteLast.value = user.lastname;
    showConfirmModal.value = true;
};

const deleteUser = () => {
    // handleLoading(true); 
    // btnLoading.value = true
    // Call your delete function here, using `userIdToDelete.value`
    console.log(`Deleting user with ID: ${userIdToDelete.value}`);
    // Example: this.$store.dispatch('deleteUser', userIdToDelete.value);
    store.dispatch('deleteUser', userIdToDelete.value)
        .then(res => {
            // TODO Show notification

            store.dispatch('fetchAdminUsers', { page: 1 })
            showConfirmModal.value = false
            operationUnsuccessful.value = false
        })
        .catch(({ response }) => {
            // btnLoading.value = false
            operationUnsuccessful.value = true
            if (response && response.status == 403) {
                // alert('Please check your email.')
                errorMessage.value = 'Something went wrong. You are unauthorised.'

            }
            else {
                errorMessage.value = 'Something went wrong. Please try again.'
            }
            console.error(response);
        })
    showConfirmModal.value = false;
};

const handleClose = () => {
    showConfirmModal.value = false;
};

const handleCancel = () => {
    console.log('User chose to cancel the deletion.');
    // btnLoading.value = false;
    // handleLoading(false);
    showConfirmModal.value = false;
};

// const handleLoading = (loading) => {
//     btnLoading.value = loading;
// };
</script>