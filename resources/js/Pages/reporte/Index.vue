<template>
  <AdminLayout>
    <Head title="Generador de Reportes" />

    <div class="max-w-3xl mx-auto p-6 bg-base-100 shadow-md rounded-box input-themed">
      <h1 class="text-2xl font-bold mb-4">Generar Reporte PDF</h1>

      <!-- Selección de entidad -->
      <div class="mb-4">
        <label class="label">Selecciona el tipo de reporte</label>
        <select v-model="entidad" class="select select-bordered w-full">
          <option value="">-- Selecciona --</option>
          <option value="usuarios">Usuarios</option>
          <option value="mascotas">Mascotas</option>
          <option value="servicios">Servicios</option>
          <option value="promociones">Promociones</option>
          <option value="insumos">Insumos</option>
          <option value="pagos">Pagos</option>
        </select>
      </div>

      <!-- Selección de atributos -->
      <div v-if="entidad" class="mb-4">
        <label class="label">Selecciona las columnas</label>
        <div class="grid grid-cols-2 gap-2">
          <div v-for="campo in camposDisponibles[entidad]" :key="campo.value" class="flex items-center gap-2">
            <input type="checkbox" v-model="camposSeleccionados" :value="campo.value" />
            <span>{{ campo.label }}</span>
          </div>
        </div>
      </div>

      <!-- Botón -->
      <div class="mt-6 text-right">
        <button @click="generarPDF" class="btn btn-primary" :disabled="!entidad || camposSeleccionados.length === 0">
          Generar PDF
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const entidad = ref('')
const camposSeleccionados = ref([])

const camposDisponibles = {
  usuarios: [
    { label: 'Nombre', value: 'nombre' },
    { label: 'Email', value: 'email' },
    { label: 'Teléfono', value: 'telefono' },
    { label: 'Dirección', value: 'direccion' },
    { label: 'Rol', value: 'rol' }
  ],
  mascotas: [
    { label: 'Nombre', value: 'nombre' },
    { label: 'Especie', value: 'especie' },
    { label: 'Raza', value: 'raza' },
    { label: 'Edad', value: 'edad' },
    { label: 'Sexo', value: 'sexo' },
    { label: 'Dueño', value: 'cliente' }
  ],
  servicios: [
    { label: 'Nombre', value: 'nombre' },
    { label: 'Descripción', value: 'descripcion' },
    { label: 'Tipo de Muestra', value: 'tipo_muestra' },
    { label: 'Precio', value: 'precio' }
  ],
  promociones: [
    { label: 'Nombre', value: 'nombre' },
    { label: 'Descripción', value: 'descripcion' },
    { label: 'Descuento (%)', value: 'descuento' },
    { label: 'Fecha de Inicio', value: 'fecha_inicio' },
    { label: 'Fecha de Fin', value: 'fecha_fin' },
    { label: 'Activa', value: 'activa' }
  ],
  insumos: [
    { label: 'Nombre', value: 'nombre' },
    { label: 'Descripción', value: 'descripcion' },
    { label: 'Cantidad', value: 'cantidad_disponible' },
    { label: 'Unidad de Medida', value: 'unidad_medida' },
    { label: 'Fecha de Caducidad', value: 'fecha_caducidad' },
    { label: 'Tipo', value: 'tipo' },
    { label: 'Categoría', value: 'categoria' }
  ],
  pagos: [
    { label: 'Numero de Orden', value: 'orden_id' },
    { label: 'Fecha de Pago', value: 'fecha_pago' },
    { label: 'Monto', value: 'monto' },
    { label: 'Método de Pago', value: 'metodo_pago' },
    { label: 'Estado', value: 'estado' }
  ]
}

watch(entidad, () => {
  camposSeleccionados.value = []
})

const generarPDF = () => {
  const params = new URLSearchParams({
    entidad: entidad.value,
    columnas: camposSeleccionados.value.join(',')
  })

  // Abrir en nueva pestaña el PDF
//   window.open(route('reportes.generar', params.toString()), '_blank')
  window.open(route('reportes.generar', {
  entidad: entidad.value,
  columnas: camposSeleccionados.value
    }), '_blank')


}
</script>
