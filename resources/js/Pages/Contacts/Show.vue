<script setup>
import { defineProps } from 'vue';
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { EnvelopeIcon } from '@heroicons/vue/24/solid';
import { DevicePhoneMobileIcon, ArrowUturnLeftIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/outline';

const props = defineProps({
    contact: {
        type: Object,
        required: true,
    },
    isModalVisible: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <Head title="Contato" />
    <AuthenticatedLayout>
        <div class="flex justify-center min-h-[60svh] mx-auto">
            <div class="w-full rounded-lg overflow-hidden">
                <div class="p-4 text-center mb-16">
                    <div class="relative">
                        <img :src="contact.image ? contact.image : 'https://phonebook-files.s3.sa-east-1.amazonaws.com/default-avatar.png'" alt="Profile" class="md:w-56 md:h-56 rounded-full mx-auto" />
                    </div>
                    <h2 class="mt-20 text-white text-6xl">{{ contact.name }}</h2>
                </div>
                <div class="absolute p-4 bg-white w-3/5 m-auto left-0 right-0 top-[500px] bottom-0 flex flex-col rounded-t-lg">
                    <div class="mx-auto my-auto">
                        <div class="flex items-center mb-8">
                            <div class="md:w-24 md:h-24 bg-yellow-500 text-white flex items-center justify-center rounded-full">
                                <EnvelopeIcon class="inline-block h-16 w-16 text-white cursor-pointer" />
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700 text-xl">{{ contact.email }}</p>
                                <p class="text-gray-500 text-lg">Email</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-4">
                            <div class="md:w-24 md:h-24 bg-blue-500 text-white flex items-center justify-center rounded-full">
                                <DevicePhoneMobileIcon class="inline-block h-16 w-16 text-white cursor-pointer" />
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700 text-xl">{{ contact.telephone }}</p>
                                <p class="text-gray-500 text-lg">Número</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0 w-3/5 top-[90%] m-auto left-0 right-0 bg-white shadow-[0px_-6px_21px_0px_#e2e8f0] border-gray-200">
            <div class="flex justify-around py-2">
                <div class="text-center">
                    <ArrowUturnLeftIcon class="h-12 w-12 cursor-pointer text-blue-500" />
                </div>
                <div class="text-center">
                    <PencilSquareIcon class="h-12 w-12 cursor-pointer text-blue-500" />
                </div>
                <div class="text-center">
                    <TrashIcon class="h-12 w-12 cursor-pointer text-blue-500" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>