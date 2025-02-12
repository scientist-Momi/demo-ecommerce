<template>
    <div class="bg-white p-2">
        <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe nisi reiciendis et dolore quo placeat, magni
            molestias, sed ullam laborum vitae assumenda recusandae quod ad quia eaque omnis officiis blanditiis!</h1>

            <div class="flex">
                <p>Name:  </p>
                <p>{{ currentUser.firstname }} {{ currentUser.lastname }}</p>
            </div>
            <div class="flex">
                <p>Email:  </p>
                <p>{{ currentUser.email }} </p>
            </div>
    </div>

</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import store from '../../store'

const currentUser = computed(() => store.state.user.data);
</script>