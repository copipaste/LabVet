<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  promocion: Object
})

const formatearFecha = (fecha) => {
  return new Date(fecha).toLocaleDateString('es-BO', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Detalle de Promoción" />

    <div
      class="max-w-2xl mx-auto p-6 shadow-md rounded-box"
      :style="`background-color: var(--card-background); color: var(--text-color);`"
    >
      <h1 class="text-2xl font-bold mb-4">Detalle de Promoción</h1>

      <div class="mb-4 space-y-2">
        <p><strong style="color: var(--text-color)">Nombre:</strong> {{ promocion.nombre }}</p>
        <p><strong style="color: var(--text-color)">Descripción:</strong> {{ promocion.descripcion }}</p>
        <p><strong style="color: var(--text-color)">Descuento:</strong> {{ promocion.descuento }}%</p>
        <p><strong style="color: var(--text-color)">Fecha de Inicio:</strong> {{ formatearFecha(promocion.fecha_inicio) }}</p>
        <p><strong style="color: var(--text-color)">Fecha de Fin:</strong> {{ formatearFecha(promocion.fecha_fin) }}</p>
        <p>
          <strong style="color: var(--text-color)">Activa:</strong>
          <span :class="promocion.activa ? 'text-green-600' : 'text-red-600'">
            {{ promocion.activa ? 'Sí' : 'No' }}
          </span>
        </p>
      </div>

      <div class="flex justify-end mt-4">
        <Link :href="route('promociones.index')" class="btn btn-outline">
          Volver
        </Link>
      </div>
    </div>
  </AdminLayout>
</template>
