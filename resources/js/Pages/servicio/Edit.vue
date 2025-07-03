<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  servicio: Object,
})

const form = useForm({
  nombre: props.servicio.nombre,
  descripcion: props.servicio.descripcion,
  tipo_muestra: props.servicio.tipo_muestra,
  precio: props.servicio.precio,
})

function submit() {
  form.put(route('servicios.update', props.servicio.id))
}
</script>

<template>
  <AdminLayout>
    <Head title="Editar Servicio" />

    <div class="max-w-2xl mx-auto p-6 bg-base-100 shadow-md rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Editar Servicio</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="nombre" class="label">Nombre</label>
          <input v-model="form.nombre" type="text" id="nombre" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.nombre">{{ form.errors.nombre }}</p>
        </div>

        <div>
          <label for="descripcion" class="label">Descripción</label>
          <textarea v-model="form.descripcion" id="descripcion" class="textarea textarea-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.descripcion">{{ form.errors.descripcion }}</p>
        </div>

        <div>
          <label for="tipo_muestra" class="label">Tipo de Muestra</label>
          <input v-model="form.tipo_muestra" type="text" id="tipo_muestra" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.tipo_muestra">{{ form.errors.tipo_muestra }}</p>
        </div>

        <div>
          <label for="precio" class="label">Precio</label>
          <input v-model="form.precio" type="number" step="0.01" id="precio" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.precio">{{ form.errors.precio }}</p>
        </div>

        <div class="flex justify-between mt-6">
          <Link :href="route('servicios.index')" class="btn btn-outline">Cancelar</Link>
          <button class="btn btn-primary" :disabled="form.processing">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

