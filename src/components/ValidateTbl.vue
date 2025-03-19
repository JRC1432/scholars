<template>
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
      <q-tr :prop="props">
        <q-td key="yr_awarded" :props="props">
          {{ props.row.yr_awarded }}
        </q-td>

        <q-td key="spas_id" :props="props">
          {{ props.row.spas_id }}
        </q-td>
        <q-td key="full_name" :props="props">
          {{ props.row.full_name }}
        </q-td>
        <q-td key="sy" :props="props">
          {{ props.row.sy }}
        </q-td>
        <q-td key="term" :props="props">
          <text v-if="props.row.term === 1">1st Term</text>
          <text v-else-if="props.row.term === 2">2nd Term</text>
          <text v-else-if="props.row.term === 3">Summer</text>
          <text v-else>Mid Year</text>
        </q-td>

        <q-td key="progress_status" :props="props">
          <q-badge
            v-if="
              props.row.progress_status === null ||
              props.row.progress_status === ''
            "
            color="red-4"
            :label="props.value"
          >
            N/A
          </q-badge>

          <q-badge
            v-else
            @click="gotoPS(props)"
            color="purple"
            :label="props.row.progress_status"
            class="pointer-class"
          >
            <span style="display: none">{{ props.row.term_id }}</span>
          </q-badge>
        </q-td>

        <q-td key="standing" :props="props">
          <q-badge
            v-if="props.row.standing === null || props.row.standing === ''"
            color="red-4"
            :label="props.value"
          >
            N/A
          </q-badge>
          <q-badge
            v-else
            @click="gotoStanding(props)"
            color="purple"
            :label="props.row.standing"
            class="pointer-class"
          >
            <!-- Display props.row.sstanding only -->
            <span style="display: none">{{ props.row.term_id }}</span>
          </q-badge>
        </q-td>
      </q-tr>
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
  rowsPerPage: 13,
  rowsNumber: 13,
});

const columns = [
  {
    name: "yr_awarded",
    required: true,
    label: "Year Awarded",
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
    label: "TERM",
    align: "left",
    field: "term",
    sortable: true,
  },
  {
    name: "progress_status",
    required: true,
    label: "PROGRESS STATUS",
    align: "left",
    field: "progress_status",
    sortable: true,
  },
  {
    name: "standing",
    required: true,
    label: "STANDING",
    align: "left",
    field: "standing",
    sortable: true,
  },
];

const tableRef = ref(null);

onMounted(() => {
  readValidate();
});

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

const readValidate = () => {
  axios.get("/read.php?readUnvalidated").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const gotoPS = (props) => {
  router.push({
    path: "/historyrec/" + props.row.spas_id,
  });
};

const gotoStanding = (props) => {
  router.push({
    path: "/historyrec/" + props.row.spas_id,
  });
};
</script>

<style>
.pointer-class {
  cursor: pointer; /* Changes the cursor to a pointer (hand) */
}
</style>
