<template>
    <aside class="fixed top-0 left-0 flex flex-col w-1/5 bg-white border-r-[0.5px] border-black h-screen shadow-lg">

        <div class="border-b-[0.5px] border-black w-full flex justify-center items-center p-4 mt-16">
            <p>{{ currentUser.firstname }} {{ currentUser.lastname }}</p>
            <!-- <div v-if="isAuthenticated">
                <p>User: {{ getUser }}</p>
                <p>Token: {{ getToken }}</p>
            </div> -->
        </div>


        <ul class="text-start mt-2">
            <router-link :to="{ name: 'app.dashboard' }">
                <li title="view all"
                    class="flex justify-start space-x-4 items-center p-3 cursor-pointer hover:bg-blue-200">
                    <span class="material-icons">
                        dashboard
                    </span>
                    <p>Dashboard</p>
                </li>
            </router-link>
            <router-link :to="{ name: 'app.product' }">
                <li title="view all"
                    class="flex justify-start space-x-4 items-center p-3 cursor-pointer hover:bg-blue-200">
                    <span class="material-icons">
                        view_list
                    </span>
                    <p>Product</p>
                </li>
            </router-link>
            <router-link :to="{ name: 'app.order' }">
                <li title="view all"
                    class="flex justify-start space-x-4 items-center p-3 cursor-pointer hover:bg-blue-200">
                    <span class="material-icons">
                        feed
                    </span>
                    <p>Orders</p>
                </li>
            </router-link>
            <router-link :to="{ name: 'app.user' }">
                <li title="view all"
                    class="flex justify-start space-x-4 items-center p-3 cursor-pointer hover:bg-blue-200">
                    <span class="material-icons">
                        feed
                    </span>
                    <p>Users</p>
                </li>
            </router-link>
            <router-link :to="{ name: 'app.customer' }">
                <li title="view all"
                    class="flex justify-start space-x-4 items-center p-3 cursor-pointer hover:bg-blue-200">
                    <span class="material-icons">
                        feed
                    </span>
                    <p>Customers</p>
                </li>
            </router-link>
            <router-link :to="{ name: 'app.dashboard' }">
                <li title="view all"
                    class="flex justify-start space-x-4 items-center p-3 cursor-pointer hover:bg-blue-200">
                    <span class="material-icons">
                        feed
                    </span>
                    <p>Reports</p>
                </li>
            </router-link>
        </ul>
    </aside>
</template>

<script setup>

import { computed } from 'vue';
import store from '../../store';

// const store = useStore();
const currentUser = computed(() => store.state.user.data);
// const user = computed(() => store.getters.getUser? || 'Guest');
// const userEmail = computed(() => store.getters.getUser?.email || 'No email provided');
// const userToken = computed(() => store.getters.getToken);
</script>