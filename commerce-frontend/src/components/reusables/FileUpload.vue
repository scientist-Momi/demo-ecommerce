<template>
    <!-- <div
        class="flex w-full flex-col items-center justify-center pt-5 text-slate-800 sm:px-5  dark:text-slate-100 bg-red-400"> -->
        <!-- File Upload Section -->
            <!-- Hidden Input -->

            <input type="file" multiple hidden ref="fileInputRef" @change="handleFileUpload" />

            <!-- Drag & Drop Area -->

            <div @click="triggerFileUpload" class="group flex w-full items-center justify-center overflow-hidden rounded-lg bg-indigo-100 p-7 focus:border-2 focus:border-indigo-400 focus:outline-none dark:bg-slate-800 focus:dark:border-slate-400"
                role="region" aria-label="Drag and drop files or click to upload" tabindex="0"
                @keydown.enter="triggerFileUpload" @dragenter="handleDragEnter" @dragleave="handleDragLeave"
                @dragover.prevent="handleDragOver" @drop.prevent="handleDrop">
                <!-- Drag & Drop Animation -->

                <div v-if="isDragActive"
                    class="absolute inset-0 h-full w-full animate-spin-slow rounded-lg bg-gradient-to-br from-indigo-400 to-indigo-700 opacity-100 blur-sm transition-all duration-300 ease-linear dark:from-slate-400 dark:to-slate-700" />
                <div v-if="isDragActive"
                    class="relative flex h-full w-full items-center justify-center rounded-lg bg-indigo-100 text-4xl dark:bg-slate-800">
                    Drop
                </div>
                <div v-else class="flex items-center gap-4 w-full">
                    <span class="material-symbols-outlined text-5xl text-indigo-400 dark:text-slate-100">
                    upload_file
                    </span>

                    <div>

                    <h3 class="text-base">
                        Drag and drop files or
                    </h3>

                    <!-- File Selection Button -->

                    <div class="bg-gradient-to-br from-indigo-300 to-indigo-300 px-4 py-2
             text-xs text-white hover:from-indigo-300 hover:to-indigo-400 
             focus:border-2 focus:border-indigo-500 focus:outline-none dark:from-slate-900 
             dark:to-slate-700 dark:text-slate-100 dark:shadow-slate-800 hover:dark:from-slate-700 
             hover:dark:to-slate-900 focus:dark:border-slate-400" :class="{
                'cursor-not-allowed opacity-50':
                    uploadedFiles.length >= maxFilesToUpload,
            }" :disabled="uploadedFiles.length >= maxFilesToUpload">
                        <span v-if="uploadedFiles.length === 0">Choose Files To Upload</span>
                        <span v-else>Add More Files</span>
                    </div>
                    <p v-if="isFileCountError" role="alert" aria-live="polite" class="text-center text-xs text-red-400">
                        You can only upload a maximum of {{ maxFilesToUpload }} files.
                    </p>
                    <p v-else-if="isFileTypeError" role="alert" aria-live="polite"
                        class="text-center text-xs text-red-400">
                        Only Images and PDF Files are allowed.
                    </p>
                    <p v-else-if="isFileSizeError" role="alert" aria-live="polite"
                        class="text-center text-xs text-red-400">
                        Maximum file size is {{ maxFileSizeToUpload }}MB.
                    </p>
                    <p v-else class="text-center text-xs text-slate-400">
                        Up to {{ maxFilesToUpload }} files, each within
                        {{ maxFileSizeToUpload }}MB.
                    </p>
                </div>
            </div>
            </div>

            <!-- Uploaded Files Section -->

            <div v-if="uploadedFiles.length > 0" class="flex w-full justify-center sm:justify-start mt-3">
                <h3 class="text-center text-base">Uploaded Files</h3>
            </div>

            <div class="grid grid-cols-2 w-full place-items-center gap-4 py-4">
                <div v-if="uploadedFiles.length > 0" v-for="(file, index) in uploadedFiles" :key="file.name">
                    <div class="flex w-full items-center rounded-lg bg-indigo-100 p-2 sm:w-80 dark:bg-slate-800">
                        <!-- Icon Based On File Type -->

                        <div class="w-1/12 rounded-lg text-center md:p-1">
                            <template v-if="file.type.startsWith('image/')">
                                <!-- <PhotoIcon /> -->
                                <span class="material-symbols-outlined">
                                    image
                                </span>
                            </template>
                            <template v-else-if="file.type.startsWith('application/')">
                                <!-- <DocumentIcon /> -->
                                <span class="material-symbols-outlined">
                                    description
                                </span>
                            </template>
                            <template v-else-if="file.type.startsWith('audio/')">
                                <!-- <SpeakerWaveIcon /> -->
                                <span class="material-symbols-outlined">
                                    volume_up
                                </span>
                            </template>
                            <template v-else-if="file.type.startsWith('video/')">
                                <!-- <VideoCameraIcon /> -->
                                <span class="material-symbols-outlined">
                                    movie
                                </span>
                            </template>
                            <template v-else-if="file.type.startsWith('text/')">
                                <!-- <DocumentTextIcon /> -->
                                <span class="material-symbols-outlined">
                                    edit_note
                                </span>
                            </template>
                            <template v-else>
                                <!-- <DocumentIcon /> -->
                                <span class="material-symbols-outlined">
                                    description
                                </span>
                            </template>
                        </div>

                        <!-- File Details -->

                        <div class="w-10/12 px-2">
                            <h4 class="truncate text-base">
                                {{ file.name }}
                            </h4>
                            <p class="text-xs">{{ formatFileSize(file.size) }}</p>
                        </div>

                        <!-- Remove File Button -->

                        <div @click="removeUploadedFile(index)"
                            class="size-6 w-1/12 cursor-pointer rounded-lg text-center hover:text-red-400">
                            <!-- <XMarkIcon class="size-6" /> -->
                            <span class="material-symbols-outlined">
                                close
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Progress Animation On Submit -->

            <div v-if="uploading" role="progressbar" aria-valuenow="uploadProgress"
                class="relative h-2 w-full rounded-full bg-indigo-100 dark:bg-slate-100">
                <span class="absolute bottom-2 right-0 text-xs">{{ uploadProgress }}% Uploaded</span>
                <div class="h-2 rounded-full bg-indigo-400 text-xs dark:bg-slate-700"
                    :style="{ width: `${uploadProgress}%` }" />
            </div>

            <!-- Submit Button -->

            <button v-if="uploadedFiles.length > 0" @click="handleSubmit" class="rounded-full px-6 py-2 text-slate-100"
                :class="uploadSuccess
                    ? 'bg-gradient-to-br from-green-400 to-green-300 shadow-md shadow-green-400'
                    : uploadFailed
                        ? 'bg-gradient-to-br from-red-400 to-red-300 shadow-md shadow-red-400'
                        : 'bg-gradient-to-br from-indigo-400 to-indigo-300 shadow-md shadow-indigo-400 hover:from-indigo-300 hover:to-indigo-400 dark:from-slate-900 dark:to-slate-700 dark:shadow-slate-800 dark:hover:from-slate-700 dark:hover:to-slate-900'
                " :disabled="uploadedFiles.length === 0">
                <!-- Submission Status -->

                <div v-if="uploading" class="flex gap-2">
                    <!-- <ArrowPathIcon class="size-6 animate-spin" /> -->
                    <span class="material-symbols-outlined size-6 animate-spin">
                        sync
                    </span>
                    <span>In Progress...</span>
                </div>
                <div v-else>
                    <span v-if="uploadSuccess" class="flex gap-2">
                        <!-- <CheckIcon class="size-6" /> -->
                        <span class="material-symbols-outlined">
                            check
                        </span>
                        Success
                    </span>
                    <span v-else-if="uploadFailed" class="flex gap-2">
                        <!-- <XMarkIcon class="size-6" /> -->
                        <span class="material-symbols-outlined">
                            close
                        </span>
                        Unsuccessful
                    </span>
                    <span v-else>Submit</span>
                </div>
            </button>
        
    <!-- </div> -->
</template>

<script setup>
import { ref } from "vue";

// Props for the File Upload Component

const props = defineProps({
    maxFilesToUpload: {
        type: Number,
        default: 5,
    },
    maxFileSizeToUpload: {
        type: Number,
        default: 10,
    },
    allowedTypes: {
        type: Array,
        default: () => ["image/jpeg", "image/png", "application/pdf"],
    },
    submitHandler: {
        type: Function,
        default: () => { },
    },
});

// Reactive Variables

const uploadedFiles = ref([]);
const fileInputRef = ref(null);
const uploading = ref(false);
const uploadSuccess = ref(false);
const uploadFailed = ref(false);
const isDragActive = ref(false);
const isFileCountError = ref(false);
const isFileSizeError = ref(false);
const isFileTypeError = ref(false);
const uploadProgress = ref(0);

// Functions

function triggerFileUpload() {
    fileInputRef.value.click();
}

function handleFileUpload(event) {
    const files = event.target.files;
    const remainingSlots = props.maxFilesToUpload - uploadedFiles.value.length;

    const validFiles = [];
    const oversizedFiles = [];
    const invalidTypeFiles = [];

    // Filter Files Based On Size & Type

    for (let file of files) {
        const maxSize = props.maxFileSizeToUpload * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            oversizedFiles.push(file);
        } else if (!props.allowedTypes.includes(file.type)) {
            invalidTypeFiles.push(file);
        } else {
            validFiles.push(file);
        }
    }

    // Handle Oversized Files

    if (oversizedFiles.length > 0) {
        isFileSizeError.value = true;

        setTimeout(() => {
            isFileSizeError.value = false;
        }, 3000);
    }

    // Handle Invalid Files

    if (invalidTypeFiles.length > 0) {
        isFileTypeError.value = true;

        setTimeout(() => {
            isFileTypeError.value = false;
        }, 3000);
    }

    // Handle Valid Files

    if (validFiles.length > remainingSlots) {
        validFiles.slice(0, remainingSlots).forEach((file) => {
            uploadedFiles.value.push({
                name: file.name,
                size: file.size,
                type: file.type || "unknown",
            });
        });
        isFileCountError.value = true;
        setTimeout(() => {
            isFileCountError.value = false;
        }, 3000);
    } else {
        validFiles.forEach((file) => {
            uploadedFiles.value.push({
                name: file.name,
                size: file.size,
                type: file.type || "unknown",
            });
        });
    }
}

function handleSubmit() {
    if (props.submitHandler) {
        props.submitHandler(uploadedFiles.value);
    }

    // Perform The Original Submit Logic Here

    // For example, you might want to add additional logic here such as resetting the component state
    // This logic will execute after the custom submit handler

    uploading.value = true;
    uploadFailed.value = false;

    // Simulating Upload Progress With Randoms

    const intervalId = setInterval(() => {
        uploadProgress.value += Math.floor(Math.random() * 20);

        // Ensure uploadProgress doesn't exceed 100%
        uploadProgress.value = Math.min(uploadProgress.value, 100);

        if (uploadProgress.value >= 100) {
            clearInterval(intervalId);
            uploadSuccess.value = true;
            uploading.value = false;

            // Simulate Submission Failure (For Demo Purpose)

            // If you want to trigger uploadFailed manually, you can do it here
            // uploadFailed.value = true;

            // Resetting
            setTimeout(() => {
                uploadedFiles.value = [];
                uploadSuccess.value = false;
                uploadFailed.value = false;
                fileInputRef.value.value = "";
                uploadProgress.value = 0;
            }, 2000);
        }
    }, 250);
}

function handleDragEnter() {
    isDragActive.value = true;
}

function handleDragLeave() {
    isDragActive.value = false;
}

function handleDragOver(event) {
    event.preventDefault();
}

function handleDrop(event) {
    event.preventDefault();
    isDragActive.value = false;
    const files = event.dataTransfer.files;

    // Using handleFileUpload function to process dropped files

    handleFileUpload({ target: { files } });
}

function removeUploadedFile(index) {
    uploadedFiles.value.splice(index, 1);
}

function formatFileSize(bytes) {
    // Conversion of Bytes to KB and MB

    if (bytes >= 1024 * 1024) {
        return `${(bytes / (1024 * 1024)).toFixed(2)} MB`;
    } else {
        return `${(bytes / 1024).toFixed(2)} KB`;
    }
}
</script>
