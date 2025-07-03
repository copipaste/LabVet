<template>
  <div class="p-6 space-y-4">
    <h1 class="text-2xl font-bold">🌈 Probar Temas DaisyUI</h1>

    <div class="flex flex-wrap gap-2">
      <button v-for="t in themes" :key="t" class="btn btn-sm btn-outline" @click="cambiarTema(t)">
        {{ t }}
      </button>
    </div>

    <div class="mt-6 space-y-3">
      <div class="card bg-base-100 shadow p-4">
        <h2 class="text-lg font-semibold">Tarjeta de prueba</h2>
        <p>Color primario: <span class="text-primary">Primary</span></p>
        <p>Color secundario: <span class="text-secondary">Secondary</span></p>
      </div>
      <div class="alert alert-info">Mensaje informativo</div>
      <div class="alert alert-success">Éxito</div>
      <div class="alert alert-warning">Advertencia</div>
      <div class="alert alert-error">Error</div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const themes = ['light', 'dark', 'cyberpunk', 'kids', 'teens', 'adults']

function cambiarTema(nombre) {
  document.documentElement.setAttribute('data-theme', nombre)
  localStorage.setItem('tema', nombre)
}

onMounted(() => {
  const temaGuardado = localStorage.getItem('tema')
  if (temaGuardado) {
    cambiarTema(temaGuardado)
  }
})
</script>
