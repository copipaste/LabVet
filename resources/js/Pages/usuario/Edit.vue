<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  usuario: Object,
  rolesDisponibles: Array
})

const form = useForm({
  nombre: props.usuario.nombre,
  email: props.usuario.email,
  rol: props.usuario.roles[0] ?? '',
})

function submit() {
  form.put(route('usuarios.update', props.usuario.id))
}
</script>

<template>
  <AdminLayout>
    <Head title="Editar Usuario" />

    <div class="max-w-2xl mx-auto p-6 bg-base-100 shadow rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Editar Usuario</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- Nombre -->
        <div>
          <label class="label" for="nombre">Nombre</label>
          <input
            v-model="form.nombre"
            id="nombre"
            type="text"
            class="input input-bordered w-full input-themed"
          />
          <InputError :message="form.errors.nombre" class="text-error mt-1" />
        </div>

        <!-- Email -->
        <div>
          <label class="label" for="email">Email</label>
          <input
            v-model="form.email"
            id="email"
            type="email"
            class="input input-bordered w-full input-themed"
          />
          <InputError :message="form.errors.email" class="text-error mt-1" />
        </div>

        <!-- Rol -->
        <div>
          <label class="label" for="rol">Rol</label>
          <select
            v-model="form.rol"
            id="rol"
            class="select select-bordered w-full input-themed"
          >
            <option disabled value="">Seleccionar rol</option>
            <option v-for="rol in rolesDisponibles" :key="rol" :value="rol">
              {{ rol.charAt(0).toUpperCase() + rol.slice(1) }}
            </option>
          </select>
          <InputError :message="form.errors.rol" class="text-error mt-1" />
        </div>

        <div class="flex justify-between mt-6">
          <Link :href="route('usuarios.index')" class="btn btn-outline">Cancelar</Link>
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

