<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue'
import { Head, useForm, Link } from '@inertiajs/vue3' // ✅ Importación completa

const props = defineProps({
  pago: Object,
})

const form = useForm({
  metodo_pago: props.pago.metodo_pago,
})

const submit = () => {
  form.put(route('pagos.update', props.pago.id), {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Método de pago actualizado')
    },
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Editar Pago" />

    <h1 class="text-3xl font-bold mb-6">Editar Método de Pago</h1>

    <form @submit.prevent="submit" class="max-w-xl space-y-4">
      <!-- Mostrar orden asociada (solo lectura) -->
      <div>
        <label class="label">Orden de Análisis</label>
        <input
          type="text"
          class="input input-bordered w-full"
          :value="`Orden #${props.pago.orden.id} - Cliente: ${props.pago.orden.mascota?.cliente?.nombre} - Mascota: ${props.pago.orden.mascota?.nombre}`"
          disabled
        />
      </div>

      <!-- Monto (solo lectura) -->
      <div>
        <label class="label">Monto</label>
        <input
          type="text"
          class="input input-bordered w-full"
          :value="`Bs. ${Number(props.pago.monto).toFixed(2)}`"
          disabled
        />
      </div>

      <!-- Método de pago (único campo editable) -->
      <div>
        <label for="metodo_pago" class="label">Método de Pago</label>
        <select v-model="form.metodo_pago" id="metodo_pago" class="select select-bordered w-full">
          <option disabled value="">Selecciona un método</option>
          <option value="efectivo">Efectivo</option>
          <option value="transferencia">Transferencia</option>
        </select>
        <InputError :message="form.errors.metodo_pago" class="text-error mt-1" />
      </div>

      <!-- Botones -->
      <div class="flex justify-between mt-6">
        <Link :href="route('pagos.index')" class="btn btn-outline">
          Volver
        </Link>
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          Guardar Cambios
        </button>
      </div>
    </form>
  </AdminLayout>
</template>
