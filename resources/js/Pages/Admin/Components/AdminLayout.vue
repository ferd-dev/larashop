<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">

        <Navbar />
        <Sidebar />

        <slot />

    </div>
</template>

<script setup>

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

import Navbar from './Layouts/Navbar.vue';
import Sidebar from './Layouts/Sidebar.vue';

onMounted(() => {
    initFlowbite();
})
</script>
