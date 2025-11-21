<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow p-4">
      <h2 class="font-bold text-xl mb-4">Admin</h2>

      <nav>
        <ul class="space-y-2">
          <li><Link href="/dashboard">Dashboard</Link></li>
          <li><Link href="/users">Users</Link></li>
          <li><Link href="/roles">Roles</Link></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
