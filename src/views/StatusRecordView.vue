<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Status Records
      </div>
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
                <q-badge
                  @click="showSpas(props)"
                  color="purple"
                  :label="props.value"
                  class="pointer-class"
                >
                  {{ props.row.spas_id }}
                </q-badge>
              </q-td>

              <q-td key="program" :props="props">
                {{ props.row.program }}
              </q-td>
              <q-td key="sub_program" :props="props">
                {{ props.row.sub_program }}
              </q-td>
              <q-td key="category" :props="props">
                {{ props.row.category }}
              </q-td>
              <q-td key="contract_status" :props="props">
                {{ props.row.contract_status }}
              </q-td>
              <q-td key="progress_status" :props="props">
                {{ props.row.progress_status }}
              </q-td>
              <q-td key="standing" :props="props">
                {{ props.row.standing }}
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </q-card>
  </div>

  <!-- Scholar History Details  -->

  <q-dialog v-model="showSpasDetail" persistent full-width>
    <q-card class="rounded-borders-20">
      <q-toolbar>
        <IconHistory :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">VIEW</span>
          HISTORY
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <HistoryTbl :spasid="spasid" />
      </q-card-section>

      <q-separator />
    </q-card>
  </q-dialog>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import HistoryTbl from "../components/HistoryTbl.vue";

import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconHistory } from "@tabler/icons-vue";

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
const showSpasDetail = ref(false);

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
    name: "program",
    required: true,
    label: "Program",
    align: "left",
    field: "program",
    sortable: true,
  },
  {
    name: "sub_program",
    align: "left",
    label: "Sub Program",
    field: "sub_program",
    sortable: true,
  },
  {
    name: "category",
    align: "left",
    label: "Category",
    field: "category",
    sortable: true,
  },

  {
    name: "contract_status",
    align: "left",
    label: "Availment",
    field: "contract_status",
    sortable: true,
  },

  {
    name: "progress_status",
    align: "left",
    label: "Progress Status",
    field: "progress_status",
    sortable: true,
  },

  {
    name: "standing",
    align: "left",
    label: "Standing",
    field: "standing",
    sortable: true,
  },
];

// Read Status Records
const id = ref();
onMounted(() => {
  populateAll();
});

const populateAll = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?statRecID", formData).then((response) => {
    rows.value = response.data;
  });
};

const spasid = ref("test");
const showSpas = (props) => {
  // console.log(props.row);
  // showSpasDetail.value = true;
  spasid.value = props.row.spas_id;
  router.push({
    path: "/historyrec/" + spasid.value,
  });

  console.log(spasid.value);
};
</script>

<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}

.pointer-class {
  cursor: pointer; /* Changes the cursor to a pointer (hand) */
}
</style>
