<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Scholarship Informations
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
          class="no-border custom-table surface-container"
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
            <q-tr :prop="props" @click="showContractStats(props)"
              ><q-td key="spas_id" :props="props">
                {{ props.row.spas_id }}
              </q-td>
              <q-td key="yr_awarded" :props="props">
                {{ props.row.yr_awarded }}
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
              <q-td key="duration" :props="props">
                {{ props.row.duration }}
              </q-td>
              <q-td key="remarks" :props="props">
                {{ props.row.remarks }}
              </q-td>
              <q-td key="reply_slip" :props="props">
                {{ props.row.reply_slip }}
              </q-td>
              <q-td key="contract_status" :props="props">
                <q-badge color="light-green-4" :label="props.value">
                  {{ props.row.contract_status }}
                </q-badge>
              </q-td>
              <q-td key="sy_insured" :props="props">
                {{ props.row.sy_insured }}
              </q-td>
              <q-td key="batch_insured" :props="props">
                {{ props.row.batch_insured }}
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </q-card>
  </div>

  <!-- Scholar Contract Details  -->

  <q-dialog v-model="showContractDetails" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconScript :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">VIEW</span> CONTRACT
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <div class="q-mb-sm text-h5 primary-text text-bold">
          Contract Details
        </div>
        <div class="text-subtitle1 primary-text">
          Contract Status:
          <text class="on-surface-text text-bold">{{ contractStats }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Availed Award:
          <text class="on-surface-text text-bold">{{ avail }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Other Scholarship:
          <text class="on-surface-text text-bold">{{ otherScholarship }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Duration:
          <text class="on-surface-text text-bold">{{ duration }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          ETG Month:
          <text class="on-surface-text text-bold">{{ etgMonth }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          ETG:
          <text class="on-surface-text text-bold">{{ etg }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Scholar Deferred Before:
          <text class="on-surface-text">{{}}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          School:
          <text class="on-surface-text text-bold">{{ school }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Course:
          <text class="on-surface-text text-bold">{{ course }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          School Year Availed:
          <text class="on-surface-text text-bold">{{ scYearAvail }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Term Type Availed:
          <text class="on-surface-text text-bold">{{ termType }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Term Availed:
          <text class="on-surface-text">{{}}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Created By:
          <text class="on-surface-text text-bold">{{ created }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Updated By:
          <text class="on-surface-text text-bold">{{ update }}</text>
        </div>
        <div class="text-subtitle1 primary-text">
          Verified By:
          <text class="on-surface-text text-bold">{{ verified }}</text>
        </div>
      </q-card-section>

      <q-separator />
    </q-card>
  </q-dialog>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconScript } from "@tabler/icons-vue";

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
const showContractDetails = ref(false);

const contractStats = ref();
const avail = ref();
const otherScholarship = ref();
const duration = ref();
const etgMonth = ref();
const etg = ref();
const scdefbef = ref();
const school = ref();
const course = ref();
const scYearAvail = ref();
const termType = ref();
const termAvail = ref();
const created = ref();
const update = ref();
const verified = ref();

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
    name: "yr_awarded",
    required: true,
    label: "Year Awarded",
    align: "left",
    field: "yr_awarded",
    sortable: true,
  },
  {
    name: "program",
    align: "left",
    label: "Program",
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
    name: "duration",
    align: "left",
    label: "Duration",
    field: "duration",
    sortable: true,
  },
  {
    name: "remarks",
    align: "left",
    label: "Remarks",
    field: "remarks",
    sortable: true,
  },
  {
    name: "reply_slip",
    align: "left",
    label: "Reply Slip",
    field: "reply_slip",
    sortable: true,
  },
  {
    name: "contract_status",
    align: "left",
    label: "Contract",
    field: "contract_status",
    sortable: true,
  },
  {
    name: "sy_insured",
    align: "left",
    label: "SY Insured",
    field: "sy_insured",
    sortable: true,
  },
  {
    name: "batch_insured",
    align: "left",
    label: "Batch insured",
    field: "batch_insured",
    sortable: true,
  },
];

// Read Scholars
const id = ref();
onMounted(() => {
  readscholarinfo();
});

const readscholarinfo = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readScholarInfoID", formData).then((response) => {
    rows.value = response.data;
  });

  axios.post("/read.php?readSCID", formData).then((response) => {
    contractStats.value = response.data.contract_status;
    avail.value = response.data.avail_award;
    otherScholarship.value = response.data.other_schp;
    duration.value = response.data.duration;

    etgMonth.value = response.data.etg_month;
    etg.value = response.data.etg;
    school.value = response.data.schools;
    course.value = response.data.course;
    scYearAvail.value = response.data.sy;
    termType.value = response.data.term_type;
    created.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;
  });
};

const showContractStats = () => {
  showContractDetails.value = true;
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
