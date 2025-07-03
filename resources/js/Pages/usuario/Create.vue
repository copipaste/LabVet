<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  roles: Array,
})

const form = useForm({
  nombre: '',
  email: '',
  telefono: '',
  direccion: '',
  password: '',
  password_confirmation: '',
  rol: '',
})

function submit() {
  form.post(route('usuarios.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Nuevo Usuario" />

    <div class="max-w-2xl mx-auto p-6 bg-base-100 shadow-md rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Registrar Nuevo Usuario</h1>

      <form @submit.prevent="submit">
        <!-- Nombre -->
        <div class="mb-4">
          <label class="label" for="nombre">Nombre</label>
          <input v-model="form.nombre" id="nombre" type="text" class="input input-bordered w-full input-themed" />
          <InputError :message="form.errors.nombre" />
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label class="label" for="email">Email</label>
          <input v-model="form.email" id="email" type="email" class="input input-bordered w-full input-themed" />
          <InputError :message="form.errors.email" />
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
          <label class="label" for="telefono">Teléfono</label>
          <input v-model="form.telefono" id="telefono" type="text" class="input input-bordered w-full input-themed" />
          <InputError :message="form.errors.telefono" />
        </div>

        <!-- Dirección -->
        <div class="mb-4">
          <label class="label" for="direccion">Dirección</label>
          <input v-model="form.direccion" id="direccion" type="text" class="input input-bordered w-full input-themed" />
          <InputError :message="form.errors.direccion" />
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
          <label class="label" for="password">Contraseña</label>
          <input v-model="form.password" id="password" type="password" class="input input-bordered w-full input-themed" />
          <InputError :message="form.errors.password" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
          <label class="label" for="password_confirmation">Confirmar Contraseña</label>
          <input v-model="form.password_confirmation" id="password_confirmation" type="password" class="input input-bordered w-full input-themed" />
          <InputError :message="form.errors.password_confirmation" />
        </div>

        <!-- Rol -->
        <div class="mb-4">
          <label class="label" for="rol">Rol</label>
          <select v-model="form.rol" id="rol" class="select select-bordered w-full input-themed">
            <option disabled value="">Seleccione un rol</option>
            <option v-for="r in roles" :key="r" :value="r">{{ r }}</option>
          </select>
          <InputError :message="form.errors.rol" />
        </div>

        <!-- Botones -->
        <div class="flex justify-between mt-6">
          <Link :href="route('usuarios.index')" class="btn btn-outline">Cancelar</Link>
          <button class="btn btn-primary" :disabled="form.processing">Guardar</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
