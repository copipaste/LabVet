<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

const props = defineProps({
    mascotas: Array,
    veterinarias: Array,
    servicios: Array,
    promociones: Array,
});

const form = useForm({
    mascota_id: "",
    veterinaria_id: "",
    observaciones: "",
    promocion_id: "",
    servicios_seleccionados: [],
    total: "",
});

// Resetear mascota al cambiar cliente
watch(
    () => form.cliente_id,
    () => {
        form.mascota_id = "";
    }
);

const cliente_id = ref("");

// Filtrar mascotas por cliente
const mascotasFiltradas = computed(() => {
    return props.mascotas.filter((m) => m.cliente_id === cliente_id.value);
});

// Subtotal
const subtotal = computed(() => {
    return props.servicios
        .filter((s) => form.servicios_seleccionados.includes(s.id))
        .reduce((acc, s) => acc + parseFloat(s.precio), 0);
});

// Descuento
const descuento = computed(() => {
    const promo = props.promociones.find((p) => p.id === form.promocion_id);
    return promo ? promo.descuento : 0;
});

// Total con descuento
const total = computed(() => {
    return subtotal.value - subtotal.value * (descuento.value / 100);
});

// Enviar datos válidos
const submit = () => {
    form.total = total.value.toFixed(2);
    form.post(route("ordenesanalisis.store"));
};
</script>

<template>
    <AdminLayout>
        <Head title="Registrar Orden de Análisis" />

        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Registrar nueva orden</h1>
            <Link
                :href="route('ordenesanalisis.index')"
                class="text-blue-500 hover:underline"
            >
                ← Volver al listado
            </Link>
        </div>

        <form
            @submit.prevent="submit"
            class="grid grid-cols-1 md:grid-cols-2 gap-4"
        >
            <div>
                <label class="label">Cliente</label>
                <select
                    v-model="cliente_id"
                    class="select select-bordered w-full"
                >
                    <option disabled value="">Selecciona un cliente</option>
                    <option
                        v-for="user in [
                            ...new Map(
                                props.mascotas.map((m) => [
                                    m.cliente_id,
                                    m.cliente,
                                ])
                            ).values(),
                        ]"
                        :key="user.id"
                        :value="user.id"
                    >
                        {{ user.nombre }}
                    </option>
                </select>
            </div>

            <!-- Mascota -->
            <div>
                <label class="label">Mascota</label>
                <select
                    v-model="form.mascota_id"
                    class="select select-bordered w-full"
                    :disabled="!cliente_id"
                >
                    <option disabled value="">Selecciona una mascota</option>
                    <option
                        v-for="m in mascotasFiltradas"
                        :key="m.id"
                        :value="m.id"
                    >
                        {{ m.nombre }}
                    </option>
                </select>
                <div
                    v-if="form.errors.mascota_id"
                    class="text-red-500 text-sm mt-1"
                >
                    {{ form.errors.mascota_id }}
                </div>
            </div>

            <div>
                <label class="label">Veterinaria</label>
                <select
                    v-model="form.veterinaria_id"
                    class="select select-bordered w-full"
                >
                    <option disabled value="">
                        Selecciona una veterinaria
                    </option>
                    <option v-for="v in veterinarias" :key="v.id" :value="v.id">
                        {{ v.nombre }}
                    </option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="label">Observaciones</label>
                <textarea
                    v-model="form.observaciones"
                    class="textarea textarea-bordered w-full"
                    rows="3"
                />
            </div>

            <div class="md:col-span-2">
                <label class="label">Servicios a realizar</label>
                <div class="grid md:grid-cols-2 gap-2">
                    <label
                        v-for="servicio in servicios"
                        :key="servicio.id"
                        class="flex items-center gap-2 p-2 rounded-md bg-base-200 hover:bg-base-300 transition"
                    >
                        <input
                            type="checkbox"
                            :value="servicio.id"
                            v-model="form.servicios_seleccionados"
                            class="checkbox checkbox-primary focus:outline-none focus:ring-0 hover:bg-transparent checked:hover:bg-primary"
                        />

                        {{ servicio.nombre }} ({{ servicio.precio }} Bs.)
                    </label>
                </div>
            </div>

            <div>
                <label class="label">Promoción Aplicada</label>
                <select
                    v-model="form.promocion_id"
                    class="select select-bordered w-full"
                >
                    <option value="">Sin promoción</option>
                    <option v-for="p in promociones" :key="p.id" :value="p.id">
                        {{ p.nombre }} (-{{ p.descuento }}%)
                    </option>
                </select>
            </div>

            <div>
                <label class="label">Total</label>
                <input
                    :value="total.toFixed(2) + ' Bs.'"
                    type="text"
                    class="input input-bordered w-full"
                    disabled
                />
            </div>

            <div class="md:col-span-2">
                <button
  type="submit"
  class="btn btn-primary w-full"
  :disabled="!form.mascota_id || !form.veterinaria_id || form.servicios_seleccionados.length === 0"
>
  Registrar Orden
</button>

            </div>
        </form>
    </AdminLayout>
</template>
