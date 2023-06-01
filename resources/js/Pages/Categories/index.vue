<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { Result } from 'postcss';

const props = defineProps({
    categories:{type:Object}
});
const form = useForm({
    id:''
});
const deleteCategory = (id,name) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Seguro deseas eliminar '+name+' ?',
        icon: 'question', showCancelButton:true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes,delete',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel',
    }).then((result) => {
        if(result.isConfirmed) {
            form.delete(route('categories.destroy',id));
        }
    });
}
</script>

<template>
    <Head title="Categorias" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Categoria</th>
                            <th class="px-4 py-4">Estado</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cat, i in categories" :key="cat.id">
                        <td class="border border-gray-400 px-4 py-4">{{ (i+1) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (cat.name) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (cat.state) }}</td>
                        <td class="border border-gray-400 px-4 py-4">

                        </td>
                        <td class="border border-gray-400 px-4 py-4">
                            <DangerButton @click="deleteCategory(cat.id,cat.name,cat.state)">
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
