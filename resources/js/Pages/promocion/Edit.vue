<template>
  <AdminLayout>
    <Head title="Editar Promoción" />

    <div class="max-w-2xl mx-auto p-6 bg-base-100 shadow-md rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Editar Promoción</h1>

      <form @submit.prevent="submit">
        <!-- Nombre -->
        <div class="mb-4">
          <label for="nombre" class="label">Nombre</label>
          <input
            v-model="form.nombre"
            type="text"
            id="nombre"
            class="input input-bordered w-full input-themed"
          />
          <p class="text-error mt-1" v-if="form.errors.nombre">{{ form.errors.nombre }}</p>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
          <label for="descripcion" class="label">Descripción</label>
          <textarea
            v-model="form.descripcion"
            id="descripcion"
            class="textarea textarea-bordered w-full input-themed"
          ></textarea>
          <p class="text-error mt-1" v-if="form.errors.descripcion">{{ form.errors.descripcion }}</p>
        </div>

        <!-- Descuento -->
        <div class="mb-4">
          <label for="descuento" class="label">Descuento (%)</label>
          <input
            v-model="form.descuento"
            type="number"
            id="descuento"
            min="0"
            max="100"
            class="input input-bordered w-full input-themed"
          />
          <p class="text-error mt-1" v-if="form.errors.descuento">{{ form.errors.descuento }}</p>
        </div>

        <!-- Fecha Inicio -->
        <div class="mb-4">
          <label for="fecha_inicio" class="label">Fecha de Inicio</label>
          <input
            v-model="form.fecha_inicio"
            type="date"
            id="fecha_inicio"
            class="input input-bordered w-full input-themed"
          />
          <p class="text-error mt-1" v-if="form.errors.fecha_inicio">{{ form.errors.fecha_inicio }}</p>
        </div>

        <!-- Fecha Fin -->
        <div class="mb-4">
          <label for="fecha_fin" class="label">Fecha de Fin</label>
          <input
            v-model="form.fecha_fin"
            type="date"
            id="fecha_fin"
            class="input input-bordered w-full input-themed"
          />
          <p class="text-error mt-1" v-if="form.errors.fecha_fin">{{ form.errors.fecha_fin }}</p>
        </div>

        <!-- Toggle DaisyUI -->
        <div class="form-control mb-6">
          <label class="label cursor-pointer justify-between">
            <span class="label-text">¿Está activa?</span>
            <input
              type="checkbox"
              v-model="form.activa"
              class="toggle toggle-primary"
            />
          </label>
          <InputError :message="form.errors.activa" class="text-error mt-1" />
        </div>

        <!-- Botones -->
        <div class="flex justify-between">
          <Link :href="route('promociones.index')" class="btn btn-outline">Cancelar</Link>
          <button class="btn btn-primary" :disabled="form.processing">Guardar cambios</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>


<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  promocion: Object,
})

const form = useForm({
  nombre: props.promocion.nombre,
  descripcion: props.promocion.descripcion,
  descuento: props.promocion.descuento,
  fecha_inicio: props.promocion.fecha_inicio,
  fecha_fin: props.promocion.fecha_fin,
  activa: props.promocion.activa,
})

const submit = () => {
  form.put(route('promociones.update', props.promocion.id))
}
</script>
