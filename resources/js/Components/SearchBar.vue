<script setup>
const props = defineProps({
  modelValue: String, // para v-model
})

const emit = defineEmits(['update:modelValue', 'search'])

const actualizarBusqueda = (event) => {
  emit('update:modelValue', event.target.value)
}

const ejecutarBusqueda = () => {
  emit('search')
}
</script>

<template>
  <div class="flex items-center gap-2">
    <input
      :value="modelValue"
      @input="actualizarBusqueda"
      @keydown.enter="ejecutarBusqueda"
      type="text"
      placeholder="Buscar..."
      class="input input-bordered input-sm w-40 md:w-64"
      :style="{
        backgroundColor: 'var(--input-bg)',
        color: 'var(--input-text)',
        borderColor: 'var(--input-border)',
      }"
    />
    <button @click="realizarBusqueda" class="btn btn-sm btn-primary">Buscar</button>
  </div>
</template>
