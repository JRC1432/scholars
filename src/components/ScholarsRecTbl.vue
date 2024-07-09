<template>
  <q-table
    flat
    bordered
    :rows="rows"
    :columns="columns"
    row-key="name"
    :filter="filter"
    v-model:pagination="pagination"
    class="rounded-borders-20 no-border custom-table"
  >
    <template v-slot:top-left>
      <q-btn
        color="primary"
        size="10px"
        no-caps
        round
        icon="add"
        @click="newUser = true"
      >
        <q-tooltip class="bg-primary">Add user list</q-tooltip>
      </q-btn>
      <div class="q-ml-sm">
        <q-btn
          color="primary"
          size="10px"
          no-caps
          round
          icon="dynamic_feed"
          @click="batchUpload = true"
        >
          <q-tooltip class="bg-primary">Batch Upload</q-tooltip>
        </q-btn>
      </div>
    </template>
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
      <q-tr :prop="props" @click="showUpdateUser(props)"
        ><q-td key="spas_id" :props="props">
          {{ props.row.spas_id }}
        </q-td>
        <q-td key="username" :props="props">
          <q-badge color="light-green-4" :label="props.value">
            {{ props.row.username }}
          </q-badge>
        </q-td>
        <q-td key="full_name" :props="props">
          {{ props.row.full_name }}
        </q-td>
        <q-td key="school_code" :props="props">
          {{ props.row.school_code }}
        </q-td>
        <q-td key="sex" :props="props">
          {{ props.row.sex }}
        </q-td>
        <q-td key="email" :props="props">
          {{ props.row.email }}
        </q-td>
        <q-td key="contact_no" :props="props">
          {{ props.row.contact_no }}
        </q-td>
        <q-td key="region" :props="props">
          {{ props.row.region }}
        </q-td>
        <q-td key="school_region" :props="props">
          {{ props.row.school_region }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
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

// Items Variable

const rows = ref([]);
const filter = ref("");
const pagination = ref({
  rowsPerPage: 10,
});

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
    name: "username",
    required: true,
    label: "UserName",
    align: "left",
    field: "username",
    sortable: true,
  },
  {
    name: "full_name",
    align: "left",
    label: "Full Name",
    field: "full_name",
    sortable: true,
  },
  {
    name: "school_code",
    align: "left",
    label: "School Code",
    field: "school_code",
    sortable: true,
  },

  {
    name: "sex",
    align: "left",
    label: "SEX",
    field: "sex",
    sortable: true,
  },
  {
    name: "email",
    align: "left",
    label: "Email",
    field: "email",
    sortable: true,
  },
  {
    name: "contact_no",
    align: "left",
    label: "Contact Number",
    field: "contact_no",
    sortable: true,
  },
  {
    name: "region",
    align: "center",
    label: "Region",
    field: "region",
    sortable: true,
  },
  {
    name: "school_region",
    align: "center",
    label: "School Region",
    field: "school_region",
    sortable: true,
  },
];

// Read Users

onMounted(() => {
  readusers();
});

const readusers = () => {
  axios.get("/read.php?readScholarRec").then(function (response) {
    rows.value = response.data;
  });
};
</script>
