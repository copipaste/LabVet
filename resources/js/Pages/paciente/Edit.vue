<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'


const props = defineProps({
  mascota: Object,
  clientes: Array,
})

const form = useForm({
  nombre: props.mascota.nombre,
  especie: props.mascota.especie,
  raza: props.mascota.raza,
  edad: props.mascota.edad,
  sexo: props.mascota.sexo,
  cliente_id: props.mascota.cliente_id,
})

const submit = () => {
  form.put(route('mascotas.update', props.mascota.id))
}
</script>

<template>
  <AdminLayout>
    <Head title="Editar Mascota" />

    <div class="max-w-2xl mx-auto p-6 bg-base-100 shadow-md rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Editar Mascota</h1>

      <form @submit.prevent="submit">
        <!-- Nombre -->
        <div class="mb-4">
          <label for="nombre" class="label">Nombre</label>
          <input v-model="form.nombre" type="text" id="nombre" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.nombre">{{ form.errors.nombre }}</p>
        </div>

        <!-- Especie -->
        <div class="mb-4">
          <label for="especie" class="label">Especie</label>
          <input v-model="form.especie" type="text" id="especie" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.especie">{{ form.errors.especie }}</p>
        </div>

        <!-- Raza -->
        <div class="mb-4">
          <label for="raza" class="label">Raza</label>
          <input v-model="form.raza" type="text" id="raza" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.raza">{{ form.errors.raza }}</p>
        </div>

        <!-- Edad -->
        <div class="mb-4">
          <label for="edad" class="label">Edad</label>
          <input v-model="form.edad" type="number" id="edad" min="0" class="input input-bordered w-full input-themed" />
          <p class="text-error mt-1" v-if="form.errors.edad">{{ form.errors.edad }}</p>
        </div>

        <!-- Sexo -->
        <div class="mb-4">
          <label for="sexo" class="label">Sexo</label>
          <select v-model="form.sexo" id="sexo" class="select select-bordered w-full input-themed">
            <option disabled value="">Seleccione</option>
            <option value="Macho">Macho</option>
            <option value="Hembra">Hembra</option>
          </select>
          <p class="text-error mt-1" v-if="form.errors.sexo">{{ form.errors.sexo }}</p>
        </div>

        <!-- Cliente (Dueño) -->
        <div class="mb-4">
          <label for="cliente_id" class="label">Dueño</label>
          <select v-model="form.cliente_id" id="cliente_id" class="select select-bordered w-full input-themed">
            <option disabled value="">Seleccione un cliente</option>
            <option v-for="c in clientes" :key="c.id" :value="c.id">
              {{ c.nombre }}
            </option>
          </select>
          <p class="text-error mt-1" v-if="form.errors.cliente_id">{{ form.errors.cliente_id }}</p>
        </div>

        <!-- Botones -->
        <div class="flex justify-between">
          <Link :href="route('mascotas.index')" class="btn btn-outline">Cancelar</Link>
          <button class="btn btn-primary" :disabled="form.processing">Guardar cambios</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
