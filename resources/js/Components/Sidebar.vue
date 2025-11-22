<template>
  <aside class="w-64 bg-white h-screen border-r border-gray-200 fixed z-20">
    <div class="overflow-y-auto h-full px-3 py-4">
      <nav>
        <ul class="space-y-1">

          <template v-for="(menu, index) in localMenuItems" :key="index">

            <li>
              <template v-if="menu.submenu && menu.submenu.length">

                <button
                  @click="toggle(index)"
                  class="w-full flex items-center justify-between gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition"
                >
                  <div class="flex items-center gap-3">
                    <span v-html="menu.icon" class="text-xl text-blue-500"></span>
                    <span class="text-left font-medium">{{ menu.title }}</span>
                  </div>

                  <svg
                    class="w-4 h-4 text-gray-400 transform transition duration-300"
                    :class="{ 'rotate-90': menu.open }"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7" />
                  </svg>
                </button>

                <ul
                  class="ml-5 mt-1 space-y-1 overflow-hidden transition-all duration-300 ease-in-out"
                  :style="{ maxHeight: menu.open ? (menu.submenu.length * 50) + 'px' : '0px' }"
                >
                  <li
                    v-for="(sub, sIdx) in menu.submenu"
                    :key="sIdx"
                  >
                    <Link
                      :href="sub.link"
                      class="flex items-center gap-3 pl-6 pr-4 py-2 rounded-lg text-sm text-gray-600 transition"
                      :class="sub.is_active
                        ? 'bg-blue-50 text-blue-600 font-semibold'
                        : 'hover:bg-gray-50 hover:text-gray-800'"
                    >
                      <i class="ri-arrow-right-s-line text-lg"></i>
                      {{ sub.title }}
                    </Link>
                  </li>
                </ul>

              </template>

              <template v-else>
                <Link
                  :href="menu.link"
                  class="w-full flex items-center gap-3 px-4 py-2 text-gray-700 rounded-lg transition"
                  :class="menu.is_active
                    ? 'bg-blue-600 text-white font-semibold shadow-md'
                    : 'hover:bg-gray-100 font-medium'"
                >
                  <span v-html="menu.icon"
                    class="text-xl"
                    :class="menu.is_active ? 'text-white' : 'text-blue-500'">
                  </span>
                  <span>{{ menu.title }}</span>
                </Link>
              </template>

            </li>

          </template>

        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";

const props = defineProps({
  // The structure of menuItems is expected to be:
  // [{ title, link, icon, is_active, submenu: [{ title, link, is_active }] }]
  menuItems: {
    type: Array,
    required: true,
    default: () => [],
  },
});

// Create a reactive, deep copy of the prop to manage the 'open' state internally
// This prevents the "Avoid mutating a prop directly" warning
const localMenuItems = ref(JSON.parse(JSON.stringify(props.menuItems)));

// Watch for external changes to the prop and update the local state
watch(
  () => props.menuItems,
  (newItems) => {
    // Merge new items, preserving the local 'open' state if possible
    const newLocal = JSON.parse(JSON.stringify(newItems)).map(newItem => {
        const existingItem = localMenuItems.value.find(
            oldItem => oldItem.title === newItem.title // Use a unique identifier if possible
        );
        return {
            ...newItem,
            // Preserve the 'open' state from the previous local copy
            open: existingItem ? existingItem.open : false
        };
    });
    localMenuItems.value = newLocal;
  },
  { deep: true }
);

// Toggle the 'open' state of a menu item
const toggle = (index) => {
  // Directly mutate the internal reactive state
  localMenuItems.value[index].open = !localMenuItems.value[index].open;
};

// Optional: Automatically open the parent menu if any submenu item is active
// This makes the sidebar more user-friendly
computed(() => {
    localMenuItems.value.forEach((menu, index) => {
        if (menu.submenu && menu.submenu.length) {
            const isActive = menu.submenu.some(sub => sub.is_active);
            if (isActive && !menu.open) {
                // Set the 'open' state to true if an active child is found
                localMenuItems.value[index].open = true;
            }
        }
    });
});
</script>
