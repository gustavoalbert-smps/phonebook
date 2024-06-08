<script setup>
import { ref } from 'vue';
import { Head, useForm } from "@inertiajs/vue3";

import Contact from './Contact.vue';
import Modal from '../../Components/Modal.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { UserPlusIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    contacts: {
        type: Array,
        required: true,
    },
});

const formData = useForm({
    name: '',
    email: '',
    telephone: '',
    image: null,
});

const deleteForm = useForm({});

const deleteContact = (id) => {
    if (confirm("Tem certeza que deseja deletar este contato?")) {
        deleteForm.delete(route("contacts.destroy", id), {
            preserveScroll: true,
        });
    }
};

const isModalVisible = ref(false);

const openModal = () => {
    isModalVisible.value = true;
};

const closeModal = () => {
    isModalVisible.value = false;
};

const handleTelephoneInput = (e) => {
    e.target.value = e.target.value.replace(/\D/g, '');
};

const handleImageUpload = (e) => {
    formData.image = e.target.files[0];
};

const submit = () => {
    formData.post(route("contacts.store"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
    });
};
</script>

<template>
    <Head title="Contatos" />
    <AuthenticatedLayout>
        <div class="flex p-6 items-center min-h-[92svh] md:w-4/5 sm:w-full overflow-auto mx-auto">
            <div id="contact-list" class="sm:max-md:max-w-full lg:min-h-[400px] max-h-[80svh] w-full bg-white rounded-lg shadow-lg overflow-y-scroll">
                <div class="sticky top-0 p-4 bg-white border-b-4 border-sky-200 flex items-center justify-between">
                    <div>
                        <h1 class=" text-lg md:text-2xl font-semibold">Lista de Contatos</h1>
                        <p class="text-xs font-extrabold text-gray-400">{{ props.contacts.length }} {{ (props.contacts.length > 1 ? 'contatos' : 'contato') }}</p>
                    </div>
                    <div>
                        <UserPlusIcon class="inline-block h-7 w-8 text-gray-500 cursor-pointer" @click="openModal"/>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    <Contact v-for="contact in props.contacts" :key="contact.id" :contact="contact" :deleteContact="deleteContact"/>
                </div>
            </div>
        </div>
        <Modal
            :show="isModalVisible"
            :maxWidth="'2xl'"
            :closeable="true"
            @close="closeModal"
        >
            <template v-slot>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Adicionar Contato</h2>
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nome</label>
                            <input v-model="formData.name" id="name" type="text" placeholder="Nome" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            :class="{
                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                    formData.errors.name,
                            }">
                            <InputError class="mt-2":message="formData.errors.name"/>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                            <input v-model="formData.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email"
                            :class="{
                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                    formData.errors.email,
                            }">
                            <InputError class="mt-2":message="formData.errors.email"/>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="telephone">Telefone</label>
                            <input v-model="formData.telephone" @input="handleTelephoneInput" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telephone" type="text" placeholder="Telefone" maxlength="11"
                            :class="{
                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                    formData.errors.telephone,
                            }">
                            <InputError class="mt-2":message="formData.errors.telephone"/>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Imagem</label>
                            <input @change="handleImageUpload" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" type="file"
                            :class="{
                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                    formData.errors.image,
                            }">
                            <InputError class="mt-2":message="formData.errors.image"/>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Adicionar
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline float-right" type="button" @click="closeModal">
                                Fechar
                            </button>
                        </div>
                    </form>
                </div>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>

<style scoped>
#contact-list::-webkit-scrollbar {
    width: 8px;
    z-index: 1;
}

#contact-list::-webkit-scrollbar-track {
    margin: 3px 0;
    border-radius: 0.5rem;
}

#contact-list::-webkit-scrollbar-thumb {
    margin: 6px;
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.2);
}
</style>