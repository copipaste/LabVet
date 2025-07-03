<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: {
    type: Array,
    required: true,
  },
})
</script>

<template>
  <div class="mt-4 flex flex-wrap gap-2">
    <template v-for="(link, index) in links" :key="index">
      <Link
        v-if="link.url"
        :href="link.url"
        class="btn btn-sm transition-all duration-200"
        :class="[
          link.active
            ? 'border border-primary font-bold shadow-sm'
            : 'opacity-80 hover:opacity-100',
          'pagination-themed'
        ]"
        v-html="link.label"
      />
      <span
        v-else
        class="btn btn-sm btn-disabled pagination-themed"
        v-html="link.label"
      />
    </template>
  </div>
</template>

<style>
.pagination-themed {
  background-color: var(--card-background);
  color: var(--text-color);
  border-color: var(--input-border);
}
</style>
