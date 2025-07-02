<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    insumos: Array,
});

const eliminar = (id) => {
    if (confirm('¿Estás seguro de eliminar este insumo?')) {
        router.delete(`/insumos/${id}`);
    }
};
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Gestión de Insumos</h1>

        <div class="mb-4">
            <a
                href="/insumos/create"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
            >
                + Nuevo Insumo
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 shadow">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Cantidad</th>
                        <th class="py-2 px-4 border-b">Unidad</th>
                        <th class="py-2 px-4 border-b">Tipo</th>
                        <th class="py-2 px-4 border-b">Categoría</th>
                        <th class="py-2 px-4 border-b text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="insumo in insumos" :key="insumo.id" class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ insumo.id }}</td>
                        <td class="py-2 px-4 border-b">{{ insumo.nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ insumo.cantidad_disponible }}</td>
                        <td class="py-2 px-4 border-b">{{ insumo.unidad_medida }}</td>
                        <td class="py-2 px-4 border-b">{{ insumo.tipo }}</td>
                        <td class="py-2 px-4 border-b">{{ insumo.categoria?.nombre ?? '-' }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <a :href="`/insumos/${insumo.id}/edit`" class="text-blue-500 hover:underline mr-3">Editar</a>
                            <button @click="eliminar(insumo.id)" class="text-red-500 hover:underline">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
