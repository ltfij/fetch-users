<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import { computed, ref } from 'vue'
import {
  mdiAccountKey,
  mdiPlus,
  mdiSquareEditOutline,
  mdiTrashCan,
  mdiAlertBoxOutline,
  mdiTune,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import BaseButton from "@/Components/BaseButton.vue"
import CardBox from "@/Components/CardBox.vue"
import Pagination from "@/Components/Admin/Pagination.vue"
import Sort from "@/Components/Admin/Sort.vue"
import CardBoxModal from '@/Components/CardBoxModal.vue'

const props = defineProps({
  users: {
    type: Object,
    default: () => ({}),
  },
  records: {
    type: Object,
    default: () => ({}),
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  search: props.filters.search,
})

const formDelete = useForm({})

const isModalDangerActive = ref(false)
const isModalListActive = ref(false)

function destroy(id) {
  if (confirm("Are you sure you want to delete?")) {
    formDelete.delete(route("admin.user.destroy", id))
  }
}

</script>

<template>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <LayoutAuthenticated>
    <Head title="Lutfi Jamaluddin" />
    <SectionMain>
      <CardBox class="mb-6" has-table>
        <form @submit.prevent="form.get(route('admin.user.index'))">
          <div>
            <p class="float-left px-3 pt-3">User Master List</p>
          </div>
          <div class="py-2 flex float-right">
            <div class="flex pr-4">
              <input
                type="search"
                v-model="form.search"
                class="
                  rounded-md
                  shadow-sm
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                "
                placeholder="Search Name"
              />
              <BaseButton
                label="Search"
                type="submit"
                color="info"
                class="ml-4 inline-flex items-center px-4 py-2"
              />
            </div>
          </div>
        </form>
      </CardBox>
      <CardBox class="mb-6" has-table>
        <table>
          <thead>
            <tr>
              <th>
                No.
              </th>
              <th>
                <Sort label="Name" attribute="name" />
              </th>
              <th>
                <Sort label="Age" attribute="age" />
              </th>
              <th>
                <Sort label="Gender" attribute="gender" />
              </th>
              <th>
                <Sort label="Created At" attribute="created_at" />
              </th>
              <th>
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(user, index) in users.data" :key="user.id">

              <CardBoxModal
                v-model="isModalDangerActive"
                large-title="Please confirm"
                button="danger"
                has-cancel>
                <p>Would you like to delete this user? {{ user.name }}</p>
              </CardBoxModal>

              <td data-label="No.">{{ index+1 }}</td>
              <td data-label="Name">{{ user.name }}</td>
              <td data-label="Age">{{ user.age }}</td>
              <td data-label="Gender">{{ user.gender }}</td>
              <td data-label="Created At">{{ user.created_at }}</td>
              <td class="before:hidden lg:w-1 whitespace-nowrap">
                <BaseButton
                    v-if="can.delete"
                    color="danger"
                    :icon="mdiTrashCan"
                    small
                    @click="destroy(user.id)"
                  />
              </td>
            </tr>
          </tbody>
        </table>
        <div class="py-4">
          <Pagination :data="users" />
        </div>
      </CardBox>

      <CardBox class="mb-6" has-table>
        <table>
          <thead>
            <tr>
              <th>
                No.
              </th>
              <th>
                <Sort label="Date" attribute="date" />
              </th>
              <th>
                <Sort label="Male Average Count" attribute="male_avg_count" />
              </th>
              <th>
                <Sort label="Female Average Count" attribute="female_avg_count" />
              </th>
              <th>
                <Sort label="Male Average Age" attribute="male_avg_age" />
              </th>
              <th>
                <Sort label="Female Average Age" attribute="female_avg_age" />
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(record, index) in records.data" :key="record.id">
              <td data-label="No.">{{ index+1 }}</td>
              <td data-label="Date">{{ record.date }}</td>
              <td data-label="Male Average Count">{{ record.male_avg_count }}</td>
              <td data-label="Female Average Count">{{ record.female_avg_count }}</td>
              <td data-label="Male Average Age">{{ record.male_avg_age }}</td>
              <td data-label="Female Average Age">{{ record.female_avg_age }}</td>
            </tr>
          </tbody>
        </table>
        <div class="py-4">
          <Pagination :data="records" />
        </div>
      </CardBox>

    </SectionMain>
  </LayoutAuthenticated>
</template>