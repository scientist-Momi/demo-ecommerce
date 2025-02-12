<template>
    <div v-if="currentUser">
        <Navbar />

        <main class="flex overflow-hidden">
            <Sidebar />

            <div class="w-4/5 ml-[20%] py-[5rem] text-start px-6 bg-gray-100 h-screen overflow-auto">
                <RouterView />
            </div>

        </main>
    </div>
    <div v-else>
        <p class="text-5xl">No user credentials</p>
    </div>

</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';
import { RouterLink, RouterView } from 'vue-router'
import store from '../../store'

const currentUser = computed(() => store.state.user.data);

onMounted(() => {
    store.dispatch('getCurrentUser')
})
</script>

<style scoped>

.main-content {
    margin-left: 20%;
    /* Sidebar width */
}
</style>