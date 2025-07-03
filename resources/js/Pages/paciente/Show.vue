<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  mascota: Object
})
</script>

<template>
  <AdminLayout>
    <Head title="Detalle de Mascota" />

    <div
      class="max-w-2xl mx-auto p-6 shadow-md rounded-box input-themed"
      :style="`background-color: var(--card-background); color: var(--text-color);`"
    >
      <h1 class="text-2xl font-bold mb-6">Detalle de Mascota</h1>

      <div class="mb-4">
        <strong style="color: var(--text-color)">Nombre:</strong> {{ mascota.nombre }}
      </div>
      <div class="mb-4">
        <strong style="color: var(--text-color)">Especie:</strong> {{ mascota.especie }}
      </div>
      <div class="mb-4">
        <strong style="color: var(--text-color)">Raza:</strong> {{ mascota.raza }}
      </div>
      <div class="mb-4">
        <strong style="color: var(--text-color)">Edad:</strong> {{ mascota.edad }} años
      </div>
      <div class="mb-4">
        <strong style="color: var(--text-color)">Sexo:</strong> {{ mascota.sexo }}
      </div>
      <div class="mb-4" v-if="mascota.cliente">
        <strong style="color: var(--text-color)">Dueño:</strong> {{ mascota.cliente.nombre }}
      </div>

      <div class="mt-6 flex justify-end">
        <Link :href="route('mascotas.index')" class="btn btn-outline">Volver</Link>
      </div>
    </div>
  </AdminLayout>
</template>
