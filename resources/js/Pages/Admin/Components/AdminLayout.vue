<template>
    <div class="antialiased bg-gray-50">
        <Navbar />
        <Sidebar />

        <main class="p-4 md:ml-64 h-auto pt-20">
            <slot />
            <Footer />
        </main>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

import Navbar from "./Layouts/Navbar.vue";
import Sidebar from "./Layouts/Sidebar.vue";
import Footer from "./Layouts/Footer.vue";

onMounted(() => {
    initFlowbite();
});
</script>
