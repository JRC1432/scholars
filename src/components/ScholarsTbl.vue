<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      :rows="rows"
      :columns="columns"
      row-key="name"
      :filter="filter"
      v-model:pagination="pagination"
      class="rounded-borders-20 no-border custom-table"
      model:pagination="pagination"
    >
      <template v-slot:top-right>
        <q-input
          borderless
          dense
          debounce="300"
          v-model="filter"
          placeholder="Search"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:body="props">
        <q-tr :prop="props" @click="showScholar(props)"
          ><q-td key="spas_id" :props="props">
            {{ props.row.spas_id }}
          </q-td>
          <q-td key="full_name" :props="props">
            <q-badge class="primary" :label="props.value">
              {{ props.row.full_name }}
            </q-badge>
          </q-td>
          <q-td key="sex" :props="props">
            {{ props.row.sex }}
          </q-td>
          <q-td key="dob" :props="props">
            {{ props.row.dob }}
          </q-td>
          <q-td key="pob" :props="props">
            {{ props.row.pob }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import {
  IconUserEdit,
  IconUserCancel,
  IconSquareRoundedX,
  IconUserMinus,
  IconUserPlus,
  IconFileTypeCsv,
} from "@tabler/icons-vue";
import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

// Item Variables
const filter = ref("");
const pagination = ref({
  rowsPerPage: 10,
});
const rows = ref([]);

const columns = [
  {
    name: "spas_id",
    required: true,
    label: "SPAS ID",
    align: "left",
    field: "spas_id",
    sortable: true,
  },
  {
    name: "full_name",
    required: true,
    label: "Full Name",
    align: "left",
    field: "full_name",
    sortable: true,
  },
  {
    name: "sex",
    required: true,
    label: "SEX",
    align: "left",
    field: "sex",
    sortable: true,
  },
  {
    name: "dob",
    required: true,
    label: "Date of Birth",
    align: "left",
    field: "dob",
    sortable: true,
  },
  {
    name: "pob",
    required: true,
    label: "Place of Birth",
    align: "left",
    field: "pob",
    sortable: true,
  },
];

const showScholar = (props) => {
  router.push({
    path: "/personal/" + props.row.spas_id,
  });
};

// Read Users

onMounted(() => {
  readcholars();
});

const readcholars = () => {
  axios.get("/read.php?readscholar").then(function (response) {
    rows.value = response.data;
  });
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
