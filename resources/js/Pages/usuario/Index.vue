<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
  usuarios: Object // Paginado desde Laravel
})

function eliminar(id) {
  if (confirm('¿Estás seguro de eliminar este usuario?')) {
    router.delete(route('usuarios.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Gestión de Usuarios" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">Gestión de Usuarios</h1>
      <Link :href="route('usuarios.create')" class="btn btn-primary">
        Nuevo Usuario
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table w-full">
       <thead :style="`background-color: var(--thead-bg); color: var(--thead-text);`">
          <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="usuarios.data.length === 0">
            <td colspan="4" class="text-center">No hay usuarios registrados.</td>
          </tr>
          <tr v-for="user in usuarios.data" :key="user.id">
            <td>{{ user.nombre }}</td>
            <td>{{ user.email }}</td>
            <td>
              <span class="badge badge-info capitalize">
                {{ user.roles[0] || 'Sin rol' }}
              </span>
            </td>
            <td class="flex gap-2">
              <Link :href="route('usuarios.show', user.id)" class="btn btn-sm btn-primary">
                Mostrar
              </Link>
              <Link :href="route('usuarios.edit', user.id)" class="btn btn-sm btn-info">
                Editar
              </Link>
              <button @click="eliminar(user.id)" class="btn btn-sm btn-error">
                Eliminar
              </button>
            </td>

          </tr>
        </tbody>
      </table>

      <div v-if="usuarios.total > 0" class="text-sm text-gray-500 mt-2">
        Mostrando de {{ usuarios.from }} a {{ usuarios.to }} de {{ usuarios.total }} resultados
      </div>

      <Pagination :links="usuarios.links" />
    </div>
  </AdminLayout>
</template>
