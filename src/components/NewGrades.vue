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
          <q-chip outline color="teal" text-color="white" icon="badge">
            {{ termId }}
          </q-chip>
          <q-card flat class="q-pa-md rounded-borders-20 banner-5">
            <q-card-section>
              <div class="col-12">
                <div class="q-col-gutter-md row items-start">
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="text-h6">SY: {{ sy }}</div>
                    <div class="text-h6">Term: {{ sem }}</div>
                    <div class="text-h6">Term Required: {{ curriculum }}</div>

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
                      School and Course Record: {{ school }} , {{ course }}
                      <div class="row q-pa-md q-gutter-sm">
                        <span class="text-h6">Status (Start of Sem):</span>
                        <q-select
                          ref="refstat1"
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
                          :rules="[myRule]"
                        />
                        <q-select
                          ref="refstat2"
                          v-model="state.stat2"
                          name="stat2"
                          outlined
                          dense
                          hide-bottom-space
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          :options="endTermProgressStatOptions"
                          clearable
                          :rules="[myRule]"
                        />
                      </div>
                    </div>
                  </div>
                  <!-- test -->
                  <div class="col-xs-12 col-sm-3 col-md-1">
                    <!-- <div class="float-right"> -->
                    <span class="text-bold primary-text">Latest?</span>
                    <q-toggle
                      v-model="toggle"
                      @update:model-value="handleToggle"
                    />
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
                    <!-- <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">SUBJECT CODE:</span>
                      <q-input v-model="scode" filled :rules="inputRules" />
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
                        :rules="inputRules"
                        mask="##.##"
                      />
                    </div> -->
                    <!-- <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">GRADE:</span>
                      <q-input v-model="grade" filled readonly />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">COMPLETION:</span>
                      <q-input v-model="completion" filled readonly />
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                      <span class="text-bold primary-text">REMARKS:</span>
                      <q-input v-model="remarks" filled readonly />
                    </div> -->
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

                <!-- <template v-slot:body-cell-grade="props">
                  <q-td :props="props">
                    <q-input v-model="props.row.grade" readonly />
                  </q-td>
                </template>

                <template v-slot:body-cell-completion="props">
                  <q-td :props="props">
                    <q-input v-model="props.row.completion" readonly />
                  </q-td>
                </template>

                <template v-slot:body-cell-remarks="props">
                  <q-td :props="props">
                    <q-input v-model="props.row.remarks" readonly />
                  </q-td>
                </template> -->

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
              <q-btn rounded style="width: 40%" color="primary" @click="saveBtn"
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

const refstat1 = ref(null);
const refstat2 = ref(null);

const state = reactive({
  term: "",
  stat1: "",
  stat2: "",
});
const scode = ref("");
const academic = ref(false);
const units = ref("");
const grade = ref("");
const completion = ref("");
const remarks = ref("");

const toggle = ref();

// Rules & Validations
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
];

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
    // grade: "",
    // completion: "",
    // remarks: "",
  },
  {
    id: uid(),
    scode: "",
    academic: false,
    units: "",
    // grade: "",
    // completion: "",
    // remarks: "",
  },
  {
    id: uid(),
    scode: "",
    academic: false,
    units: "",
    // grade: "",
    // completion: "",
    // remarks: "",
  },
]);

const sy = ref("");
const sem = ref("");
const school = ref("");
const course = ref("");
const course_id = ref("");
const computedGwa = ref("0.00");

const addTodo = () => {
  todos.value.push({
    id: uid(),
    scode: "",
    academic: false,
    units: "",
  });
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
      // grade: "",
      // completion: "",
      // remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      // grade: "",
      // completion: "",
      // remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      // grade: "",
      // completion: "",
      // remarks: "",
    },
  ];
};

const columns = [
  { name: "scode", label: "Subject Code", field: "scode", align: "left" },
  { name: "academic", label: "Academic", field: "academic", align: "center" },
  { name: "units", label: "Units", field: "units", align: "left" },
  // { name: "grade", label: "Grade", field: "grade", align: "left" },
  // {
  //   name: "completion",
  //   label: "Completion",
  //   field: "completion",
  //   align: "left",
  // },
  // { name: "remarks", label: "Remarks", field: "remarks", align: "left" },
  { name: "action", label: "Action", field: "action", align: "center" },
];

// Total Units Computations

const computedTotalUnits = computed(() => {
  // Calculate total units for subjects where academic is checked
  return todos.value
    .filter((todo) => todo.academic)
    .reduce((total, todo) => {
      const unit = parseFloat(todo.units);
      return total + (isNaN(unit) ? 0 : unit);
    }, 0)
    .toFixed(2);
});

// Select
var stat2options2 = [];
const stat2options = ref(stat2options2);
var stat1options2 = [];
const stat1options = ref(stat1options2);
const endTermProgressStatOptions = ref();
// Storage
const termLists = ref(null);
const curriculum = ref(null);
// Other Variable

const globalSPASid = route.params.id;

onMounted(() => {
  populateGrades();
});

const populateGrades = () => {
  // console.log(toggle.value + "start");

  var formData = new FormData();
  formData.append("id", globalSPASid);
  formData.append("termid_course", termId);
  axios.post("/read.php?readEnrollSC", formData).then((response) => {
    // console.log(response.data);

    sy.value = response.data.sy;
    sem.value = response.data.name;
    school.value = response.data.school;
    course.value = response.data.course;
    toggle.value = response.data.latest_flag === 1 ? true : false;
    course_id.value = response.data.id;
  });

  axios.get("/read.php?readstat2").then((response) => {
    stat2options2 = response.data;
  });

  axios.get("/read.php?readstat1").then((response) => {
    stat1options2 = response.data;
  });
  axios.post("/read.php?standing", formData).then((response) => {
    endTermProgressStatOptions.value = response.data;
  });
};

// Storage

const storedtermLists = sessionStorage.getItem("termwthRec");
const storedCurriculum = sessionStorage.getItem("curriculum");

if (storedtermLists) {
  termLists.value = JSON.parse(storedtermLists);
}
if (storedCurriculum) {
  curriculum.value = JSON.parse(storedCurriculum);
}

// Accesssing Term Id  from storage

const termId = termLists?.value?.sy || "default value";

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

  formData.append("school", school.value);
  formData.append("course", course.value);

  // From Storage

  formData.append("syList", sy.value);
  formData.append("term", sem.value);
  formData.append("termreq", curriculum.value);

  formData.append("stat1", state.stat1);
  formData.append("stat2", state.stat2);

  formData.append("computedTotalUnits", computedTotalUnits.value);
  formData.append("computedGwa", computedGwa.value);

  axios
    .post("/create.php?printAddGradesPDF", formData, { responseType: "blob" })
    .then(function (response) {
      var file = new Blob([response.data], { type: "application/pdf" });
      var fileURL = URL.createObjectURL(file);
      window.open(fileURL);
    });
};

const backBtn = () => {
  router.push({
    path: "/monitorsheet/" + globalSPASid,
  });
};

const handleToggle = () => {
  var formData = new FormData();

  formData.append("termid", termId);

  if (toggle.value === true) {
    axios.post("/create.php?createLatest", formData).then(function (response) {
      if (response.data == true) {
        $q.notify({
          color: "green",
          textColor: "white",
          message: "Latest grades has been set",
        });
        populateGrades();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Error handling the toggle",
        });
      }
    });
  } else {
    axios
      .post("/create.php?createLatestFalse", formData)
      .then(function (response) {
        if (response.data == true) {
          $q.notify({
            color: "orange",
            textColor: "white",
            message: "Changes has been made",
          });
          populateGrades();
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "Error handling the toggle",
          });
        }
      });
  }
};

const saveBtn = () => {
  refstat1.value.validate();
  refstat2.value.validate();

  if (refstat1.value.hasError || refstat2.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please Complete All the required fields",
    });
  } else {
    var formData = new FormData();
    let term = termId[termId.length - 2];
    let termtype = termId[termId.length - 1];

    formData.append("termid", termId);
    formData.append("spasid", globalSPASid);
    formData.append("sy", sy.value);
    formData.append("term", term);
    formData.append("termtype", termtype);
    formData.append("course_id", course_id.value);
    formData.append("pstatus", state.stat1);
    formData.append("standing", state.stat2);
    formData.append("user", user.username);

    todos.value.forEach((todo, index) => {
      formData.append(`todos[${index}][scode]`, todo.scode);
      formData.append(`todos[${index}][academic]`, todo.academic ? 1 : 0);
      formData.append(`todos[${index}][units]`, todo.units);
      formData.append(`todos[${index}][grade]`, todo.grade);
      formData.append(`todos[${index}][completion]`, todo.completion);
      formData.append(`todos[${index}][remarks]`, todo.remarks);
    });
    Swal.fire({
      title: "Do you want to save the changes?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Save",
      denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post("/create.php?createGrades", formData)
          .then(function (response) {
            if (response.data == true) {
              $q.notify({
                type: "positive",
                message: "Grades and Term Status are Saved.",
                position: "top-right",
              });
              populateGrades();
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Grades not Updated",
              });
            }
          });
        axios
          .post("/create.php?createStatStartsem", formData)
          .then(function (response) {
            if (response.data == true) {
              Swal.fire("Saved!", "", "success");
              populateGrades();
              router.push({
                path: "/monitorsheet/" + globalSPASid,
              });
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Grades Info not Updated",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};
</script>
