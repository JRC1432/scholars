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
    </q-table>
  </div>
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
  IconNfcOff,
} from "@tabler/icons-vue";
import Swal from "sweetalert2";
import PasswordMeter from "vue-simple-password-meter";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

const columns = [
  {
    name: "internal_id",
    required: true,
    label: "Internal ID",
    align: "left",
    field: "internal_id",
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
    name: "last_name",
    align: "center",
    label: "Last Name",
    field: "last_name",
    sortable: true,
  },
  {
    name: "first_name",
    align: "left",
    label: "First Name",
    field: "first_name",
    sortable: true,
  },
  { name: "sex", align: "left", label: "SEX", field: "sex", sortable: true },
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
    align: "left",
    label: "Region",
    field: "region",
    sortable: true,
  },
  {
    name: "work_region",
    align: "left",
    label: "Work Region",
    field: "work_region",
    sortable: true,
  },
];

const originalRows = ref([]);
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const pagination = ref({
  sortBy: "internal_id",
  descending: false,
  page: 1,
  rowsPerPage: 3,
  rowsNumber: 10,
});

const fetchFromServer = (startRow, count, filter, sortBy, descending) => {
  let data = originalRows.value;

  if (filter) {
    data = data.filter((row) =>
      row.username.toLowerCase().includes(filter.toLowerCase())
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
    row.username.toLowerCase().includes(filter.toLowerCase())
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

const readusers = () => {
  axios.get("/read.php?readuser").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const tableRef = ref(null);

onMounted(() => {
  readusers();
});
</script>
