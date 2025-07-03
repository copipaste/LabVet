<!-- resources/js/Components/RoleGate.vue -->
<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  roles: {
    type: Array,
    required: true,
  },
})

const userRoles = usePage().props.auth?.roles || []

const hasAccess = computed(() =>
  props.roles.some(role => userRoles.includes(role))
)
</script>

<template>
  <slot v-if="hasAccess" />
</template>
