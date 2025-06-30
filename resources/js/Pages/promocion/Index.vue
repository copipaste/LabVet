<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'

import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
  promociones: Object, // Laravel paginator
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar esta promoción?')) {
    router.delete(route('promociones.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Promociones" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Promociones</h1>
    <Link :href="route('p.pdf')" class="btn btn-secondary">
    Exportar PDF
    </Link>


      <Link :href="route('promociones.create')" class="btn btn-primary">
        Nueva Promoción
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Descuento (%)</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Activa</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="promo in promociones.data" :key="promo.id">
            <td>{{ promo.nombre }}</td>
            <td>{{ promo.descripcion }}</td>
            <td>{{ promo.descuento }}%</td>
            <td>{{ promo.fecha_inicio }}</td>
            <td>{{ promo.fecha_fin }}</td>
            <td>
              <span
                class="badge"
                :class="promo.activa ? 'badge-success' : 'badge-error'"
              >
                {{ promo.activa ? 'Sí' : 'No' }}
              </span>
            </td>
            <td class="flex gap-2">
              <Link
                :href="route('promociones.edit', promo.id)"
                class="btn btn-sm btn-info"
              >
                Editar
              </Link>
              <button
                @click="eliminar(promo.id)"
                class="btn btn-sm btn-error"
              >
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
            <!-- Información de registros -->
      <div v-if="promociones.total > 0" class="text-sm text-gray-500 mt-2">
        Mostrando de {{ promociones.from }} a {{ promociones.to }} de {{ promociones.total }} resultados
      </div>
        <!-- Componente de paginación -->
        <Pagination :links="promociones.links" />
    </div>
  </AdminLayout>
</template>
