<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link, router } from '@inertiajs/vue3'

// ⬇️ ESTA ES LA LÍNEA QUE FALTABA
defineProps({
  pagos: Object,
  visitas: Object,
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar este pago?')) {
    router.delete(route('pagos.destroy', id))
  }
}
</script>

<template>
  <AdminLayout :visitas="visitas">

    <Head title="Pagos" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Pagos</h1>
      <Link :href="route('pagos.create')" class="btn btn-primary">
        Registrar Pago
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Fecha de Pago</th>
            <th>Monto (Bs.)</th>
            <th>Método</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="pagos.data.length === 0">
            <td colspan="8" class="text-center">No hay pagos registrados.</td>
          </tr>
          <tr v-for="pago in pagos.data" :key="pago.id">
            <td>{{ pago.id }}</td>
            <td>{{ pago.orden?.mascota?.cliente?.nombre || '—' }}</td>
            <td>{{ pago.orden?.mascota?.nombre || '—' }}</td>
            <td>{{ new Date(pago.fecha_pago).toLocaleDateString() }}</td>
            <td>Bs. {{ parseFloat(pago.monto).toFixed(2) }}</td>
            <td>{{ pago.metodo_pago }}</td>
            <td>
              <span
                class="badge"
                :class="pago.estado === 'completado' ? 'badge-success' : 'badge-error'"
              >
                {{ pago.estado }}
              </span>
            </td>
            <td class="flex gap-2">
              <Link
                :href="route('pagos.edit', pago.id)"
                class="btn btn-sm btn-info"
              >
                Editar
              </Link>
              <button
                @click="eliminar(pago.id)"
                class="btn btn-sm btn-error"
              >
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Información de registros -->
      <div v-if="pagos.total > 0" class="text-sm text-gray-500 mt-2">
        Mostrando de {{ pagos.from }} a {{ pagos.to }} de {{ pagos.total }} resultados
      </div>

      <!-- Componente de paginación -->
      <Pagination :links="pagos.links" />
    </div>
  </AdminLayout>
</template>
