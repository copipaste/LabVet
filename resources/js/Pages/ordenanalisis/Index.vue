<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
  ordenes: Array
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar esta orden de análisis?')) {
    router.delete(route('ordenesanalisis.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Órdenes de Análisis" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Órdenes de Análisis</h1>
      <Link :href="route('ordenesanalisis.create')" class="btn btn-primary">
        Nueva Orden
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Promoción</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="ordenes.length === 0">
            <td colspan="8" class="text-center">No hay órdenes registradas.</td>
          </tr>
          <tr v-for="orden in ordenes" :key="orden.id">
            <td>{{ orden.id }}</td>
            <td>{{ orden.mascota?.cliente?.nombre || '—' }}</td>
            <td>{{ orden.mascota?.nombre || '—' }}</td>
            <td>{{ orden.fecha_solicitud }}</td>
            <td>
              <span
                class="badge"
                :class="{
                  'badge-warning': orden.estado === 'pendiente',
                  'badge-info': orden.estado === 'pagado',
                  'badge-success': orden.estado === 'atendido',
                  'badge-error': orden.estado === 'cancelado',
                  'badge-neutral': !orden.estado
                }"
              >
                {{ orden.estado ? orden.estado.charAt(0).toUpperCase() + orden.estado.slice(1) : 'Sin estado' }}
              </span>
            </td>
            <td>{{ orden.promocion?.nombre || '—' }}</td>
            <td>Bs. {{ parseFloat(orden.total).toFixed(2) }}</td>
            <td class="flex gap-2">
              <Link :href="route('ordenesanalisis.edit', orden.id)" class="btn btn-sm btn-info">
                Editar
              </Link>
              <button @click="eliminar(orden.id)" class="btn btn-sm btn-error">
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
