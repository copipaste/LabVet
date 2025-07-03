<template>
  <div class="drawer lg:drawer-open" :style="`background-color: var(--bg-color); color: var(--text-color);`">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
      <!-- Navbar -->
      <div class="w-full navbar shadow" :style="`background-color: var(--header-color);`">
        <div class="flex-1 px-2 text-xl font-semibold">Panel Administrativo</div>
        
        <!-- 🔍 Barra de búsqueda global -->
        <SearchBar
          v-model="busqueda"
          @search="realizarBusqueda"
        />



        

      <!-- Selector de Tema -->
      <div class="dropdown dropdown-end mr-2">
        <label tabindex="0" class="btn btn-ghost m-1">Tema</label>
        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow rounded-box w-52 dropdown-themed">
          <li><a @click="cambiarTema('light')">Claro</a></li>
          <li><a @click="cambiarTema('dark')">Oscuro</a></li>
          <li><a @click="cambiarTema('kids')">Niños</a></li>
          <li><a @click="cambiarTema('teens')">Jóvenes</a></li>
          <li><a @click="cambiarTema('adults')">Adultos</a></li>
          <li><a @click="cambiarTemaPorHora()">Auto (Hora)</a></li>
        </ul>
      </div>

      <!-- Selector de Tamaño de Letra -->
    <div class="dropdown dropdown-end mr-2">
      <label tabindex="0" class="btn btn-ghost m-1">Texto</label>
      <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow rounded-box w-52 dropdown-themed">
        <li><a @click="cambiarTamanoLetra('xsmall')">Extra Pequeño</a></li>
        <li><a @click="cambiarTamanoLetra('small')">Pequeño</a></li>
        <li><a @click="cambiarTamanoLetra('medium')">Mediano</a></li>
        <li><a @click="cambiarTamanoLetra('large')">Grande</a></li>
        <li><a @click="cambiarTamanoLetra('xlarge')">Extra Grande</a></li>
      </ul>
    </div>


        <!-- Menú de Usuario -->
        <div class="flex-none">
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
              <div class="w-10 rounded-full bg-neutral text-white flex items-center justify-center">
                <!-- avatar opcional -->
              </div>
            </div>
            <ul class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li><button @click="logout">Cerrar sesión</button></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Page Content -->
      <div class="p-4 rounded shadow" :style="`background-color: var(--card-background);`">
        <slot />
      </div>
    </div>

<!-- Sidebar -->
<div class="drawer-side" :style="`background-color: var(--drawer-background);`">
  <label for="admin-drawer" class="drawer-overlay"></label>
  <div class="w-64 min-h-full p-4 flex flex-col items-center">
    
    <!-- Logo -->
    <img 
      src="https://i.ibb.co/DH5N1NHd/Whats-App-Image-2025-07-02-at-22-32-53-d01168b1.jpg" 
      alt="Logo" 
      class="w-46 h-auto mb-6 rounded shadow"
    />

    <!-- Menú -->
    <ul class="menu w-full text-base-content" :style="`color: var(--drawer-text);`">

      <RoleGate :roles="['administrador']">
        <li><Link :href="route('reportes.dashboard')" class="font-semibold">Dashboard</Link></li> 
        <li><Link :href="route('promociones.index')">Promociones</Link></li>
        <li><Link :href="route('servicios.index')">Servicios</Link></li>
        <li><Link :href="route('usuarios.index')">Usuarios</Link></li>
        <li><Link :href="route('mascotas.index')">Mascotas</Link></li>
        <li><Link :href="route('reportes.index')">Reportes</Link></li>
      </RoleGate>

      <RoleGate :roles="['secretaria']">
        <li><Link :href="route('servicios.index')">Servicios</Link></li>
        <li><Link :href="route('mascotas.index')">Mascotas</Link></li>
      </RoleGate>

      <RoleGate :roles="['bioquimico']">
        <li><Link :href="route('mascotas.index')">Mascotas</Link></li>
      </RoleGate>

      <RoleGate :roles="['cliente']">
        <li><Link :href="route('mascotas.index')">Mis Mascotas</Link></li>
      </RoleGate>

    </ul>
  </div>
</div>

  </div>
</template>

<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import RoleGate from '@/Components/RoleGate.vue'
import SearchBar from '@/Components/SearchBar.vue'

const user = usePage().props.auth.user
const busqueda = ref('')

function logout() {
  router.post(route('logout'), {}, {
    preserveScroll: true,
    onSuccess: () => router.visit(route('login')),
    onError: (error) => console.error('Error al cerrar sesión:', error)
  })
}

function cambiarTema(nombre) {
  document.documentElement.setAttribute('data-theme', nombre)
  localStorage.setItem('tema', nombre)
}

function cambiarTemaPorHora() {
  const hora = new Date().getHours()
  const tema = hora >= 7 && hora <= 18 ? 'light' : 'dark'
  cambiarTema(tema)
}

onMounted(() => {
  const temaGuardado = localStorage.getItem('tema')
  if (temaGuardado) {
    cambiarTema(temaGuardado)
  } else {
    cambiarTemaPorHora()
  }
})

const cambiarTamanoLetra = (tamano) => {
  document.documentElement.setAttribute('data-font-size', tamano)
  localStorage.setItem('font-size', tamano)
}

// Aplicar desde localStorage al iniciar
onMounted(() => {
  const stored = localStorage.getItem('font-size') || 'medium'
  cambiarTamanoLetra(stored)
})

const realizarBusqueda = () => {

}


</script>
