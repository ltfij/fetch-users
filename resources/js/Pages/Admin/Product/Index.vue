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
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import BaseButton from "@/Components/BaseButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButtons from "@/Components/BaseButtons.vue"
import NotificationBar from "@/Components/NotificationBar.vue"
import Pagination from "@/Components/Admin/Pagination.vue"
import Sort from "@/Components/Admin/Sort.vue"
import CardBoxModal from '@/Components/CardBoxModal.vue'

const props = defineProps({
  products: {
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

const isModalActive = ref(false)

</script>

<template>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <LayoutAuthenticated>
    <Head title="Lutfi Jamaluddin" />
    <SectionMain>
      <div class="pb-5">
        <input class="w-1/2 p-2 h-max h-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" @change="onFileChange">
        <BaseButton
                :icon="mdiTune"
                label="Upload"
                @click="uploadFile"
                color="primary"
                class="ml-4 inline-flex items-center px-12 py-2 pb-3"
              />
        <p v-if="uploadSuccess">File uploaded successfully!</p>
      </div>

      <SectionTitleLineWithButton
        main
      >
      </SectionTitleLineWithButton>
      <CardBox class="mb-6" has-table>
        <form @submit.prevent="form.get(route('admin.product.index'))">
          <div>
              <p class="float-left px-3 pt-3">Product Master List</p>
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
                placeholder="Search ID"
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
                <Sort label="Product ID" attribute="id" />
              </th>
              <th>
                <Sort label="Types" attribute="types" />
              </th>
              <th>
                <Sort label="Brand" attribute="brand" />
              </th>
              <th>
                <Sort label="Model" attribute="model" />
              </th>
              <th>
                <Sort label="Capacity" attribute="capacity" />
              </th>
              <th>
                <Sort label="Quantity" attribute="quantity" />
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(product, index) in products.data" :key="product.id">
              <td data-label="No.">{{ index+1 }}</td>
              <td data-label="Product ID">{{ product.id }}</td>
              <td data-label="Types">{{ product.types }}</td>
              <td data-label="Brand">{{ product.brand }}</td>
              <td data-label="Model">{{ product.model }}</td>
              <td data-label="Capacity">{{ product.capacity }}</td>
              <td data-label="Quantity">{{ product.quantity }}</td>
            </tr>
          </tbody>
        </table>
        <div class="py-4">
          <Pagination :data="products" />
        </div>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            file: null,
            uploadSuccess: false,
        };
    },
    methods: {
        onFileChange(event) {
            this.file = event.target.files[0];
        },
        uploadFile() {
            if (this.file) {
                let formData = new FormData();
                formData.append('file', this.file);

                axios.post('/admin/product/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then(response => {
                    this.uploadSuccess = true;
                    window.location.reload();
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('There was an error uploading the file!', error);
                    alert('There was an error uploading the file! Please upload only excel files.');
                });
            } else {
                alert('Please select a file to upload.');
            }
        }
    }
};
</script>