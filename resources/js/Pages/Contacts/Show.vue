<script setup>
import { defineProps, ref} from 'vue';
import { Head, useForm, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import Modal from '../../Components/Modal.vue';
import { EnvelopeIcon } from '@heroicons/vue/24/solid';
import { DevicePhoneMobileIcon, ArrowUturnLeftIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/outline';

const props = defineProps({
    contact: {
        type: Object,
        required: true,
    },
});

const formData = useForm({
    _method: 'put',
    name: props.contact.name,
    email: props.contact.email,
    telephone: props.contact.telephone,
    image: null,
});

const imageLoaded = ref(false);
const isModalVisible = ref(false);

const openModal = () => {
    isModalVisible.value = true;
    formData.name = props.contact.name,
    formData.email = props.contact.email,
    formData.telephone = props.contact.telephone,
    formData.image = null,
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

const handleImageLoad = () => {
    imageLoaded.value = true;
};

const submit = () => {
    formData.post(route("contacts.update", props.contact.id), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            closeModal();
        },
    });
};

const deleteForm = useForm({});

const deleteContact = (id) => {
    if (confirm("Tem certeza que deseja deletar este contato?")) {
        deleteForm.delete(route("contacts.destroy", id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Contato" />
    <AuthenticatedLayout>
        <div class="flex justify-center min-h-[60svh] mx-auto">
            <div class="w-full rounded-lg overflow-hidden">
                <div class="p-4 text-center mb-16">
                    <div class="relative">
                        <img :src="contact.image ? contact.image : 'https://phonebook-files.s3.sa-east-1.amazonaws.com/default-avatar.svg'" alt="Profile" 
                        class="w-36 h-36 md:w-56 md:h-56 rounded-full mx-auto" :class="{'bg-gray-400 animate-pulse': !imageLoaded}" 
                        @load="handleImageLoad"/>
                    </div>
                    <h2 class=" min-[320px]:max-[404px]:mt-[10%] min-[404px]:max-[576px]:mt-[15%] md:mt-20 text-white text-4xl md:text-6xl">{{ contact.name }}</h2>
                </div>
                <div class="absolute bg-white w-full md:w-full min-[1366px]:w-4/5 m-auto left-0 right-0 top-[50%] bottom-0 flex flex-col rounded-t-lg justify-between">
                    <div class="m-auto">
                        <div class="flex items-center mb-8">
                            <div class="w-12 h-12 md:w-24 md:h-24 bg-yellow-500 text-white flex items-center justify-center rounded-full">
                                <EnvelopeIcon class="inline-block h-8 w-8 md:h-16 md:w-16 text-white cursor-pointer" />
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700 text-lg md:text-2xl">{{ contact.email }}</p>
                                <p class="text-gray-500 md:text-xl">Email</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 md:w-24 md:h-24 bg-blue-500 text-white flex items-center justify-center rounded-full">
                                <DevicePhoneMobileIcon class="inline-block h-8 w-8 md:h-16 md:w-16 text-white cursor-pointer" />
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700 text-lg md:text-xl">{{ contact.telephone }}</p>
                                <p class="text-gray-500 md:text-lg">Número</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 flex-row bottom-0 top-[90%] md:top-[92%] left-0 right-0 bg-white shadow-[0px_-6px_21px_0px_#e2e8f0] border-gray-200">
                        <div class="flex justify-around items-center h-full">
                            <div class="text-center i h-10 w-16 md:h-12 md:w-28 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full shadow-2xl cursor-pointer overflow-hidden transform hover:scale-x-110 hover:scale-y-105 transition duration-300 ease-out" @click="router.get(route('contacts.index'))">
                                <ArrowUturnLeftIcon class="w-8 md:w-10 text-white inline-block items-center h-full" />
                            </div>
                            <div class="text-center i h-10 w-16 md:h-12 md:w-28 bg-gradient-to-br from-sky-400 to-sky-600 rounded-full shadow-2xl cursor-pointer overflow-hidden transform hover:scale-x-110 hover:scale-y-105 transition duration-300 ease-out" @click="openModal">
                                <PencilSquareIcon class="w-8 md:w-10 text-white inline-block items-center h-full" />
                            </div>
                            <div class="text-center i h-10 w-16 md:h-12 md:w-28 bg-gradient-to-br from-red-400 to-red-600 rounded-full shadow-2xl cursor-pointer overflow-hidden transform hover:scale-x-110 hover:scale-y-105 transition duration-300 ease-out" @click="deleteContact(contact.id)">
                                <TrashIcon class="w-8 md:w-10 text-white inline-block items-center h-full" />
                            </div>
                        </div>
                    </div>
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
                    <h2 class="text-xl font-bold mb-4">Editar Contato</h2>
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
                            <p class="text-sm text-gray-500 mt-1">Tamanho máximo permitido: 20MB.</p>
                            <InputError class="mt-2":message="formData.errors.image"/>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Atualizar
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
.i::before {
  content: "";
  position: absolute;
  width: 0px;
  height: 0px;
  opacity: 20%;
  background: white;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  margin: auto;
}

.i:hover:before {
  animation: anim-in 0.9s forwards ease-out;
}

@keyframes anim-in {
  100% {
    opacity: 0%;
    border-radius: 0;
    width: 300px;
    height: 300px;
  }
  0% {
    width: 0px;
    height: 0px;
    border-radius: 100%;
    opacity: 20%;
  }
}
</style>