<template>
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
      <q-tr :prop="props" @click="showMonitor(props)"
        ><q-td key="spas_id" :props="props">
          {{ props.row.yr_awarded }}
        </q-td>
        <q-td key="spas_id" :props="props">
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
          <template v-if="props.row.term == 1"> 1st Semester </template>
          <template v-else-if="props.row.term == 2"> 2nd Semester </template>
          <template v-else-if="props.row.term == 3"> Summer </template>
          <template v-else> Mid Year </template>
        </q-td>
      </q-tr>
    </template>

    <template v-slot:top-left>
      <q-btn
        color="primary"
        icon-right="archive"
        label="Export To CSV"
        no-caps
        @click="downloadCSV"
      />
    </template>
  </q-table>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar, exportFile } from "quasar";
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
    name: "yr_awarded",
    required: true,
    label: "Year of Award",
    align: "left",
    field: "yr_awarded",
    sortable: true,
  },
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
    label: "NAME",
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
];

// Read Scholars Eligible for Financial Assistance

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

const readScholarsEligible = () => {
  axios.get("/read.php?readEligible").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const tableRef = ref(null);

onMounted(() => {
  readScholarsEligible();
});

// CSV Export

// State
const queryData = ref([]);

// Fetch Data Function
const fetchData = async () => {
  try {
    const response = await axios.get("read.php?exportCSV");
    queryData.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

// Convert Data to CSV Function
const convertToCSV = (data) => {
  if (data.length === 0) return "";

  // Ensure all keys are accounted for in case of missing fields in some objects
  const headers = [...new Set(data.flatMap((obj) => Object.keys(obj)))].join(
    ","
  );

  const rows = data
    .map((row) =>
      headers
        .split(",")
        .map((header) => {
          let value = row[header];
          // Handle nested objects or arrays if needed
          if (typeof value === "object" && value !== null) {
            value = JSON.stringify(value);
          }
          return `"${
            value !== undefined ? String(value).replace(/"/g, '""') : ""
          }"`;
        })
        .join(",")
    )
    .join("\n");

  return `${headers}\n${rows}`;
};

// Download CSV Function
const downloadCSV = () => {
  const csvData = convertToCSV(queryData.value);
  const blob = new Blob([csvData], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "data.csv";
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
};

// Fetch data on component mount
onMounted(fetchData);

// Show Monitor

const showMonitor = (props) => {
  router.push({
    path: "/editgrades/" + props.row.spas_id,
  });
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
