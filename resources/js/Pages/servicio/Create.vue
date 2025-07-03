<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
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

    <div class="max-w-2xl mx-auto p-6 bg-base-100 shadow-md rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Registrar Nuevo Servicio</h1>

      <form @submit.prevent="submit">
        <!-- Nombre -->
        <div class="mb-4">
          <label for="nombre" class="label">Nombre</label>
          <input
            id="nombre"
            v-model="form.nombre"
            type="text"
            class="input input-bordered w-full input-themed"
          />
          <InputError :message="form.errors.nombre" class="text-error mt-1" />
        </div>

        <!-- Descripción -->
        <div class="mb-4">
          <label for="descripcion" class="label">Descripción</label>
          <textarea
            id="descripcion"
            v-model="form.descripcion"
            class="textarea textarea-bordered w-full input-themed"
          ></textarea>
          <InputError :message="form.errors.descripcion" class="text-error mt-1" />
        </div>

        <!-- Tipo de muestra -->
        <div class="mb-4">
          <label for="tipo_muestra" class="label">Tipo de Muestra</label>
          <input
            id="tipo_muestra"
            v-model="form.tipo_muestra"
            type="text"
            class="input input-bordered w-full input-themed"
          />
          <InputError :message="form.errors.tipo_muestra" class="text-error mt-1" />
        </div>

        <!-- Precio -->
        <div class="mb-4">
          <label for="precio" class="label">Precio</label>
          <input
            id="precio"
            v-model="form.precio"
            type="number"
            step="0.01"
            min="0"
            class="input input-bordered w-full input-themed"
          />
          <InputError :message="form.errors.precio" class="text-error mt-1" />
        </div>

        <!-- Botones -->
        <div class="flex justify-between mt-6">
          <Link :href="route('servicios.index')" class="btn btn-outline">Cancelar</Link>
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            Guardar
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
