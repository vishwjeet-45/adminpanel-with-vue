<template>
  <div class="admin-wrapper flex min-h-screen bg-[rgb(248,255,236)] !important">
    <Sidebar :menuItems="menu" />

    <div class="content-area flex-1 ml-64 flex flex-col">
      <Header />

      <main class="flex-1 p-4 sm:p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import Sidebar from "@/Components/Sidebar.vue";
import Header from "@/Components/Header.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
// Assuming `sidebar_menu_links` is an array of menu objects
const menu = page.props.sidebar_menu_links;
</script>
