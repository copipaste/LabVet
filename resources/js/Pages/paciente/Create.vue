<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  clientes: Array, // lista de usuarios/dueños
})

const form = useForm({
  nombre: '',
  especie: '',
  raza: '',
  edad: '',
  sexo: '',
  cliente_id: '',
})

function submit() {
  form.post(route('mascotas.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Registrar Mascota" />

    <h1 class="text-3xl font-bold mb-6">Registrar Nueva Mascota</h1>

    <form @submit.prevent="submit" class="space-y-4 max-w-xl">
      <div>
        <label for="nombre" class="label">Nombre</label>
        <input
          id="nombre"
          v-model="form.nombre"
          type="text"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.nombre" class="text-error mt-1" />
      </div>

      <div>
        <label for="especie" class="label">Especie</label>
        <input
          id="especie"
          v-model="form.especie"
          type="text"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.especie" class="text-error mt-1" />
      </div>

      <div>
        <label for="raza" class="label">Raza</label>
        <input
          id="raza"
          v-model="form.raza"
          type="text"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.raza" class="text-error mt-1" />
      </div>

      <div>
        <label for="edad" class="label">Edad</label>
        <input
          id="edad"
          v-model="form.edad"
          type="number"
          min="0"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.edad" class="text-error mt-1" />
      </div>

      <div>
        <label for="sexo" class="label">Sexo</label>
        <select
          id="sexo"
          v-model="form.sexo"
          class="select select-bordered w-full"
        >
          <option disabled value="">Seleccione</option>
          <option value="Macho">Macho</option>
          <option value="Hembra">Hembra</option>
        </select>
        <InputError :message="form.errors.sexo" class="text-error mt-1" />
      </div>

      <div>
        <label for="cliente_id" class="label">Dueño</label>
        <select
          id="cliente_id"
          v-model="form.cliente_id"
          class="select select-bordered w-full"
        >
          <option disabled value="">Seleccione un cliente</option>
          <option v-for="c in clientes" :key="c.id" :value="c.id">
            {{ c.nombre }}
          </option>
        </select>
        <InputError :message="form.errors.cliente_id" class="text-error mt-1" />
      </div>

      <div class="flex justify-end mt-6">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          Guardar
        </button>
      </div>
    </form>
  </AdminLayout>
</template>
