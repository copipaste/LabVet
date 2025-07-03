<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

const props = defineProps({
    ordenes: Array,

    visitas: Object,
});

const ordenSeleccionada = ref("");
const ordenData = computed(() =>
    props.ordenes.find((o) => o.id === ordenSeleccionada.value)
);

const form = useForm({
    orden_id: "",
    metodo_pago: "",
});

watch(ordenSeleccionada, (val) => {
    form.orden_id = val;
});
</script>

<template>
    <AdminLayout :visitas="visitas">
        <Head title="Registrar Pago" />

        <h1 class="text-3xl font-bold mb-6">Registrar Pago</h1>

        <form
            @submit.prevent="form.post(route('pagos.store'))"
            class="max-w-xl space-y-4"
        >
            <!-- Orden de análisis -->
            <div>
                <label for="orden_id" class="label">Orden de Análisis</label>
                <select
                    v-model="ordenSeleccionada"
                    id="orden_id"
                    class="select select-bordered w-full"
                >
                    <option disabled value="">Selecciona una orden</option>
                    <option
                        v-for="orden in ordenes"
                        :key="orden.id"
                        :value="orden.id"
                    >
                        Orden #{{ orden.id }} - Cliente:
                        {{ orden.mascota?.cliente?.nombre }} - Mascota:
                        {{ orden.mascota?.nombre }}
                    </option>
                </select>
                <InputError
                    :message="form.errors.orden_id"
                    class="text-error mt-1"
                />
            </div>
            <p v-if="ordenes.length === 0" class="text-warning mt-2">
                No hay órdenes pendientes para registrar pago.
            </p>

            <!-- Monto (auto completado) -->
            <div>
                <label class="label">Monto</label>
                <input
                    type="text"
                    class="input input-bordered w-full"
                    :value="
                        ordenData
                            ? `Bs. ${Number(ordenData.total).toFixed(2)}`
                            : ''
                    "
                    disabled
                />
            </div>

            <!-- Método de pago -->
            <div>
                <label for="metodo_pago" class="label">Método de Pago</label>
                <select
                    v-model="form.metodo_pago"
                    id="metodo_pago"
                    class="select select-bordered w-full"
                >
                    <option disabled value="">Selecciona un método</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
                <InputError
                    :message="form.errors.metodo_pago"
                    class="text-error mt-1"
                />
            </div>

            <!-- Botón -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing"
                >
                    Registrar Pago
                </button>
            </div>
        </form>
    </AdminLayout>
</template>
