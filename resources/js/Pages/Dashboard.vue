<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import { Bar, Pie } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title, Tooltip, Legend,
  BarElement, CategoryScale, LinearScale,
  ArcElement
} from 'chart.js'

ChartJS.register(
  Title, Tooltip, Legend,
  BarElement, CategoryScale, LinearScale,
  ArcElement
)

const props = defineProps({
  totalMascotas: Number,
  serviciosMasUsados: Array,
  ordenesPorMes: Array,
  usuariosPorRol: Object,
  pagosPorMes: Array,
})

// Prepara datos para gráficos
const chartServicios = {
  labels: props.serviciosMasUsados.map(s => s.nombre),
  datasets: [{
    label: 'Servicios solicitados',
    data: props.serviciosMasUsados.map(s => s.total),
    backgroundColor: '#34d399',
  }],
}

const chartOrdenes = {
  labels: props.ordenesPorMes.map(o => o.mes),
  datasets: [{
    label: 'Órdenes',
    data: props.ordenesPorMes.map(o => o.total),
    backgroundColor: '#60a5fa',
  }],
}

const chartRoles = {
  labels: Object.keys(props.usuariosPorRol),
  datasets: [{
    label: 'Usuarios por Rol',
    data: Object.values(props.usuariosPorRol),
    backgroundColor: ['#a78bfa', '#f472b6', '#facc15', '#34d399'],
  }],
}

const chartPagos = {
  labels: props.pagosPorMes.map(p => p.mes),
  datasets: [{
    label: 'Pagos (Bs)',
    data: props.pagosPorMes.map(p => p.total),
    backgroundColor: '#f97316',
  }],
}
</script>

<template>
  <AdminLayout>
    <Head title="Dashboard" />

    <div class="container mx-auto px-4">
      <div class="grid gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">

        <!-- Total de Mascotas -->
        <div class="card bg-base-100 shadow p-4">
          <h2 class="font-bold text-lg mb-2">Total de Mascotas</h2>
          <p class="text-3xl">{{ totalMascotas }}</p>
        </div>



        <!-- Servicios más solicitados -->
        <div class="card bg-base-100 shadow p-4 ">
          <h2 class="font-bold text-lg mb-4">Servicios más solicitados</h2>
          <div class="w-full h-64">
            <Bar :data="chartServicios" />
          </div>
        </div>

        <!-- Órdenes por Mes -->
        <div class="card bg-base-100 shadow p-4">
          <h2 class="font-bold text-lg mb-4">Órdenes por Mes</h2>
          <div class="w-full h-56">
            <Bar :data="chartOrdenes" />
          </div>
        </div>

        <!-- Pagos Mensuales -->
        <div class="card bg-base-100 shadow p-4">
          <h2 class="font-bold text-lg mb-4">Pagos Mensuales</h2>
          <div class="w-full h-56">
            <Bar :data="chartPagos" />
          </div>
        </div>

                <!-- Usuarios por Rol -->
        <div class="card bg-base-100 shadow p-4">
          <h2 class="font-bold text-lg mb-4">Usuarios por Rol</h2>
          <div class="w-full h-64">
            <Pie :data="chartRoles" />
          </div>
        </div>

      </div>
    </div>
  </AdminLayout>
</template>


