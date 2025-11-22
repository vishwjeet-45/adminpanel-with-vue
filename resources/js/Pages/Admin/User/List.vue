<template>

  <AppLayout>

    <div class="p-6">

      <!-- PAGE HEADER -->
      <div class="flex items-center justify-between mb-5">
        <h1 class="text-2xl font-semibold">User List</h1>

        <Link
          href="/admin/users/create"
          class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"
        >
          + Add User
        </Link>
      </div>

      <!-- SEARCH BAR -->
      <div class="mb-4 flex justify-end">
        <input
          v-model="search"
          @input="searchUsers"
          type="text"
          class="w-50 p-2 border rounded-lg"
          placeholder="Search users..."
        />
      </div>

      <!-- USER TABLE -->
      <div class="overflow-x-auto rounded-lg border">
        <table class="w-full text-sm">
          <thead class="bg-gray-100 border-b">
            <tr>
              <th class="px-4 py-2 text-left">#</th>
              <th class="px-4 py-2 text-left">Name</th>
              <th class="px-4 py-2 text-left">Email</th>
              <th class="px-4 py-2 text-left">Role</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-right">Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(user, index) in users.data"
              :key="user.id"
              class="border-b hover:bg-gray-100 bg-gray-50"
            >
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ user.name }}</td>
              <td class="px-4 py-2">{{ user.email }}</td>
              <td class="px-4 py-2">
                <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs">
                </span>
              </td>

            <td class="px-4 py-2">
                <label class="switch">
                    <input
                    type="checkbox"
                    :checked="user.status === 'active'"
                    @change="toggleStatus(user.id)"
                    >
                    <span class="slider round"></span>
                </label>
            </td>


              <td class="px-4 py-2 text-right space-x-2">
                <Link
                  :href="`/admin/users/${user.id}/edit`"
                  class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded"
                >
                  Edit
                </Link>

                <button
                  @click="deleteUser(user.id)"
                  class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

     <div class="mt-4 flex justify-end space-x-2">
        <template v-for="link in users.links" :key="link.label">
            <Link
            :href="link.url || ''"
            :disabled="!link.url"
            v-html="link.label"
            :class="[
                'px-3 py-1 rounded border',
                link.active
                ? 'bg-indigo-600 text-white'
                : 'bg-white hover:bg-gray-100',
                !link.url ? 'opacity-50 cursor-not-allowed' : ''
            ]"
            />
        </template>
        </div>

<div v-if="$page.props.flash.success"
     class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
  {{ $page.props.flash.success }}
</div>

<template>
  <!-- Flash Message -->
  <div
    v-if="flashMessage"
    class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 transition-opacity duration-500"
  >
    {{ flashMessage }}
  </div>
</template>


    </div>

  </AppLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";


const page = usePage();
const flashMessage = ref(page.props.flash?.success || null);

// Watch flash and auto-remove after 3 seconds
watch(
  () => page.props.flash?.success,
  (value) => {
    flashMessage.value = value;
    if (value) {
      setTimeout(() => {
        flashMessage.value = null;
      }, 3000); // 3 seconds
    }
  }
);

const props = defineProps({
  users: Object,
  filters: Object,
});


const search = ref(props.filters.search ?? "");

const searchUsers = () => {
  router.get(
    "/users",
    { search: search.value },
    { preserveState: true, replace: true }
  );
};

// const deleteUser = (id) => {
//   if (confirm("Are you sure?")) {
//     router.delete(`/admin/users/${id}`);
//   }
// };

const toggleStatus = (id) => {
  router.post(`/admin/users/${id}/toggle-status`, {}, { preserveScroll: true });
};

</script>

    <style>
    .switch {
  position: relative;
  display: inline-block;
  width: 46px;
  height: 24px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2196F3; /* blue */
}

input:checked + .slider:before {
  transform: translateX(22px);
}

    </style>
