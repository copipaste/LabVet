<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

const props = defineProps({
    orden: Object,
    mascotas: Array,
    promociones: Array,
    servicios: Array,
    veterinarias: Array,
});

const cliente_id = ref(props.orden.mascota?.cliente_id || "");

const form = useForm({
    mascota_id: props.orden.mascota_id,
    veterinaria_id: props.orden.veterinaria_id,
    estado: props.orden.estado || "pendiente",
    observaciones: props.orden.observaciones || "",
    promocion_id: props.orden.promocion_id || "",
    servicios_seleccionados: props.orden.servicios?.map((s) => s.id) || [],
    total: props.orden.total || 0,
});

let clienteInicial = cliente_id.value;

watch(cliente_id, (nuevo, anterior) => {
  if (nuevo !== anterior && nuevo !== clienteInicial) {
    form.mascota_id = '';
  }
});


const mascotasFiltradas = computed(() =>
    props.mascotas.filter((m) => m.cliente_id === cliente_id.value)
);

const subtotal = computed(() =>
    props.servicios
        .filter((s) => form.servicios_seleccionados.includes(s.id))
        .reduce((acc, s) => acc + parseFloat(s.precio), 0)
);

const descuento = computed(() => {
    const promo = props.promociones.find((p) => p.id === form.promocion_id);
    return promo ? promo.descuento : 0;
});

const total = computed(
    () => subtotal.value - subtotal.value * (descuento.value / 100)
);

const submit = () => {
    form.total = total.value.toFixed(2);
    form.put(`/ordenesanalisis/${props.orden.id}`, {
        preserveScroll: true,
        onSuccess: () => alert("Orden actualizada correctamente."),
        onError: (errors) => console.error("Errores de validación", errors),
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Editar Orden" />
        <h1 class="text-3xl font-bold mb-4">
            Editar orden #{{ props.orden.id }}
        </h1>

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

            <div>
                <label class="label">Estado</label>
                <select
                    v-model="form.estado"
                    class="select select-bordered w-full"
                >
                    <option value="pendiente">Pendiente</option>
                    <option value="cancelado">Cancelado</option>
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
                        class="flex items-center gap-2 p-2 rounded-md bg-base-200 hover:bg-base-300"
                    >
                        <input
                            type="checkbox"
                            :value="servicio.id"
                            v-model="form.servicios_seleccionados"
                            class="checkbox checkbox-primary"
                        />
                        {{ servicio.nombre }} ({{ servicio.precio }} Bs.)
                    </label>
                </div>
            </div>

            <div>
                <label class="label">Promoción</label>
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
                <button type="submit" class="btn btn-primary w-full">
                    Actualizar Orden
                </button>
            </div>
        </form>
    </AdminLayout>
</template>
