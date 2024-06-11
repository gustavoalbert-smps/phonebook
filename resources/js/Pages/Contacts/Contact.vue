<script setup>
import { defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    contact: {
        type: Object,
        required: true,
    },
    deleteContact: {
        type: Function,
        required: true,
    },
});

const imageLoaded = ref(false);

const handleDelete = () => {
    props.deleteContact(props.contact.id);
};

const showContact = () => {
    router.get(route('contacts.show', props.contact.id));
};

const handleImageLoad = () => {
    imageLoaded.value = true;
};
</script>

<template>
    <div class="flex items-center p-4 border-b border-gray-200">
        <img :src="contact.image ? contact.image : 'https://phonebook-files.s3.sa-east-1.amazonaws.com/default-avatar.svg'"
            alt="contact image" class="max-w-12 w-12 h-12 rounded-full mr-4 cursor-pointer" 
            :class="{'bg-gray-400 animate-pulse': !imageLoaded}" @click="showContact" @load="handleImageLoad">
        <div class="flex-1 cursor-pointer" @click="showContact">
            <p class="text-sm md:text-lg font-semibold line-clamp-1">{{ contact.name }}</p>
        </div>
        <button class="ml-4 text-blue-500 hover:text-blue-700" @click="handleDelete">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</template>

<style scoped></style>