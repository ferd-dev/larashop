<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
  pagination: Object,
});

const handlePageChange = (url) => {
  if (url) {
    router.get(url, {}, { preserveState: true });
  }
};
</script>

<template>
  <nav
    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
    aria-label="Table navigation"
  >
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
      Mostrando
      <span class="font-semibold text-gray-900 dark:text-white">
        {{ pagination.from }}
      </span>
      a
      <span class="font-semibold text-gray-900 dark:text-white">
        {{ pagination.to }}
      </span>
      de
      <span class="font-semibold text-gray-900 dark:text-white">
        {{ pagination.total }}
      </span>
    </span>
    <ul class="inline-flex items-stretch -space-x-px">
      <li v-for="link in pagination.links" :key="link.label">
        <button
          :class="[
            'flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700',
            link.active
              ? 'text-blue-600 bg-blue-50 border-blue-300'
              : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700',
          ]"
          @click="handlePageChange(link.url)"
          :disabled="!link.url"
        >
          <span v-html="link.label"></span>
        </button>
      </li>
    </ul>
  </nav>
</template>
