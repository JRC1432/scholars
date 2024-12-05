<template>
  <q-card flat>
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
            <q-badge
              class="primary q-px-md q-py-xs rounded-borders-10"
              :label="props.value"
            >
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
        <div class="q-px-sm">
          <span class="text-bold">Regions</span>
          <q-select
            ref="reftermtype"
            :options="regionOptions"
            v-model="region"
            name="region"
            outlined
            dense
            hide-bottom-space
            emit-value
            @update:model-value="readScholarsEligible"
            :rules="[myRule]"
            style="width: 400px"
          />
        </div>
        <div class="q-px-sm">
          <span class="text-bold">Schools</span>
          <q-select
            ref="refschool"
            outlined
            dense
            hide-bottom-space
            behavior="menu"
            emit-value
            map-options
            use-input
            input-debounce="0"
            v-model="school"
            name="school"
            :options="schooloptions"
            @filter="filterschool"
            @update:model-value="readScholarsEligible"
            :rules="[myRule]"
            clearable
            style="width: 400px"
          >
          </q-select>
        </div>
      </template>
    </q-table>
    <q-card-section>
      <q-btn
        color="primary"
        icon-right="archive"
        label="Export To CSV"
        no-caps
        @click="downloadCSV"
      />
    </q-card-section>
  </q-card>
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

const school = ref("All");
const region = ref("All");

//Rules

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

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

const tableRef = ref(null);
var schooloptions2 = [];
const schooloptions = ref(schooloptions2);
var regoptions2 = [];
const regoptions = ref(regoptions2);

onMounted(() => {
  readScholarsEligible();
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

const readScholarsEligible = () => {
  var formData = new FormData();
  formData.append("school", school.value);
  formData.append("region", region.value);

  axios.post("/read.php?readEligible", formData).then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });

  // Select School

  axios.get("/read.php?schoolNames").then((response) => {
    schooloptions2 = response.data;
    schooloptions2.unshift({ label: "All", value: "All" });
  });

  // Select Region

  axios.get("/read.php?region").then((response) => {
    regoptions2 = response.data;
  });

  axios.post("/read.php?exportCSV", formData).then((response) => {
    queryData.value = response.data;
  });
};

// Filters
// School Filters
const filterschool = (val, update) => {
  if (val === "") {
    update(() => {
      schooloptions.value = schooloptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    schooloptions.value = schooloptions2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Regions
const regionOptions = [
  { label: "All", value: "All", color: "primary" },
  { label: "NCR", value: "NCR", color: "primary" },
  { label: "CAR", value: "CAR", color: "primary" },
  { label: "1", value: "1", color: "primary" },
  { label: "2", value: "2", color: "primary" },
  { label: "3", value: "3", color: "primary" },
  { label: "4A", value: "4A", color: "primary" },
  { label: "4B", value: "4B", color: "primary" },
  { label: "5", value: "5", color: "primary" },
  { label: "6", value: "6", color: "primary" },
  { label: "7", value: "7", color: "primary" },
  { label: "8", value: "8", color: "primary" },
  { label: "9", value: "9", color: "primary" },
  { label: "10", value: "10", color: "primary" },
  { label: "11", value: "11", color: "primary" },
  { label: "12", value: "12", color: "primary" },
  { label: "CARAGA", value: "CARAGA", color: "primary" },
  { label: "BARMM", value: "BARMM", color: "primary" },
];

// CSV Export

// State
const queryData = ref([]);

// Convert Data to CSV Function
const convertToCSV = (data) => {
  if (data.length === 0) return "";

  // Use map + reduce instead of flatMap for compatibility
  const headers = Array.from(
    data.reduce((set, obj) => {
      Object.keys(obj).forEach((key) => set.add(key));
      return set;
    }, new Set())
  ).join(",");

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

// Show Monitor

const showMonitor = (props) => {
  router.push({
    path: "/monitorsheet/" + props.row.spas_id,
  });
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
