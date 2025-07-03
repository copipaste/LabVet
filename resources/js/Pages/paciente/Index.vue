<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import RoleGate from '@/Components/RoleGate.vue'

defineProps({
  mascotas: Object, // datos paginados
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar esta mascota?')) {
    router.delete(route('mascotas.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Pacientes (Mascotas)" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Pacientes</h1>
      <RoleGate :roles="['administrador', 'bioquimico','secretaria']">
        <Link :href="route('mascotas.create')" class="btn btn-primary">
          Nueva Mascota
        </Link>
      </RoleGate>
    
    </div>

    <div class="overflow-x-auto">
      <table class="table w-full">
        <thead :style="`background-color: var(--thead-bg); color: var(--thead-text);`">
          <tr>
            <th>Nombre</th>
            <th>Especie</th>
            <th>Raza</th>
            <th>Edad</th>
            <th>Sexo</th>
            <th>Dueño</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="mascotas.data.length === 0">
            <td colspan="7" class="text-center">No hay mascotas registradas.</td>
          </tr>
          <tr v-for="mascota in mascotas.data" :key="mascota.id">
            <td>{{ mascota.nombre }}</td>
            <td>{{ mascota.especie }}</td>
            <td>{{ mascota.raza }}</td>
            <td>{{ mascota.edad }}</td>
            <td>{{ mascota.sexo }}</td>
            <td>{{ mascota.cliente?.nombre || 'Sin dueño' }}</td>
        <td class="flex gap-2">
          <Link :href="route('mascotas.show', mascota.id)" class="btn btn-sm btn-primary">
            Mostrar
          </Link>

          <RoleGate :roles="['administrador', 'bioquimico', 'secretaria']">
            <Link :href="route('mascotas.edit', mascota.id)" class="btn btn-sm btn-info">
              Editar
            </Link>
            <button @click="eliminar(mascota.id)" class="btn btn-sm btn-error">
              Eliminar
            </button>
          </RoleGate>
        </td>

          </tr>
        </tbody>
      </table>

      <div v-if="mascotas.total > 0" class="text-sm text-gray-500 mt-2">
        Mostrando de {{ mascotas.from }} a {{ mascotas.to }} de {{ mascotas.total }} resultados
      </div>

      <Pagination :links="mascotas.links" />
    </div>
  </AdminLayout>
</template>
