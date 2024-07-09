<template>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 q-pa-sm">
      <q-card class="my-card text-black rounded-borders-20 q-mr-sm">
        <q-table
          :rows="rows"
          :columns="columns"
          row-key="name"
          :filter="filter"
          v-model:pagination="pagination"
          class="no-border"
          wrap-cells
          flat
          bordered
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
              <q-td key="sy" :props="props">
                {{ props.row.sy }}
              </q-td>

              <q-td key="name" :props="props">
                {{ props.row.name }}
              </q-td>
              <q-td key="schoolcourse" :props="props" style="cursor: pointer">
                <ul style="text-decoration: underline" @click="openSC(props)">
                  {{
                    props.row.schoolcourse
                  }}
                </ul>
              </q-td>
              <q-td key="pstart" :props="props">
                <ul
                  style="text-decoration: underline; cursor: pointer"
                  @click="openpstart(props)"
                >
                  {{
                    props.row.pstart
                  }}
                </ul>
              </q-td>
              <q-td key="sstanding" :props="props">
                <ul
                  style="text-decoration: underline; cursor: pointer"
                  @click="opensstanding(props)"
                >
                  {{
                    props.row.sstanding
                  }}
                </ul>
              </q-td>
              <q-td key="pend" :props="props">
                <ul
                  style="text-decoration: underline; cursor: pointer"
                  @click="openpend(props)"
                >
                  {{
                    props.row.pend
                  }}
                </ul>
              </q-td>
              <q-td key="send" :props="props">
                <ul
                  style="text-decoration: underline; cursor: pointer"
                  @click="opensend(props)"
                >
                  {{
                    props.row.send
                  }}
                </ul>
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-4 q-pa-sm">
      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        full-width
        v-if="viewcourse"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              COURSE
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ sy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ term }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">School:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ school }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Course:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ course }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ create }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ update }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ verified }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    created_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    updated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>

      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="pstart"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              Start Status
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ pstartSy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartTerm
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="pstartSE === 1">
                  <text class="on-surface-text text-bold">START</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">END</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Progress Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartProgress
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartCreate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartVerified
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>

      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="standstart"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              Start Term
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermsy
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermterm
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="startTermStrEnd === 1">
                  <text class="on-surface-text text-bold">START</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">END</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Standing:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermStand
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Monitoring Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermMonitor
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermCreated
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermVerified_by
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>
      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="pend"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              Status End
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ pendSy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ pendTerm }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="pendSE === 2">
                  <text class="on-surface-text text-bold">END</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">START</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Progress Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendProgress
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendCreate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendVerified
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>

      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="standend"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              End Term
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ endTermsy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermterm
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="endTermStrEnd === 2">
                  <text class="on-surface-text text-bold">END</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">START</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Standing:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermStand
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Monitoring Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermMonitor
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermCreated
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermVerified_by
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>
      <q-card class="my-q-card rounded-borders-20" flat bordered v-else>
        <Vue3Lottie
          animationLink="https://lottie.host/3a3a54dc-d976-46fd-9610-70caf9191c05/QMrukbOnfT.json"
          style="height: calc(30vh)"
          :height="500"
          :width="500"
        />
      </q-card>
    </div>
  </div>
</template>

<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconCertificate, IconProgress } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const rows = ref([]);
const filter = ref("");
const pagination = ref({
  rowsPerPage: 5,
});

// Cards trigger
const viewcourse = ref(false);
const pstart = ref(false);
const standstart = ref(false);
const pend = ref(false);
const standend = ref(false);

// View Course Variables

const sy = ref();
const term = ref();
const school = ref();
const course = ref();
const create = ref();
const update = ref();
const verified = ref();
const created_at = ref();
const updated_at = ref();

// View progress Status

const pstartSy = ref();
const pstartTerm = ref();
const pstartSE = ref();
const pstartProgress = ref();
const pstartCreate = ref();
const pstartUpdate = ref();
const pstartVerified = ref();
const pstartCreated_at = ref();
const pstartUpdated_at = ref();

// View progress End

const pendSy = ref();
const pendTerm = ref();
const pendSE = ref();
const pendProgress = ref();
const pendCreate = ref();
const pendUpdate = ref();
const pendVerified = ref();
const pendCreated_at = ref();
const pendUpdated_at = ref();

// View Start Term Standing

const startTermsy = ref();
const startTermterm = ref();
const startTermStrEnd = ref();
const startTermStand = ref();
const startTermMonitor = ref();
const startTermCreated = ref();
const startTermUpdate = ref();
const startTermVerified_by = ref();
const startTermCreated_at = ref();
const startTermUpdated_at = ref();

// View End Term Standing

const endTermsy = ref();
const endTermterm = ref();
const endTermStrEnd = ref();
const endTermStand = ref();
const endTermMonitor = ref();
const endTermCreated = ref();
const endTermUpdate = ref();
const endTermVerified_by = ref();
const endTermCreated_at = ref();
const endTermUpdated_at = ref();

const columns = [
  {
    name: "sy",
    required: true,
    label: "School Year",
    align: "center",
    field: "sy",
    sortable: true,
  },

  {
    name: "name",
    required: true,
    label: "Term",
    align: "center",
    field: "name",
    sortable: true,
  },
  {
    name: "schoolcourse",
    align: "center",
    label: "School & Course",
    field: "schoolcourse",
    sortable: true,
  },
  {
    name: "pstart",
    align: "left",
    label: "Progress Status (START)",
    field: "pstart",
    sortable: true,
  },

  {
    name: "sstanding",
    align: "left",
    label: "Start of Term Standing",
    field: "sstanding",
    sortable: true,
  },

  {
    name: "pend",
    align: "left",
    label: "Progress Status (END)",
    field: "pend",
    sortable: true,
  },

  {
    name: "send",
    align: "left",
    label: "End of Term Standing",
    field: "send",
    sortable: true,
  },
];

// Read History Records
const id = ref();
onMounted(() => {
  readHistoryRec();
});

const readHistoryRec = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?historyRecID", formData).then((response) => {
    rows.value = response.data;
  });
};

// Read School/Course

const openSC = () => {
  viewcourse.value = !viewcourse.value;
  pstart.value = false;
  standstart.value = false;
  pend.value = false;
  standend.value = false;

  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);

  axios.post("/read.php?viewCourseID", formData).then((response) => {
    sy.value = response.data.sy_start;
    term.value = response.data.term_start;
    school.value = response.data.school;
    course.value = response.data.course;
    create.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;
    created_at.value = response.data.created_at;
    updated_at.value = response.data.updated_at;
  });
};

// Prgress Status Start

const openpstart = (props) => {
  pstart.value = !pstart.value;
  viewcourse.value = false;
  standstart.value = false;
  pend.value = false;
  standend.value = false;

  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  formData.append("termstanding", props.row.term);
  formData.append("progress", props.row.pstart);

  axios.post("/read.php?viewStartStatID", formData).then((response) => {
    pstartSy.value = response.data.sy_start;
    pstartTerm.value = response.data.name;
    pstartSE.value = response.data.start_end;
    pstartProgress.value = response.data.progress_status;
    pstartCreate.value = response.data.created_by;
    pstartUpdate.value = response.data.updated_by;
    pstartVerified.value = response.data.verified_by;
    pstartCreated_at.value = response.data.created_at;
    pstartUpdated_at.value = response.data.updated_at;
  });
};

// Start of Term Standing

const opensstanding = (props) => {
  standstart.value = !standstart.value;
  viewcourse.value = false;
  pstart.value = false;
  pend.value = false;
  standend.value = false;

  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  formData.append("progress", props.row.pstart);
  axios.post("/read.php?viewSTRTStandID", formData).then((response) => {
    console.log(response.data);
    startTermsy.value = response.data.sy_start;
    startTermterm.value = response.data.name;
    startTermStrEnd.value = response.data.start_end;
    startTermStand.value = response.data.standing;
    startTermMonitor.value = response.data.list_name;
    startTermCreated.value = response.data.created_by;
    startTermUpdate.value = response.data.updated_by;
    startTermVerified_by.value = response.data.verified_by;
    startTermCreated_at.value = response.data.created_at;
    startTermUpdated_at.value = response.data.updated_at;
  });
};

const openpend = (props) => {
  pend.value = !pend.value;
  viewcourse.value = false;
  pstart.value = false;
  standstart.value = false;
  standend.value = false;

  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  formData.append("termstanding", props.row.term);
  formData.append("progress", props.row.pstart);

  axios.post("/read.php?viewEndID", formData).then((response) => {
    pendSy.value = response.data.sy_start;
    pendTerm.value = response.data.name;
    pendSE.value = response.data.start_end;
    pendProgress.value = response.data.progress_status;
    pendCreate.value = response.data.created_by;
    pendUpdate.value = response.data.updated_by;
    pendVerified.value = response.data.verified_by;
    pendCreated_at.value = response.data.created_at;
    pendUpdated_at.value = response.data.updated_at;
  });
};

const opensend = (props) => {
  standend.value = !standend.value;
  viewcourse.value = false;
  pstart.value = false;
  standstart.value = false;
  pend.value = false;

  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  formData.append("progress", props.row.pstart);
  axios.post("/read.php?viewENDStandID", formData).then((response) => {
    console.log(response.data);
    endTermsy.value = response.data.sy_start;
    endTermterm.value = response.data.name;
    endTermStrEnd.value = response.data.start_end;
    endTermStand.value = response.data.standing;
    endTermMonitor.value = response.data.list_name;
    endTermCreated.value = response.data.created_by;
    endTermUpdate.value = response.data.updated_by;
    endTermVerified_by.value = response.data.verified_by;
    endTermCreated_at.value = response.data.created_at;
    endTermUpdated_at.value = response.data.updated_at;
  });
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
