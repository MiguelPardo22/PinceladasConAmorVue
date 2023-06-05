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
import { Result } from 'postcss';


const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    products: { type: Object }
});
const form = useForm({
    Reference:'', name:'', description:'', purchase_price:'', sale_price:'', photo:''
});

const formPage = useForm({});
const onPageClick = (event) => {
    formPage.get(route('products.index', { page: event }));
};
const deleteProduct = (id, reference, name, description, purchase_price, sale_price, photo) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Seguro deseas eliminar ' + name +' ?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, Seguro',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('products.destroy', id),{
                onSuccess: () => {ok('Producto Eliminada')}
            });
        }
    });
}
</script>

<template>
    <Head title="Productos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">

                    <PrimaryButton @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Agregar
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
                            <th class="px-2 py-2">Foto</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pro, i in products" :key="pro.id">
                            <td class="border border-gray-400 px-2 py-2">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.reference) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.name) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.description) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.purchase_price) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.sale_price) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ (pro.photo) }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton @click="openModal(2, id, reference, name, description, purchase_price, sale_price, photo)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="deleteProduct(pro.id, pro.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
