<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, useForm, Link, router } from '@inertiajs/vue3'

defineProps({
  categorias: Array
})

const form = useForm({
  nombre: '',
  descripcion: '',
  cantidad_disponible: 0,
  unidad_medida: '',
  fecha_caducidad: '',
  tipo: '',
  categoria_id: null
})

const submit = () => {
  form.post(route('insumos.store'))
}
</script>

<template>
  <AdminLayout>
    <Head title="Registrar Insumo" />

    <div class="mb-6">
      <h1 class="text-3xl font-bold mb-2">Registrar nuevo insumo</h1>
      <Link :href="route('insumos.index')" class="text-blue-500 hover:underline">
        ← Volver al listado
      </Link>
    </div>

    <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="label">Nombre</label>
        <input v-model="form.nombre" type="text" class="input input-bordered w-full" />
        <span v-if="form.errors.nombre" class="text-red-500 text-sm">{{ form.errors.nombre }}</span>
      </div>

      <div>
        <label class="label">Descripción</label>
        <input v-model="form.descripcion" type="text" class="input input-bordered w-full" />
      </div>

      <div>
        <label class="label">Cantidad Disponible</label>
        <input v-model="form.cantidad_disponible" type="number" class="input input-bordered w-full" />
        <span v-if="form.errors.cantidad_disponible" class="text-red-500 text-sm">{{ form.errors.cantidad_disponible }}</span>
      </div>

      <div>
        <label class="label">Unidad de Medida</label>
        <input v-model="form.unidad_medida" type="text" class="input input-bordered w-full" />
      </div>

      <div>
        <label class="label">Fecha de Caducidad</label>
        <input v-model="form.fecha_caducidad" type="date" class="input input-bordered w-full" />
        <span v-if="form.errors.fecha_caducidad" class="text-red-500 text-sm">{{ form.errors.fecha_caducidad }}</span>
      </div>

      <div>
        <label class="label">Tipo</label>
        <input v-model="form.tipo" type="text" class="input input-bordered w-full" />
      </div>

      <div>
        <label class="label">Categoría</label>
        <select v-model="form.categoria_id" class="select select-bordered w-full">
          <option disabled value="">Selecciona una categoría</option>
          <option v-for="cat in categorias" :key="cat.id" :value="cat.id">
            {{ cat.nombre }}
          </option>
        </select>
        <span v-if="form.errors.categoria_id" class="text-red-500 text-sm">{{ form.errors.categoria_id }}</span>
      </div>

      <div class="md:col-span-2">
        <button type="submit" class="btn btn-primary w-full">Guardar</button>
      </div>
    </form>
  </AdminLayout>
</template>
