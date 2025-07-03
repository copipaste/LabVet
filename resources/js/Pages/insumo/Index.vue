<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
  insumos: Object // datos paginados o lista simple
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar este insumo?')) {
    router.delete(route('insumos.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Insumos" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Insumos</h1>
      <Link :href="route('insumos.create')" class="btn btn-primary">
        Nuevo Insumo
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Tipo</th>
            <th>Caducidad</th>
            <th>Categoría</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="insumos.length === 0">
            <td colspan="8" class="text-center">No hay insumos registrados.</td>
          </tr>
          <tr v-for="insumo in insumos" :key="insumo.id">
            <td>{{ insumo.nombre }}</td>
            <td>{{ insumo.descripcion }}</td>
            <td>{{ insumo.cantidad_disponible }}</td>
            <td>{{ insumo.unidad_medida }}</td>
            <td>{{ insumo.tipo }}</td>
            <td>{{ insumo.fecha_caducidad }}</td>
            <td>{{ insumo.categoria?.nombre ?? 'Sin categoría' }}</td>
            <td class="flex gap-2">
              <Link :href="route('insumos.edit', insumo.id)" class="btn btn-sm btn-info">Editar</Link>
              <button @click="eliminar(insumo.id)" class="btn btn-sm btn-error">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
