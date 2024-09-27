<template>
  <div class="q-mb-md q-px-lg">
    <q-btn
      color="primary"
      icon="reply"
      label="BACK"
      rounded
      flat
      @click="backBtn"
    />
  </div>
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <q-card-section
        ><div class="q-pa-md text-center">
          <q-banner
            inline-actions
            rounded
            class="text-bold banner rounded-borders-20"
          >
            <div class="text-h3">
              <IconFileCertificate :size="40" stroke-width="2" />
              ADD ENROLLMENT INFORMATION
            </div>
          </q-banner>
        </div></q-card-section
      >
      <q-card-section>
        <q-page class="q-pa-md">
          <q-card class="q-pa-md rounded-borders-20 banner-5">
            <q-card-section>
              <div class="col-12">
                <div class="q-col-gutter-md row items-start">
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="text-h6">SY: {{ newsy }}</div>
                    <div class="text-h6">Term: {{ getTermLabel }}</div>
                    <div class="text-h6">
                      Term Required: {{ newcurriculum }}
                    </div>
                    <div>
                      <div class="q-pa-xs q-gutter-sm">
                        <q-btn
                          color="warning"
                          label="Print"
                          icon="print"
                          rounded
                          @click="printGrades"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-8">
                    <div class="text-h6">
                      <span class="text-h6">School & Course Record</span>
                      <q-select
                        ref="refscrTerm"
                        :options="scrTermoptions"
                        v-model="state.scrTerm"
                        emit-value
                        name="scrTerm"
                        outlined
                        dense
                        hide-bottom-space
                        :rules="[myRule]"
                      />
                      <div class="row q-pa-md q-gutter-sm">
                        <span class="text-h6">Status (Start of Sem):</span>
                        <q-select
                          v-model="state.stat1"
                          name="stat1"
                          outlined
                          dense
                          hide-bottom-space
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          :options="stat1options"
                          @filter="filterstat1"
                          clearable
                        />
                        <q-select
                          v-model="state.stat2"
                          name="stat2"
                          outlined
                          dense
                          hide-bottom-space
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          :options="stat2options"
                          @filter="filterstat2"
                          clearable
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-3 col-md-1">
                    <!-- <div class="float-right"> -->
                    <span class="text-bold primary-text">Latest?</span>
                    <q-toggle v-model="toggle" />
                    <!-- </div> -->
                  </div>
                </div>
              </div>
            </q-card-section>

            <q-separator inset />

            <q-card-section>
              <q-form @submit.prevent="addTodo">
                <div class="col-12">
                  <div class="q-col-gutter-md row items-start">
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">SUBJECT CODE:</span>
                      <q-input
                        v-model="scode"
                        filled
                        :rules="[(val) => !!val || 'Subject code is required']"
                      />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">ACADEMIC:</span>
                      <q-checkbox
                        v-model="academic"
                        label="Include in computation?"
                        filled
                      />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">UNITS:</span>
                      <q-input
                        v-model="units"
                        filled
                        :rules="[(val) => !!val || 'Unit is required']"
                        mask="##.##"
                      />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">GRADE:</span>
                      <q-input
                        v-model="grade"
                        filled
                        :rules="[(val) => !!val || 'Grade is required']"
                        mask="#.##"
                      />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">COMPLETION:</span>
                      <q-input
                        v-model="completion"
                        filled
                        :rules="[(val) => !!val || 'Completion is required']"
                      />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">REMARKS:</span>
                      <q-input
                        v-model="remarks"
                        filled
                        :rules="[(val) => !!val || 'Remarks is required']"
                      />
                    </div>
                  </div>
                </div>
                <q-btn
                  type="submit"
                  label="Add Subject"
                  color="primary"
                  class="q-mt-md"
                  rounded
                />
              </q-form>
            </q-card-section>

            <q-card-section>
              <q-scroll-area style="height: 300px">
                <q-table
                  :rows="todos"
                  :columns="columns"
                  row-key="id"
                  flat
                  bordered
                  separator="cell"
                  class="banner-5"
                >
                  <template v-slot:body-cell-scode="props">
                    <q-td :props="props">
                      <q-input v-model="props.row.scode" />
                    </q-td>
                  </template>

                  <template v-slot:body-cell-academic="props">
                    <q-td :props="props">
                      <q-checkbox v-model="props.row.academic" />
                    </q-td>
                  </template>

                  <template v-slot:body-cell-units="props">
                    <q-td :props="props">
                      <q-input v-model="props.row.units" mask="##.##" />
                    </q-td>
                  </template>

                  <template v-slot:body-cell-grade="props">
                    <q-td :props="props">
                      <q-input v-model="props.row.grade" mask="#.##" />
                    </q-td>
                  </template>

                  <template v-slot:body-cell-completion="props">
                    <q-td :props="props">
                      <q-input v-model="props.row.completion" />
                    </q-td>
                  </template>

                  <template v-slot:body-cell-remarks="props">
                    <q-td :props="props">
                      <q-input v-model="props.row.remarks" />
                    </q-td>
                  </template>

                  <template v-slot:body-cell-action="props">
                    <q-td :props="props">
                      <q-btn
                        flat
                        icon="delete"
                        color="negative"
                        @click="removeTodo(props.row.id)"
                      />
                    </q-td>
                  </template>
                </q-table>
              </q-scroll-area>
            </q-card-section>
            <q-card-section>
              <div class="q-pa-md">
                <div class="col-12">
                  <div class="q-col-gutter-md row items-start">
                    <div class="col-xs-12 col-sm-3 col-md-6">
                      <q-input
                        filled
                        v-model="computedTotalUnits"
                        label="Total Units:"
                        readonly
                      />
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-6">
                      <q-input
                        filled
                        v-model="computedGwa"
                        label="General Weighted Average:"
                        readonly
                      />
                    </div>
                  </div>
                </div>
              </div>
            </q-card-section>

            <q-card-actions align="around">
              <q-btn
                rounded
                style="width: 40%"
                color="primary"
                @click="saveGrades"
                >SAVE</q-btn
              >
              <q-btn
                rounded
                style="width: 40%"
                color="warning"
                @click="resetTodos"
              >
                RESET
              </q-btn>
            </q-card-actions>
          </q-card>
        </q-page>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, reactive, computed, onMounted, watch, inject } from "vue";
import router from "../router";
import { uid } from "quasar";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconClipboardPlus, IconFileCertificate } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const state = reactive({
  term: "",
  stat1: "",
  stat2: "",
  scrTerm: "",
});
const scode = ref("");
const academic = ref(false);
const units = ref("");
const grade = ref("");
const completion = ref("");
const remarks = ref("");

const toggle = ref("");

// Validations

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

const todos = ref([
  {
    id: uid(),
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
  {
    id: uid(),
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
  {
    id: uid(),
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
]);

const term_required = ref(0);

const addTodo = () => {
  if (
    scode.value &&
    units.value &&
    grade.value &&
    completion.value &&
    remarks.value
  ) {
    todos.value.push({
      id: uid(),
      scode: scode.value,
      academic: academic.value,
      units: parseFloat(units.value),
      grade: parseFloat(grade.value),
      completion: completion.value,
      remarks: remarks.value,
    });
    scode.value = "";
    academic.value = false;
    units.value = "";
    grade.value = "";
    completion.value = "";
    remarks.value = "";
  }
};

const removeTodo = (id) => {
  const index = todos.value.findIndex((todo) => todo.id === id);
  todos.value.splice(index, 1);
};

const resetTodos = () => {
  todos.value = [
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
  ];
};

const columns = [
  { name: "scode", label: "Subject Code", field: "scode", align: "left" },
  { name: "academic", label: "Academic", field: "academic", align: "center" },
  { name: "units", label: "Units", field: "units", align: "left" },
  { name: "grade", label: "Grade", field: "grade", align: "left" },
  {
    name: "completion",
    label: "Completion",
    field: "completion",
    align: "left",
  },
  { name: "remarks", label: "Remarks", field: "remarks", align: "left" },
  { name: "action", label: "Action", field: "action", align: "center" },
];

const computedTotalUnits = computed(() => {
  return todos.value
    .filter((todo) => todo.academic)
    .reduce((total, todo) => total + parseFloat(todo.units || 0), 0)
    .toFixed(3);
});

const computedGwa = computed(() => {
  const academicTodos = todos.value.filter((todo) => todo.academic);
  const totalUnits = academicTodos.reduce(
    (total, todo) => total + parseFloat(todo.units || 0),
    0
  );
  const totalGradePoints = academicTodos.reduce(
    (total, todo) =>
      total + parseFloat(todo.units || 0) * parseFloat(todo.grade || 0),
    0
  );
  return totalUnits > 0 ? (totalGradePoints / totalUnits).toFixed(3) : "0.000";
});

// Grades Info

// Select
var stat2options2 = [];
const stat2options = ref(stat2options2);
var stat1options2 = [];
const stat1options = ref(stat1options2);
const scrTermoptions = ref("Select");
// Storage
const newtermtype = ref(null);
const newsy = ref(null);
const newcurriculum = ref(null);
const newterm = ref(null);
const newterm1 = ref(null);
const newterm2 = ref(null);
// Othere Variable
const globalSPASid = route.params.id;

const create_termid = { value: "" };

onMounted(() => {
  populateEditGrades();
});

const populateEditGrades = () => {
  // console.log(toggle.value + "start");

  var formData = new FormData();
  formData.append("id", globalSPASid);
  axios.post("/read.php?readEditGrades", formData).then((response) => {
    // console.log(response.data);

    toggle.value = response.data.latest_flag == 1 ? true : false;
  });

  axios.get("/read.php?readstat2").then((response) => {
    stat2options2 = response.data;
  });

  axios.get("/read.php?readstat1").then((response) => {
    stat1options2 = response.data;
  });

  axios.post("/read.php?readAddSC", formData).then((response) => {
    scrTermoptions.value = response.data;
  });

  // Storage

  const storedNewCurriculum = sessionStorage.getItem("newcurriculum");
  const storedSy = sessionStorage.getItem("sy");
  const storedtermtype = sessionStorage.getItem("termtype");
  const storedterm = sessionStorage.getItem("term");
  const storedterm1 = sessionStorage.getItem("term1");
  const storedterm2 = sessionStorage.getItem("term2");

  if (storedNewCurriculum) {
    newcurriculum.value = JSON.parse(storedNewCurriculum);
  }
  if (storedSy) {
    newsy.value = JSON.parse(storedSy);
  }
  if (storedtermtype) {
    newtermtype.value = JSON.parse(storedtermtype);
  }
  if (storedterm) {
    newterm.value = JSON.parse(storedterm);
  }
  if (storedterm1) {
    newterm1.value = JSON.parse(storedterm1);
  }
  if (storedterm2) {
    newterm2.value = JSON.parse(storedterm2);
  }
  create_termid.value =
    String(globalSPASid) +
    String(newsy.value) +
    String(newterm.value) +
    String(newtermtype.value);
};
console.log(create_termid);

// Transform to Terms

const getTermLabel = computed(() => {
  const termValue = Math.max(newterm.value, newterm1.value, newterm2.value);

  switch (termValue) {
    case 1:
      return "1st Term";
    case 2:
      return "2nd Term";
    case 3:
      return "3rd Term";
    case 4:
      return "4th Term";
    default:
      return "5th Term";
  }
});

// Select Term

const filterstat2 = (val, update) => {
  if (val === "") {
    update(() => {
      stat2options.value = stat2options2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    stat2options.value = stat2options2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Select Term

const filterstat1 = (val, update) => {
  if (val === "") {
    update(() => {
      stat1options.value = stat1options2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    stat1options.value = stat1options2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Export PDF Grades

const printGrades = () => {
  alert("Please click OK to print PDF");

  var formData = new FormData();

  formData.append("id", globalSPASid);
  formData.append("grades", JSON.stringify(todos.value));

  // From Storage

  formData.append("newsy", newsy.value);
  formData.append("newterm", newterm.value);
  formData.append("newterm1", newterm1.value);
  formData.append("newterm2", newterm2.value);
  formData.append("newcurriculum", newcurriculum.value);
  formData.append("scrTerm", state.scrTerm);

  formData.append("stat1", state.stat1);
  formData.append("stat2", state.stat2);

  formData.append("computedTotalUnits", computedTotalUnits.value);
  formData.append("computedGwa", computedGwa.value);

  axios
    .post("/create.php?printNewTermGradesPDF", formData, {
      responseType: "blob",
    })
    .then(function (response) {
      var file = new Blob([response.data], { type: "application/pdf" });
      var fileURL = URL.createObjectURL(file);
      window.open(fileURL);
    });
};

const spasidgrade = ref();

const saveGrades = () => {
  spasidgrade.value = route.params.id;
  const getTermValue = computed(() => {
    const termValue = Math.max(newterm.value, newterm1.value, newterm2.value);

    switch (termValue) {
      case 1:
        return 1;
      case 2:
        return 2;
      case 3:
        return 3;
      case 4:
        return 4;
      default:
        return 5;
    }
  });
  console.log(spasidgrade.value);
  console.log(newsy.value);
  console.log(getTermValue.value);
  console.log(newtermtype.value);
  console.log(newcurriculum.value);
  console.log(toggle.value);
};

const backBtn = () => {
  router.push({
    path: "/monitorsheet/" + globalSPASid,
  });
};
</script>
