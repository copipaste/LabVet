<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  usuario: Object
})
</script>

<template>
  <AdminLayout>
    <Head :title="`Usuario: ${usuario.nombre}`" />

    <div
      class="max-w-2xl mx-auto p-6 shadow-md rounded-box"
      :style="`background-color: var(--card-background); color: var(--text-color);`"
    >
      <h1 class="text-2xl font-bold mb-4">Detalle del Usuario</h1>

      <div class="mb-4">
        <strong style="color: var(--text-color)">Nombre:</strong>
        <span>{{ usuario.nombre }}</span>
      </div>

      <div class="mb-4">
        <strong style="color: var(--text-color)">Email:</strong>
        <span>{{ usuario.email }}</span>
      </div>

      <div class="mb-4">
        <strong style="color: var(--text-color)">Teléfono:</strong>
        <span>{{ usuario.telefono }}</span>
      </div>

      <div class="mb-4">
        <strong style="color: var(--text-color)">Dirección:</strong>
        <span>{{ usuario.direccion }}</span>
      </div>

      <div class="mb-4">
        <strong style="color: var(--text-color)">Rol:</strong>
        <span>{{ usuario.roles.length > 0 ? usuario.roles[0].name : 'Sin rol' }}</span>
      </div>

      <div class="flex justify-end mt-6">
        <Link :href="route('usuarios.index')" class="btn btn-outline">Volver</Link>
      </div>
    </div>
  </AdminLayout>
</template>
