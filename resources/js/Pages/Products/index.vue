<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';
import InputFile from '@/Components/InputFile.vue';



const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    products: { type: Object },
    categories: { type: Object }
});
const form = useForm({
    reference: '', name: '', description: '', purchase_price: '', sale_price: '', id_cat_fk: '', photo: ''
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('products.index', { page: event }));
};

const openModal = (op, reference, name, description, purchase_price, sale_price, category, photo, product) => {

    modal.value = true;
    operation.value = op
    id.value = product

    if (op == 1) {

        title.value = 'Crear Producto';

    } else {

        title.value = 'Editar Producto';

        form.reference = reference
        form.name = name;
        form.description = description;
        form.purchase_price = purchase_price;
        form.sale_price = sale_price;
        form.id_cat_fk = category;
        form.photo = photo;


    }

}

const closeModal = () => {

    modal.value = false;
    form.reset();

}

const save = () => {

    if (operation.value == 1) {

        form.post(route('products.store'), {
            onSuccess: () => { ok('Producto Creado') }
        });

    } else {

        form.put(route('products.update', id.value), {
            onSuccess: () => { ok('Producto Actualizado') }
        });

    }
}

const ok = (msj) => {

    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'success', confirmButtonText: 'Listo' });

}

const deleteProduct = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Seguro deseas eliminar ' + name + ' ?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, Seguro',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('products.destroy', id), {
                onSuccess: () => { ok('Producto Eliminado') }
            });
        }
    });
}
</script>
<script>

export default {
  components: {
    InputFile
  },
  data() {
    return {
      photo: null
    };
  }
};

</script>
<style>
.PrimaryButton:hover .fa-solid {
    animation: flipAnimation 0.5s;
}

.WarningButton:hover .fa-solid {
    animation: flipAnimation 0.5s;
}

.DangerButton:hover .fa-solid {
    animation: flipAnimation 0.5s;
}

@keyframes flipAnimation {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.2) rotateY(180deg);
    }

    100% {
        transform: scale(1);
    }
}
</style>

<template>
    <Head title="Productos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h2>
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
                            <th class="px-2 py-2">Referencia</th>
                            <th class="px-2 py-2">Nombre</th>
                            <th class="px-2 py-2">Descripcion</th>
                            <th class="px-2 py-2">Precio Compra</th>
                            <th class="px-2 py-2">Precio Venta</th>
                            <th class="px-2 py-2">Categoria</th>
                            <th class="px-2 py-2">Foto</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pro, i in products.data" :key="pro.id">
                            <td class="border border-gray-400 px-2 py-2">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.reference) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.name) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.description) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.purchase_price) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.sale_price) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.category) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.photo) }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton data-tooltip="Editar"
                                    @click="openModal(2, pro.reference, pro.name, pro.description, pro.purchase_price, pro.sale_price, pro.id_cat_fk, pro.photo, pro.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton data-tooltip="Eliminar" @click="deleteProduct(pro.id, pro.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table><br>
                <div class="bg-white grid v-screen place-items-center">
                    <VueTailwindPagination :current="products.currentPage" :total="products.total"
                        :per-page="products.perPage">
                        @page-changed="$event => onPageClick($event)"
                    </VueTailwindPagination>
                </div>
            </div>
            <Modal :show="modal" @close="closeModal">
                <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
                <div class="p-3 mt-6">
                    <InputLabel for="reference" value="Referencia:"></InputLabel>
                    <TextInput id="reference" ref="nameInput" v-model="form.reference" type="number"
                        class="mt-1 block w-3/4" placeholder="Referencia"></TextInput>
                    <InputError :message="form.errors.reference"></InputError>
                </div>
                <div class="p-3">
                    <InputLabel for="name" value="Nombre:"></InputLabel>
                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                        placeholder="Nombre"></TextInput>
                    <InputError :message="form.errors.name"></InputError>
                </div>
                <div class="p-3">
                    <InputLabel for="description" value="Descripcion:"></InputLabel>
                    <TextInput id="description" ref="nameInput" v-model="form.description" type="text"
                        class="mt-1 block w-3/4" placeholder="Descripcion"></TextInput>
                    <InputError :message="form.errors.description"></InputError>
                </div>
                <div class="p-3">
                    <InputLabel for="purchase_price" value="Precio de Compra:"></InputLabel>
                    <TextInput id="purchase_price" ref="nameInput" v-model="form.purchase_price" type="number"
                        class="mt-1 block w-3/4" placeholder="Precio de Compra"></TextInput>
                    <InputError :message="form.errors.purchase_price"></InputError>
                </div>
                <div class="p-3">
                    <InputLabel for="purchase_price" value="Precio de Venta:"></InputLabel>
                    <TextInput id="purchase_price" ref="nameInput" v-model="form.sale_price" type="number"
                        class="mt-1 block w-3/4" placeholder="Precio de Compra"></TextInput>
                    <InputError :message="form.errors.sale_price"></InputError>
                </div>
                <div class="p-3">
                    <InputLabel for="id_cat_fk" value="Categoria:"></InputLabel>
                    <SelectInput id="id_cat_fk" :options="categories" v-model="form.id_cat_fk"
                        class="mt-1 block w-3/4"></SelectInput>
                    <InputError :message="form.errors.id_cat_fk"></InputError>
                </div>
                <div class="p-3">
                    <InputLabel for="photo" value="Foto:"></InputLabel>
                    <InputFile v-model="form.photo"></InputFile>
                    <InputError :message="form.errors.photo"></InputError>
                </div>
                <div class="p-3 mt-6">
                    <PrimaryButton data-tooltip="Guardar" :disabled="form.processing" @click="save">
                        <i class="fa-solid fa-save"></i>&nbsp Guardar
                    </PrimaryButton>
                    <DangerButton data-tooltip="Cancelar" class="ml-10" :disabled="form.processing" @click="closeModal">
                        <i class="fa-solid fa-ban"></i>&nbsp Cancelar
                    </DangerButton>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
