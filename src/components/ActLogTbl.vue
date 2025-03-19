<template>
  <div class="q-pa-md">
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
            <q-badge color="purple" :label="props.value">
              {{ props.row.full_name }}
            </q-badge>
          </q-td>
          <q-td key="action_taken" :props="props">
            {{ props.row.action_taken }}
          </q-td>
          <q-td key="action_message" :props="props">
            {{ props.row.action_message }}
          </q-td>
          <q-td key="action_taken_by" :props="props">
            {{ props.row.action_taken_by }}
          </q-td>
          <q-td key="date_time" :props="props">
            {{ props.row.date_time }}
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
  rowsPerPage: 13,
  rowsNumber: 13,
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
    name: "action_taken",
    required: true,
    label: "Action Taken",
    align: "left",
    field: "action_taken",
    sortable: true,
  },
  {
    name: "action_message",
    required: true,
    label: "Action Message",
    align: "left",
    field: "action_message",
    sortable: true,
  },
  {
    name: "action_taken_by",
    required: true,
    label: "Action Taken By",
    align: "left",
    field: "action_taken_by",
    sortable: true,
  },
  {
    name: "date_time",
    required: true,
    label: "Date / Time",
    align: "left",
    field: "date_time",
    sortable: true,
  },
];

// Read Scholars

const fetchFromServer = (startRow, count, filter, sortBy, descending) => {
  let data = originalRows.value;
  const normalizedFilter = filter.toLowerCase().replace(/-/g, "");

  if (filter) {
    data = data.filter(
      (row) =>
        (row.full_name &&
          row.full_name.toLowerCase().includes(normalizedFilter)) ||
        (row.action_taken &&
          row.action_taken.toLowerCase().includes(normalizedFilter)) ||
        (row.action_message &&
          row.action_message.toLowerCase().includes(normalizedFilter)) ||
        (row.action_taken_by &&
          row.action_taken_by.toLowerCase().includes(normalizedFilter)) ||
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
  axios.get("/read.php?readactLogs").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const tableRef = ref(null);

onMounted(() => {
  readcholars();
});
</script>
