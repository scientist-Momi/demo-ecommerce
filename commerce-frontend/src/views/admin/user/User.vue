<template>

    <h1 class="text-2xl">Users</h1>
    <Spinner v-if="showSpinner" />
    <div v-else>
        <div class="flex flex-col lg:flex-row space-x-2 mb-2">
            <StatsCard bgColorClass="bg-white" padding="p-2" iconColorClass="text-blue-600" iconTextSize="text-5xl"
                icon="groups" title="Total Users" :number="usersTotal" />
            <StatsCard bgColorClass="bg-white" padding="p-2" iconColorClass="text-blue-600" iconTextSize="text-5xl"
                icon="groups" title="Customers" :number="customersTotal" />
            <StatsCard bgColorClass="bg-white" padding="p-2" iconColorClass="text-blue-600" iconTextSize="text-5xl"
                icon="groups" title="Revenue" :number="122" />
        </div>

        <UserTable />
    </div>

</template>

<script setup>
import StatsCard from '@/components/reusables/StatsCard.vue'
import UserNewModal from '../user/UserModal.vue'
import { ref, computed, onMounted } from "vue"
import UserTable from '../user/UserTable.vue'
import store from '@/store';
import Spinner from '@/components/reusables/Spinner.vue'

const usersTotal = computed(() => store.state.adminUsers.total);
const customersTotal = computed(() => store.state.customers.total);

const showModal = ref(false)
const showSpinner = ref(true)

onMounted(() => {
    setTimeout(() => {
        showSpinner.value = false;
    }, 1000);
});


</script>