<template>
    <div :class="['flex-1 m-1 ml-0 shadow-xl', bgColorClass, padding]">
        <div class="flex items-center justify-between">
            <div class="p-4">
                <h3>{{ title }}</h3>
                <p class="text-2xl">{{ number }}</p>
            </div>
            <span :class="['material-symbols-outlined mr-5 ', iconColorClass, iconTextSize]">
                {{ icon }}
            </span>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    padding: {
        type: String,
        default: 'p-4'
    },
    bgColorClass: {
        type: String,
        default: 'bg-white'
    },
    iconColorClass: {
        type: String,
        default: 'text-blue-600'
    },
    iconTextSize: {
        type: String,
        default: 'text-7xl'
    },
    icon: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    number: {
        type: [String, Number],
        required: true
    }
});
</script>
