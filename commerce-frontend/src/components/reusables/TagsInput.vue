<template>
    <div class="w-full max-w-sm mx-auto mt-2">
        <div class="relative">
            <div class="flex items-center border border-gray-300 rounded p-2 flex-wrap">
                <div class="flex flex-wrap space-x-1">
                    <span v-for="tag in tags" :key="tag"
                        class="bg-blue-100 text-blue-700 px-2 py-1 rounded flex items-center space-x-1 text-sm mb-1">
                        <span>{{ tag }}</span>
                        <button type="button" @click="removeTag(tag)" class="text-blue-700 hover:text-blue-900">
                            &times;
                        </button>
                    </span>
                </div>
                <input type="text" v-model="newTag" @keydown.enter.prevent="addTag" @click="showSuggestions = true"
                    @blur="hideSuggestions" class="flex-1 border-none outline-none" />
            </div>
            <div v-if="showSuggestions"
                class="absolute top-full left-0 w-full bg-white border border-gray-300 mt-1 rounded shadow-lg z-10">
                <ul class="flex flex-wrap">
                    <li v-for="suggestion in filteredSuggestions" :key="suggestion"
                        @mousedown.prevent="addTagFromSuggestion(suggestion)"
                        class="p-2 m-1 bg-white border rounded hover:bg-gray-100 cursor-pointer text-xs">
                        {{ suggestion }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const tags = ref([]);
const newTag = ref('');
const showSuggestions = ref(false);
const suggestions = ref(['new', 'sale', 'discounted', 'selling fast', 'last 10']);

const filteredSuggestions = computed(() => {
    const lowerNewTag = newTag.value.toLowerCase();
    return suggestions.value.filter(
        suggestion => suggestion.toLowerCase().includes(lowerNewTag) && !tags.value.includes(suggestion)
    );
});

const addTag = () => {
    const trimmedTag = newTag.value.trim();
    if (trimmedTag && !tags.value.includes(trimmedTag)) {
        tags.value.push(trimmedTag);
    }
    newTag.value = '';
};

const removeTag = (tag) => {
    tags.value = tags.value.filter(t => t !== tag);
};

const addTagFromSuggestion = (suggestion) => {
    if (!tags.value.includes(suggestion)) {
        tags.value.push(suggestion);
    }
    newTag.value = '';
    showSuggestions.value = false;
};

const hideSuggestions = () => {
    setTimeout(() => {
        showSuggestions.value = false;
    }, 100);
};
</script>