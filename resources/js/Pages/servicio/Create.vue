<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const form = useForm({
  nombre: '',
  descripcion: '',
  tipo_muestra: '',
  precio: '',
})

function submit() {
  form.post(route('servicios.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Nuevo Servicio" />

    <h1 class="text-3xl font-bold mb-6">Registrar Nuevo Servicio</h1>

    <form @submit.prevent="submit" class="space-y-4 max-w-xl">
      <!-- Nombre -->
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

      <!-- Descripción -->
      <div>
        <label for="descripcion" class="label">Descripción</label>
        <textarea
          id="descripcion"
          v-model="form.descripcion"
          class="textarea textarea-bordered w-full"
        ></textarea>
        <InputError :message="form.errors.descripcion" class="text-error mt-1" />
      </div>

      <!-- Tipo de muestra -->
      <div>
        <label for="tipo_muestra" class="label">Tipo de Muestra</label>
        <input
          id="tipo_muestra"
          v-model="form.tipo_muestra"
          type="text"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.tipo_muestra" class="text-error mt-1" />
      </div>

      <!-- Precio -->
      <div>
        <label for="precio" class="label">Precio</label>
        <input
          id="precio"
          v-model="form.precio"
          type="number"
          step="0.01"
          min="0"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.precio" class="text-error mt-1" />
      </div>

      <div class="flex justify-end mt-6">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          Guardar
        </button>
      </div>
    </form>
  </AdminLayout>
</template>
