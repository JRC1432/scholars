<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      ref="tableRef"
      title="Treats"
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

// Items Variable

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

// Read Scholars

const fetchFromServer = (startRow, count, filter, sortBy, descending) => {
  let data = originalRows.value;
  const normalizedFilter = filter.toLowerCase().replace(/-/g, "");

  if (filter) {
    data = data.filter(
      (row) =>
        (row.full_name &&
          row.full_name.toLowerCase().includes(normalizedFilter)) ||
        (row.spas_id &&
          row.spas_id
            .toLowerCase()
            .replace(/-/g, "")
            .includes(normalizedFilter))
    );
  }

  if (sortBy) {
    const sortField = sortBy;
    data.sort((a, b) => {
      const aValue = a[sortField];
      const bValue = b[sortField];
      if (aValue === bValue) return 0;
      return (aValue > bValue ? 1 : -1) * (descending ? -1 : 1);
    });
  }

  return data.slice(startRow, startRow + count);
};

const getRowsNumberCount = (filter) => {
  if (!filter) return originalRows.value.length;
  return originalRows.value.filter((row) =>
    row.full_name.toLowerCase().includes(filter.toLowerCase())
  ).length;
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

const readcholars = () => {
  axios.get("/read.php?readscholar").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const tableRef = ref(null);

onMounted(() => {
  readcholars();
});
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
