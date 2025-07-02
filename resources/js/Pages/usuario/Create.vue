<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  roles: Array, // viene del controlador para poblar el select
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

    <h1 class="text-3xl font-bold mb-6">Registrar Nuevo Usuario</h1>

    <form @submit.prevent="submit" class="space-y-4 max-w-xl">

      <div>
        <label class="label" for="nombre">Nombre</label>
        <input v-model="form.nombre" id="nombre" type="text" class="input input-bordered w-full" />
        <InputError :message="form.errors.nombre" />
      </div>

      <div>
        <label class="label" for="email">Email</label>
        <input v-model="form.email" id="email" type="email" class="input input-bordered w-full" />
        <InputError :message="form.errors.email" />
      </div>

      <div>
        <label class="label" for="telefono">Teléfono</label>
        <input v-model="form.telefono" id="telefono" type="text" class="input input-bordered w-full" />
        <InputError :message="form.errors.telefono" />
      </div>

      <div>
        <label class="label" for="direccion">Dirección</label>
        <input v-model="form.direccion" id="direccion" type="text" class="input input-bordered w-full" />
        <InputError :message="form.errors.direccion" />
      </div>

      <div>
        <label class="label" for="password">Contraseña</label>
        <input v-model="form.password" id="password" type="password" class="input input-bordered w-full" />
        <InputError :message="form.errors.password" />
      </div>

      <div>
        <label class="label" for="password_confirmation">Confirmar Contraseña</label>
        <input v-model="form.password_confirmation" id="password_confirmation" type="password" class="input input-bordered w-full" />
        <InputError :message="form.errors.password_confirmation" />
      </div>

      <div>
        <label class="label" for="rol">Rol</label>
        <select v-model="form.rol" id="rol" class="select select-bordered w-full">
          <option disabled value="">Seleccione un rol</option>
          <option v-for="r in roles" :key="r" :value="r">{{ r }}</option>
        </select>
        <InputError :message="form.errors.rol" />
      </div>

      <div class="flex justify-end">
        <Link :href="route('usuarios.index')" class="btn btn-outline mr-2">Cancelar</Link>
        <button class="btn btn-primary" :disabled="form.processing">Guardar</button>
      </div>

    </form>
  </AdminLayout>
</template>
