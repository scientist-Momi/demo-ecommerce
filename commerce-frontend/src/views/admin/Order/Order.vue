<template>
    <h1 class="text-2xl">Orders</h1>
    <div class="flex flex-col lg:flex-row space-x-2 mb-4">
        <StatsCard bgColorClass="bg-white" padding="p-2" iconColorClass="text-blue-600" iconTextSize="text-5xl" icon="groups" title="Total orders"
            :number="122" />
        <StatsCard bgColorClass="bg-white" padding="p-2" iconColorClass="text-blue-600" iconTextSize="text-5xl" icon="groups" title="Customers"
            :number="122" />
        <StatsCard bgColorClass="bg-white" padding="p-2" iconColorClass="text-blue-600" iconTextSize="text-5xl" icon="groups" title="Revenue" :number="122" />
    </div>

    <OrderTable />

</template>

<script setup>
import StatsCard from '../../../components/reusables/StatsCard.vue'
import OrderTable from '../Order/OrderTable.vue'
</script>