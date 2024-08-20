<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Exam Information
      </div>
      <!-- <q-separator class="q-mt-md q-mb-xs" inset /> -->
      <div class="q-pa-lg">
        <q-table
          flat
          bordered
          :rows="rows"
          :columns="columns"
          row-key="name"
          :filter="filter"
          v-model:pagination="pagination"
          class="no-border surface-container"
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
              <q-td key="spas_id" :props="props">
                {{ props.row.spas_id }}
              </q-td>
              <q-td key="serial_no" :props="props">
                {{ props.row.serial_no }}
              </q-td>
              <q-td key="tpr" :props="props">
                {{ props.row.tpr }}
              </q-td>
              <q-td key="trs" :props="props">
                {{ props.row.trs }}
              </q-td>
              <q-td key="ztot" :props="props">
                {{ props.row.ztot }}
              </q-td>
              <q-td key="ztot" :props="props">
                {{ props.row.ztot }}
              </q-td>
              <q-td key="priority" :props="props">
                {{ props.row.priority }}
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </q-card>
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconScript, IconClipboardText } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Items Variable

const rows = ref([]);
const filter = ref("");
const pagination = ref({
  rowsPerPage: 10,
});

const state = reactive({
  spasid: "",
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
    name: "serial_no",
    required: true,
    label: "Serial Number",
    align: "left",
    field: "serial_no",
    sortable: true,
  },

  {
    name: "tpr",
    required: true,
    label: "TPR",
    align: "left",
    field: "tpr",
    sortable: true,
  },
  {
    name: "trs",
    align: "left",
    label: "TRS",
    field: "trs",
    sortable: true,
  },
  {
    name: "ztot",
    align: "left",
    label: "ZTOT",
    field: "ztot",
    sortable: true,
  },

  {
    name: "prs",
    align: "left",
    label: "PRS",
    field: "prs",
    sortable: true,
  },

  {
    name: "priority",
    align: "left",
    label: "PRIORITY",
    field: "priority",
    sortable: true,
  },
];

// Read UnderGrad

const spasid = ref();

onMounted(() => {
  populateAll();
});

const populateAll = () => {
  spasid.value = route.params.id;
  var formData = new FormData();
  formData.append("id", spasid.value);

  // Read Undergrad Records
  axios.post("/read.php?readExamInfo", formData).then((response) => {
    rows.value = response.data;
  });
};
</script>
