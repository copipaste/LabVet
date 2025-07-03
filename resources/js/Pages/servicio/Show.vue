<template>
  <AdminLayout>
    <Head title="Detalle del Servicio" />

    <div
      class="max-w-2xl mx-auto p-6 shadow-md rounded-box"
      :style="`background-color: var(--card-background); color: var(--text-color);`"
    >
      <h1 class="text-2xl font-bold mb-4">Detalle del Servicio</h1>

      <div class="space-y-4">
        <p><strong style="color: var(--text-color)">Nombre:</strong> {{ servicio.nombre }}</p>
        <p><strong style="color: var(--text-color)">Descripción:</strong> {{ servicio.descripcion }}</p>
        <p><strong style="color: var(--text-color)">Tipo de Muestra:</strong> {{ servicio.tipo_muestra }}</p>
        <p><strong style="color: var(--text-color)">Precio:</strong> Bs {{ !isNaN(servicio.precio) ? Number(servicio.precio).toFixed(2) : servicio.precio }}</p>
      </div>

      <div class="flex justify-end mt-6">
        <Link :href="route('servicios.index')" class="btn btn-outline">Volver</Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  servicio: Object
})
</script>
