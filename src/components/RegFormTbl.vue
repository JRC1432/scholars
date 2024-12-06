<template>
  <q-card flat>
    <q-table
      flat
      bordered
      ref="tableRef"
      :rows="rows"
      :columns="columns"
      row-key="id"
      v-model:pagination="pagination"
      :loading="loading"
      :filter="filter"
      binary-state-sort
      @request="onRequest"
      class="rounded-borders-20 no-border custom-table"
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
          <q-td key="sy" :props="props">
            {{ props.row.sy }}
          </q-td>
          <q-td key="term" :props="props">
            {{ props.row.term }}
          </q-td>
          <q-td key="term_type" :props="props">
            {{ props.row.term_type }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </q-card>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

const tableRef = ref(null);
const originalRows = ref([]);
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const pagination = ref({
  descending: false,
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 10,
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
    name: "full_name",
    required: true,
    label: "Full Name",
    align: "left",
    field: "full_name",
    sortable: true,
  },
  {
    name: "sy",
    required: true,
    label: "School Year",
    align: "left",
    field: "sy",
    sortable: true,
  },
  {
    name: "term",
    required: true,
    label: "Term",
    align: "left",
    field: "term",
    sortable: true,
  },
  {
    name: "term_type",
    required: true,
    label: "Term Type",
    align: "left",
    field: "term_type",
    sortable: true,
  },
];

// Read Registration Form For Validation

const fetchFromServer = (startRow, count, filter, sortBy, descending) => {
  let data = originalRows.value;
  const normalizedFilter = (filter || "").toLowerCase().replace(/-/g, "");

  if (filter) {
    data = data.filter((row) => {
      const fullName = row.full_name || ""; // Default to an empty string
      const spasId = row.spas_id || ""; // Default to an empty string
      return (
        fullName.toLowerCase().includes(normalizedFilter) ||
        spasId.toLowerCase().replace(/-/g, "").includes(normalizedFilter)
      );
    });
  }

  if (sortBy) {
    const sortField = sortBy;
    data.sort((a, b) => {
      const aValue = a[sortField] || ""; // Handle null values
      const bValue = b[sortField] || ""; // Handle null values
      if (aValue === bValue) return 0;
      return (aValue > bValue ? 1 : -1) * (descending ? -1 : 1);
    });
  }

  return data.slice(startRow, startRow + count);
};

const getRowsNumberCount = (filter) => {
  const normalizedFilter = (filter || "").toLowerCase();
  if (!filter) return originalRows.value.length;

  return originalRows.value.filter((row) => {
    const fullName = row.full_name || "";
    return fullName.toLowerCase().includes(normalizedFilter);
  }).length;
};

const onRequest = (props) => {
  const { page, rowsPerPage, sortBy, descending } = props.pagination;
  const filter = props.filter;

  loading.value = true;

  setTimeout(() => {
    pagination.value.rowsNumber = getRowsNumberCount(filter);

    const fetchCount =
      rowsPerPage === 0 ? pagination.value.rowsNumber : rowsPerPage;
    const startRow = (page - 1) * rowsPerPage;
    const returnedData = fetchFromServer(
      startRow,
      fetchCount,
      filter,
      sortBy,
      descending
    );

    rows.value.splice(0, rows.value.length, ...returnedData);

    pagination.value.page = page;
    pagination.value.rowsPerPage = rowsPerPage;
    pagination.value.sortBy = sortBy;
    pagination.value.descending = descending;

    loading.value = false;
  }, 1500);
};

const readRegForm = () => {
  axios.get("/read.php?readRegForm").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const showScholar = (props) => {
  router.push({
    path: "/editgrades/" + props.row.term_id,
  });
};

onMounted(() => {
  readRegForm();
});
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
