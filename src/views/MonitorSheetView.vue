<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Monitoring Sheet
      </div>
      <q-card-section> </q-card-section>

      <q-card-section v-if="grades === false">
        <q-banner dense class="rounded-borders-20 banner">
          <template v-slot:avatar>
            <q-icon name="error" color="negative" size="40px" />
          </template>
          <text class="text-h6"> No Records Found !!!</text>
          <template v-slot:action>
            <q-btn
              rounded
              outline
              style="color: goldenrod"
              @click="openEnrollment"
              label="Add New Enrollment Information"
            />
          </template>
        </q-banner>
      </q-card-section>

      <q-card-section v-else>
        <ShowGrades />
        <q-btn
          rounded
          outline
          style="color: goldenrod"
          @click="openEnrollment"
          label="Add New Enrollment Information"
        />
      </q-card-section>
    </q-card>
  </div>

  <q-dialog v-model="showAddEnrollment" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="addNavEnrollForm" @submit.prevent.stop="addNavEnroll">
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
            <span class="text-bold">School Year</span>
            <q-select
              ref="refsy"
              :options="syOptions"
              @filter="filtersy"
              v-model="state.sy"
              name="sy"
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
            type="submit"
          />
          <q-btn outline label="Reset" style="color: goldenrod" />
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <q-dialog v-model="showEnrollment" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconClipboardPlus :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">Enrollment</span>
          Info
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>
      <q-card-section
        ><div class="q-px-sm">
          <span class="text-bold">Term Record:</span>
          <q-select
            ref="refselectTerm"
            name="selectTerm"
            :options="options"
            v-model="state.selectTerm"
            emit-value
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
            @update:model-value="newTermRec"
          /></div
      ></q-card-section>
    </q-card>
  </q-dialog>

  <q-dialog v-model="showExistEnrollment" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="addOldTermRecForm" @submit.prevent.stop="addOldTermRec">
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
              v-model="state.termwthRec"
              name="termwthRec"
              emit-value
              map-options
              use-input
              input-debounce="0"
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
              name="curriculum"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
        </q-card-section>
        <q-card-actions class="row fit justify-center q-pt-xs">
          <q-btn
            outline
            label="Continue"
            style="color: goldenrod"
            type="submit"
          />
          <q-btn outline label="Reset" style="color: goldenrod" />
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import ShowGrades from "../components/ShowGrades.vue";

import { ref, onMounted, reactive, computed, inject } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconTool, IconClipboardPlus, IconFilesOff } from "@tabler/icons-vue";

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

const showAddEnrollment = ref(false);
const showExistEnrollment = ref(false);
const showEnrollment = ref(false);

// Select Items

const termRecoptions = ref([]);

const syList = ref();
const nameList = ref();
const curriculum = ref("NO");
const newcurriculum = ref("NO");

// Variables

const reftermRec = ref(null);
const refsy = ref(null);
const reftermtype = ref(null);
const refterm = ref(null);
const grades = ref();

const state = reactive({
  termRec: "",
  sy: "",
  termtype: "",
  term: "",
  term1: "",
  term2: "",
  termwthRec: "",
  selectTerm: "Select Item Here....",
});

// Axios
onMounted(() => {
  populateAll();
});

var syOptions2 = [];
const syOptions = ref(syOptions2);
const spas_result = ref();
const globalSPAS = route.params.id;

const populateAll = () => {
  var formData = new FormData();
  formData.append("id", globalSPAS);

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

    // Add "Add New Term Rec" option
    //   const addNewOption = {
    // label: "Add New Term Record",
    //    sy: "", // You can set this to a specific value if needed
    //    name: "", // You can set this to a specific value if needed
    //  };
    //  processedData.push(addNewOption);

    termRecoptions.value = processedData;
    syList.value = processedData.map((item) => item.sy);
    nameList.value = processedData.map((item) => item.name);
  });

  axios.get("/read.php?school_years").then((response) => {
    syOptions2 = response.data;
  });

  axios.post("/read.php?checkMonitor", formData).then((response) => {
    grades.value = response.data.exists;
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

const options = ["Add New Term Record", "Select Terms"];

const openEnrollment = () => {
  showEnrollment.value = true;
};

const addNavEnroll = () => {
  showAddEnrollment.value = false;
  refsy.value.validate();
  reftermtype.value.validate();
  refterm.value.validate();

  if (
    refsy.value.hasError ||
    reftermtype.value.hasError ||
    refterm.value.hasError
  ) {
    $q.notify({
      type: "negative",
      message: "Please Complete All The Selection",
    });
  } else {
    showEnrollment.value = false;

    var formData = new FormData(document.getElementById("addNavEnrollForm"));
    formData.append("spasid", globalSPAS);
    formData.append("user", user.username);
    formData.append("newcurriculum", newcurriculum.value);

    Swal.fire({
      title:
        "You are about to create a new Term Record. Do you want to proceed?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Proceed",
      denyButtonText: `Don't Proceed`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post("/create.php?newTermRecord", formData)
          .then(function (response) {
            if (response.data == true) {
              router.push(`/newenrollmentinfo/${globalSPAS}`);
              sessionStorage.setItem("sy", JSON.stringify(state.sy));
              sessionStorage.setItem(
                "termtype",
                JSON.stringify(state.termtype)
              );
              sessionStorage.setItem("term", JSON.stringify(state.term));
              sessionStorage.setItem("term1", JSON.stringify(state.term1));
              sessionStorage.setItem("term2", JSON.stringify(state.term2));
              sessionStorage.setItem(
                "newcurriculum",
                JSON.stringify(newcurriculum.value)
              );
              $q.notify({
                color: "positive",
                textColor: "white",
                message: "New Term Record Created Successfully",
              });
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to create new Term Record",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

const addOldTermRec = () => {
  router.push(`/enrollmentinfo/${globalSPAS}`);
  sessionStorage.setItem("termwthRec", JSON.stringify(state.termwthRec));
  sessionStorage.setItem("curriculum", JSON.stringify(curriculum.value));
};

const newTermRec = () => {
  if (state.selectTerm === "Add New Term Record") {
    showAddEnrollment.value = true;
    showEnrollment.value = false;
  } else {
    showExistEnrollment.value = true;
    showEnrollment.value = false;
  }
};
</script>
