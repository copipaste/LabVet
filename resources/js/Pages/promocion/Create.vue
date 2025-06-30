<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const form = useForm({
  nombre: '',
  descripcion: '',
  descuento: '',
  fecha_inicio: '',
  fecha_fin: '',
  activa: false,
})

function submit() {
  form.post(route('promociones.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Nueva Promoción" />

    <h1 class="text-3xl font-bold mb-6">Registrar Nueva Promoción</h1>

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
        <label for="descripcion" class="label">Descripción</label>
        <textarea
          id="descripcion"
          v-model="form.descripcion"
          class="textarea textarea-bordered w-full"
        ></textarea>
        <InputError :message="form.errors.descripcion" class="text-error mt-1" />
      </div>

      <div>
        <label for="descuento" class="label">Descuento (%)</label>
        <input
          id="descuento"
          v-model="form.descuento"
          type="number"
          min="0"
          max="100"
          class="input input-bordered w-full"
        />
        <InputError :message="form.errors.descuento" class="text-error mt-1" />
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <label for="fecha_inicio" class="label">Fecha Inicio</label>
          <input
            id="fecha_inicio"
            v-model="form.fecha_inicio"
            type="date"
            class="input input-bordered w-full"
          />
          <InputError :message="form.errors.fecha_inicio" class="text-error mt-1" />
        </div>

        <div class="flex-1">
          <label for="fecha_fin" class="label">Fecha Fin</label>
          <input
            id="fecha_fin"
            v-model="form.fecha_fin"
            type="date"
            class="input input-bordered w-full"
          />
          <InputError :message="form.errors.fecha_fin" class="text-error mt-1" />
        </div>
      </div>

      <div class="form-control">
        <label class="label cursor-pointer">
          <span class="label-text">¿Está activa?</span>
          <input
            type="checkbox"
            v-model="form.activa"
            class="toggle toggle-primary"
          />
        </label>
        <InputError :message="form.errors.activa" class="text-error mt-1" />
      </div>

      <div class="flex justify-end mt-6">
        <button
          type="submit"
          class="btn btn-primary"
          :disabled="form.processing"
        >
          Guardar
        </button>
      </div>
    </form>
  </AdminLayout>
</template>
