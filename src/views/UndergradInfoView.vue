<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Undergraduate Records
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

          <template v-slot:top-left>
            <q-btn
              style="color: goldenrod"
              outline
              rounded
              icon="add"
              @click="newUndergrad"
              >New Undergraduate Record</q-btn
            >
          </template>

          <template v-slot:body="props">
            <q-tr :prop="props">
              <q-td key="spas_id" :props="props">
                {{ props.row.spas_id }}
              </q-td>
              <q-td key="course" :props="props">
                {{ props.row.course }}
              </q-td>
              <q-td key="discipline" :props="props">
                {{ props.row.discipline }}
              </q-td>
              <q-td key="schools" :props="props">
                {{ props.row.schools }}
              </q-td>
              <q-td key="sy_start" :props="props">
                {{ props.row.sy_start }}
              </q-td>
              <q-td key="term_start" :props="props">
                <template v-if="props.row.term_type === 2">
                  <template v-if="props.row.term_start == 1">1st</template>
                  <template v-else-if="props.row.term_start == 2">2nd</template>
                  <template v-else-if="props.row.term_start == 3"
                    >Summer</template
                  >
                  <template v-else>--</template>
                </template>

                <template v-else-if="props.row.term_type === 3">
                  <template v-if="props.row.term_start == 1">1st</template>
                  <template v-else-if="props.row.term_start == 2">2nd</template>
                  <template v-else-if="props.row.term_start == 3">3rd</template>
                  <template v-else-if="props.row.term_start == 4"
                    >Summer</template
                  >
                  <template v-else>--</template>
                </template>
                <template v-else-if="props.row.term_type === 4">
                  <template v-if="props.row.term_start == 1">1st</template>
                  <template v-else-if="props.row.term_start == 2">2nd</template>
                  <template v-else-if="props.row.term_start == 3">3rd</template>
                  <template v-else-if="props.row.term_start == 4">4th</template>
                  <template v-else>--</template>
                </template>
              </q-td>

              <!-- Custom cell for term_type_name -->

              <q-td key="term_type" :props="props">
                <template v-if="props.row.term_type == 2">Semestral</template>
                <template v-else-if="props.row.term_type == 3"
                  >Trimestral</template
                >
                <template v-else-if="props.row.term_type == 4"
                  >Quarterly</template
                >
                <template v-else>--</template>
              </q-td>

              <q-td key="latest_flag" :props="props">
                <template v-if="props.row.latest_flag === 1"> Yes </template>
                <template v-else-if="props.row.latest_flag === 0">
                  No
                </template>
                <template v-else> -- </template>
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </q-card>
  </div>

  <q-dialog v-model="showUndegrad" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="UpReplyForm" @submit.prevent.stop="UpdateReplyNow">
        <q-toolbar>
          <IconClipboardText :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">NEW</span>
            UNDERGRADUATE RECORDS
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">SPAS ID:</span>
            <q-select
              ref="refspasid"
              :options="spasoptions"
              v-model="state.spasid"
              emit-value
              name="spasid"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">School</span>

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
              v-model="state.school"
              name="school"
              :options="schooloptions"
              @filter="filterschool"
              :rules="[myRule]"
              clearable
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Courses</span>

            <q-select
              ref="refcourses"
              outlined
              dense
              hide-bottom-space
              behavior="menu"
              emit-value
              map-options
              use-input
              input-debounce="0"
              v-model="state.courses"
              name="courses"
              :options="courseoptions"
              @filter="filtercourse"
              :rules="[myRule]"
              clearable
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">School Year</span>

            <q-select
              ref="refsy"
              outlined
              dense
              hide-bottom-space
              behavior="menu"
              emit-value
              map-options
              use-input
              input-debounce="0"
              v-model="state.sy"
              name="sy"
              :options="syoptions"
              @filter="filtersy"
              :rules="[myRule]"
              mask="#### - ####"
              clearable
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term Type</span>
            <q-select
              ref="reftermtype"
              :options="termTypeOptions"
              v-model="state.termtype"
              emit-value
              name="termtype"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term</span>
            <q-select
              ref="refterm"
              :options="termoptions"
              v-model="state.term"
              emit-value
              name="term"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>
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

const showUndegrad = ref(false);

// Validations

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

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
    name: "course",
    required: true,
    label: "Course",
    align: "left",
    field: "course",
    sortable: true,
  },

  {
    name: "discipline",
    required: true,
    label: "Discipline",
    align: "left",
    field: "discipline",
    sortable: true,
  },
  {
    name: "schools",
    align: "left",
    label: "School",
    field: "schools",
    sortable: true,
  },
  {
    name: "sy_start",
    align: "left",
    label: "School Year",
    field: "sy_start",
    sortable: true,
  },

  {
    name: "term_start",
    align: "left",
    label: "Term",
    field: "term_start",
    sortable: true,
  },

  {
    name: "term_type",
    align: "left",
    label: "Type",
    field: "term_type",
    sortable: true,
  },

  {
    name: "latest_flag",
    align: "left",
    label: "Current",
    field: "latest_flag",
    sortable: true,
  },
];

// Read UnderGrad

const spasoptions = ref();
const spasid = ref();
var schooloptions2 = [];
const schooloptions = ref(schooloptions2);
var courseoptions2 = [];
const courseoptions = ref(courseoptions2);
var syoptions2 = [];
const syoptions = ref(syoptions2);

onMounted(() => {
  populateAll();
});

const populateAll = () => {
  spasid.value = route.params.id;
  var formData = new FormData();
  formData.append("id", spasid.value);

  // Read Undergrad Records
  axios.post("/read.php?readUndergradID", formData).then((response) => {
    rows.value = response.data;
  });

  // Select SPASID
  axios.post("/read.php?spasid", formData).then((response) => {
    spasoptions.value = response.data;
  });

  // Select School

  axios.get("/read.php?school").then((response) => {
    schooloptions2 = response.data;
  });

  // Select Courses
  axios.get("/read.php?courses").then((response) => {
    courseoptions2 = response.data;
  });

  // Select School Year
  axios.get("/read.php?school_years").then((response) => {
    syoptions2 = response.data;
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

// Course Filters

const filtercourse = (val, update) => {
  if (val === "") {
    update(() => {
      courseoptions.value = courseoptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    courseoptions.value = courseoptions2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// School Year Filters

const filtersy = (val, update) => {
  if (val === "") {
    update(() => {
      syoptions.value = syoptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    syoptions.value = syoptions2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// TermType
const termTypeOptions = [
  { label: "Semestral", value: "Semestral", color: "primary" },
  { label: "Trimestral", value: "Trimestral", color: "primary" },
  { label: "Quarterly", value: "Quarterly", color: "primary" },
];

const newUndergrad = () => {
  showUndegrad.value = true;
};
</script>
