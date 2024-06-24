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

// Item Variables
const filter = ref("");
const pagination = ref({
  rowsPerPage: 10,
});
const rows = ref([]);

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

onMounted(() => {
  readScholarsEligible();
});

const readScholarsEligible = () => {
  axios.get("/read.php?readEligible").then(function (response) {
    rows.value = response.data;
  });
};

const fetchData = async (queryParams) => {
  try {
    const response = await axios.get(`/read.php?exportCSV&${queryParams}`);

    if (response.status !== 200) {
      throw new Error("Network response was not ok");
    }

    return response.data;
  } catch (error) {
    console.error("Error fetching data:", error);
    throw error;
  }
};

const convertToCSV = (data) => {
  try {
    if (!Array.isArray(data) || data.length === 0) {
      throw new Error("Data is not in the expected format");
    }

    // Example: convert data to CSV format
    let csvContent = "";
    if (Array.isArray(data[0])) {
      // If data is an array of arrays
      csvContent =
        "data:text/csv;charset=utf-8," +
        data.map((row) => row.join(",")).join("\n");
    } else if (typeof data[0] === "object") {
      // If data is an array of objects
      const header = Object.keys(data[0]);
      csvContent =
        "data:text/csv;charset=utf-8," +
        header.join(",") +
        "\n" +
        data
          .map((row) => header.map((field) => row[field]).join(","))
          .join("\n");
    }

    return encodeURI(csvContent);
  } catch (error) {
    console.error("Error converting data to CSV:", error);
    throw error;
  }
};

const downloadCSV = async () => {
  const queryParams = "someQueryParameters"; // Modify based on your needs
  try {
    const data = await fetchData(queryParams);
    const csvContent = convertToCSV(data);
    const link = document.createElement("a");
    link.setAttribute("href", csvContent);
    link.setAttribute("download", "data.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } catch (error) {
    console.error("Error downloading CSV:", error);
    // Handle error as needed
  }
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
