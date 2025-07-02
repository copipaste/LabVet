<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
  servicios: Object, // Laravel paginator
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar este servicio?')) {
    router.delete(route('servicios.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Gestión de Servicios" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Servicios</h1>

      <Link :href="route('servicios.create')" class="btn btn-primary">
        Nuevo Servicio
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Tipo de Muestra</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="servicios.data.length === 0">
            <td colspan="5" class="text-center">No hay servicios registrados.</td>
          </tr>
          <tr v-for="servicio in servicios.data" :key="servicio.id">
            <td>{{ servicio.nombre }}</td>
            <td>{{ servicio.descripcion }}</td>
            <td>{{ servicio.tipo_muestra }}</td>
           <td>{{ Number(servicio.precio).toFixed(2) }}</td>
            <td class="flex gap-2">
              <Link :href="route('servicios.edit', servicio.id)" class="btn btn-sm btn-info">
                Editar
              </Link>
              <button @click="eliminar(servicio.id)" class="btn btn-sm btn-error">
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="servicios.total > 0" class="text-sm text-gray-500 mt-2">
        Mostrando de {{ servicios.from }} a {{ servicios.to }} de {{ servicios.total }} resultados
      </div>

      <Pagination :links="servicios.links" />
    </div>
  </AdminLayout>
</template>
