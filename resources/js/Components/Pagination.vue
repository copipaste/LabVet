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
        class="btn btn-sm"
        :class="{ 'btn-active': link.active }"
        v-html="link.label"
      />
      <span
        v-else
        class="btn btn-sm btn-disabled"
        v-html="link.label"
      />
    </template>
  </div>
</template>
