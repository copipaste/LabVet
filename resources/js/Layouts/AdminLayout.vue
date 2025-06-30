<template>
  <div class="drawer lg:drawer-open">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
      <!-- Navbar -->
      <div class="w-full navbar bg-base-100 shadow">
        <div class="flex-1 px-2 text-xl font-semibold">Panel Administrativo</div>

        <!-- Selector de Tema -->
        <div class="dropdown dropdown-end mr-2">
          <label tabindex="0" class="btn btn-ghost m-1">Tema</label>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">

                <li><a @click="cambiarTema('light')">Claro</a></li>
                <li><a @click="cambiarTema('dark')">Oscuro</a></li>
                <li><a @click="cambiarTemaPorHora()">Auto (Hora)</a></li>
                </ul>

        </div>

        <!-- Menú de Usuario -->
        <div class="flex-none">
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
              <div class="w-10 rounded-full bg-neutral text-white flex items-center justify-center">
           
              </div>
            </div>
            <ul class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li><a @click="logout">Cerrar sesión</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Page Content -->
      <div class="p-4">
        <slot />
      </div>
    </div>

    <!-- Sidebar -->
    <div class="drawer-side">
      <label for="admin-drawer" class="drawer-overlay"></label>
      <ul class="menu p-4 w-64 min-h-full bg-base-200 text-base-content">
        <li><Link href="/dashboard" class="font-semibold">Dashboard</Link></li>
        <li><Link href="/usuarios">Usuarios</Link></li>
        <li><Link href="/reportes">Reportes</Link></li>
        <li><Link href="/configuracion">Configuración</Link></li>
        <li><Link :href="route('promociones.index')">Promociones</Link></li>

      </ul>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const user = usePage().props.auth.user

function logout() {
  router.post('/logout')
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
</script>
