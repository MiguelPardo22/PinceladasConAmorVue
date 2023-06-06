<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';


const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    categories: { type: Object }
});
const form = useForm({
    name: '', state: '', description: ''
});

const formPage = useForm({});
const onPageClick = (event) => {
    formPage.get(route('categories.index', { page: event }));
};
const openModal = (op, name, state, description, category) => {

    modal.value = true;
    operation.value = op;
    id.value = category;

    if (op == 1) {

        title.value = 'Crear Categoria'

    } else {
        title.value = 'Editar Categoria'
        form.name = name;
        form.state = state;
        form.description = description;
    }

}

const closeModal = () => {

    modal.value = false;
    form.reset();

}

const save = () => {

    if (operation.value == 1) {
        form.post(route('categories.store'), {
            onSuccess: () => { ok('Categoria Creada') },
            onError: () => { error('Esta categoria ya existe')}
        })
    } else {
        form.put(route('categories.update', id.value), {
            onSuccess: () => { ok('Categoria Actualizada') }
        })
    }

}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'success' });
}
const error = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'warning' });
}

const deleteCategory = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Seguro deseas eliminar ' + name + '?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, Seguro',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('categories.destroy', id), {
                onSuccess: () => { ok('Categoria Eliminada') }
            });
        }
    });
}
</script>

<style>
        .PrimaryButton:hover .fa-solid{
            animation: flipAnimation 0.5s;
        }

        .WarningButton:hover .fa-solid{
            animation: flipAnimation 0.5s;
        }

        .DangerButton:hover .fa-solid{
            animation: flipAnimation 0.5s;
        }

        @keyframes flipAnimation {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2) rotateY(200deg);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

<template>
    <Head title="Categorias" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">

                    <PrimaryButton data-tooltip="Agregar" @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i>&nbsp Agregar
                    </PrimaryButton>

                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">Categoria</th>
                            <th class="px-2 py-2">Estado</th>
                            <th class="px-2 py-2">Descripcion</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cat, i in categories" :key="cat.id">
                            <td class="border border-gray-400 px-2 py-2">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (cat.name) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (cat.state) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (cat.description) }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton data-tooltip="Editar" @click="openModal(2, cat.name, cat.state, cat.description, cat.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton data-tooltip="Eliminar" @click="deleteCategory(cat.id, cat.name, cat.state)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table><br>
                <div class="bg-white grid v-screen place-items-center">
                    <VueTailwindPagination :current="categories.currentPage" :total="categories.total"
                        :per-page="categories.perPage" @page-changed="onPageClick($event)">
                    </VueTailwindPagination>
                </div>
            </div>

        </div>
        <Modal :show="modal" @close="closeModal"><br>
            <h2 class="p-3 text-lg font-medium text-hray-900"> {{ title }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="name" value="Nombre:"></InputLabel>
                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-3/4" placeholder="Nombre">
                </TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="state" value="Estado:"></InputLabel>
                <select id="state" v-model="form.state" type="text" class="mt-1 block w-3/4">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <InputError :message="form.errors.state" class="mt-1 block w-3/4"></InputError>
            </div>
            <div class="p-3 mt-6">
                <InputLabel for="description" value="Descripcion:"></InputLabel>
                <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-3/4"
                    placeholder="Estado">
                </TextInput>
                <InputError :message="form.errors.description" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>