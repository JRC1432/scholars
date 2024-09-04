<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        <IconTool :size="30" stroke-width="2" />
        Monitoring Sheet
      </div>

      <q-card-section>
        <q-banner inline-actions class="banner rounded-borders-10">
          <template v-slot:avatar>
            <q-icon name="error" color="negative" />
          </template>

          No Records Found
        </q-banner>
      </q-card-section>
      <q-card-actions class="row fit justify-start q-pt-xs">
        <q-btn
          rounded
          outline
          label="Add Enrollment Info"
          style="color: goldenrod"
          @click="openEnrollment"
        />
      </q-card-actions>
    </q-card>
  </div>

  <q-dialog
    v-model="showEnrollment"
    persistent
    v-if="state.termRec === 'Add New Term Record'"
  >
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="UpReplyForm" @submit.prevent.stop="UpdateReplyNow">
        <q-toolbar>
          <IconClipboardPlus :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">Add</span>
            Enrollment Info
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">Term Record:</span>
            <q-select
              ref="reftermRec"
              :options="termRecoptions"
              v-model="state.termRec"
              emit-value
              name="termRec"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
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
              mask="#### - ####"
              clearable
              :options="syOptions"
              @filter="filtersy"
              v-model="state.sy"
              name="sy"
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term Type</span>
            <q-select
              ref="reftermtype"
              :options="termTypeOptions"
              v-model="state.termtype"
              name="termtype"
              outlined
              dense
              hide-bottom-space
              emit-value
              use-input
              map-options
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term</span>
            <q-select
              ref="refterm"
              :options="computedTermOptions"
              v-model="state.term"
              emit-value
              name="term"
              outlined
              dense
              use-input
              map-options
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>

          <div class="q-px-sm">
            <span class="text-bold">Term is Required as per curriculum?</span>
            <q-toggle
              :label="newcurriculum"
              v-model="newcurriculum"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="newcurriculum"
            />
          </div>
        </q-card-section>
        <q-card-actions class="row fit justify-center q-pt-xs">
          <q-btn
            outline
            label="Continue"
            style="color: goldenrod"
            @click="addNavEnroll"
          />
          <q-btn outline label="Reset" style="color: goldenrod" />
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <q-dialog v-model="showEnrollment" persistent v-else>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="UpReplyForm" @submit.prevent.stop="UpdateReplyNow">
        <q-toolbar>
          <IconClipboardPlus :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">Add</span>
            Enrollment Info
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">Term Record:</span>
            <q-select
              ref="reftermRec"
              :options="termRecoptions"
              v-model="state.termRec"
              emit-value
              name="termRec"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term is Required as per curriculum?</span>
            <q-toggle
              :label="curriculum"
              v-model="curriculum"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="curriculum"
            />
          </div>
        </q-card-section>
        <q-card-actions class="row fit justify-center q-pt-xs">
          <q-btn
            outline
            label="Continue"
            style="color: goldenrod"
            @click="navEnroll"
          />
          <q-btn outline label="Reset" style="color: goldenrod" />
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";

import { ref, onMounted, reactive, computed, inject } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconTool, IconClipboardPlus } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Validations

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

// Modal

const showEnrollment = ref(false);

// Select Items

const termRecoptions = ref([]);

const syList = ref();
const nameList = ref();
const curriculum = ref("NO");
const newcurriculum = ref("NO");

// Variables

const reftermRec = ref(null);

const state = reactive({
  termRec: "Add New Term Record",
  sy: "",
  termtype: "",
  term: "",
  term1: "",
  term2: "",
});

// Axios
onMounted(() => {
  populateAll();
});

var syOptions2 = [];
const syOptions = ref(syOptions2);
const globalSPAS = ref();
const populateAll = () => {
  globalSPAS.value = route.params.id;
  var formData = new FormData();
  formData.append("id", globalSPAS.value);

  // Select Term Record
  axios.post("/read.php?readTermRec", formData).then((response) => {
    // Separation of value in sql select

    const processedData = response.data.map((item) => {
      const [sy, ...nameParts] = item.value.split(" ");
      const name = nameParts.join(" ");
      return {
        label: item.label,
        sy,
        name,
      };
    });

    termRecoptions.value = processedData;
    syList.value = processedData.map((item) => item.sy);
    nameList.value = processedData.map((item) => item.name);
  });
  axios.get("/read.php?school_years").then((response) => {
    syOptions2 = response.data;
  });
};

// School Year Filters

const filtersy = (val, update) => {
  if (val === "") {
    update(() => {
      syOptions.value = syOptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    syOptions.value = syOptions2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// TermType
const termTypeOptions = [
  { label: "Semestral", value: "2", color: "primary" },
  { label: "Trimestral", value: "3", color: "primary" },
  { label: "Quarterly", value: "4", color: "primary" },
];

const termOptions = {
  2: [
    { label: "1st", value: "1", color: "primary" },
    { label: "2nd", value: "2", color: "primary" },
    { label: "Summer", value: "3", color: "primary" },
    { label: "Midyear", value: "4", color: "primary" },
  ],
  3: [
    { label: "1st", value: "1", color: "primary" },
    { label: "2nd", value: "2", color: "primary" },
    { label: "3rd", value: "3", color: "primary" },
    { label: "Summer", value: "4", color: "primary" },
  ],
  4: [
    { label: "1st", value: "1", color: "primary" },
    { label: "2nd", value: "2", color: "primary" },
    { label: "3rd", value: "3", color: "primary" },
    { label: "4th", value: "4", color: "primary" },
    { label: "Summer", value: "5", color: "primary" },
  ],
};

const computedTermOptions = computed(() => {
  return termOptions[state.termtype] || [];
});

const openEnrollment = () => {
  showEnrollment.value = true;
};

const navEnroll = () => {
  router.push(`/enrollmentinfo/${globalSPAS.value}`);

  sessionStorage.setItem("syList", JSON.stringify(syList.value[0] || ""));
  sessionStorage.setItem("nameList", JSON.stringify(nameList.value[0] || ""));
  sessionStorage.setItem("curriculum", JSON.stringify(curriculum.value));
};

const addNavEnroll = () => {
  router.push(`/newenrollmentinfo/${globalSPAS.value}`);

  sessionStorage.setItem("sy", JSON.stringify(state.sy));
  sessionStorage.setItem("termtype", JSON.stringify(state.termtype));
  sessionStorage.setItem("term", JSON.stringify(state.term));
  sessionStorage.setItem("term1", JSON.stringify(state.term1));
  sessionStorage.setItem("term2", JSON.stringify(state.term2));
  sessionStorage.setItem("newcurriculum", JSON.stringify(newcurriculum.value));
};
</script>
