<template>
  <q-card flat class="my-card surface-container rounded-borders-20">
    <q-card-section>
      <q-page class="q-pa-md">
        <q-card class="q-pa-md rounded-borders-20 banner-5">
          <q-card-section>
            <div class="col-12">
              <div class="q-col-gutter-md row items-start">
                <div class="col-xs-12 col-sm-3 col-md-6">
                  <div class="text-h6">SY: {{ sy }}, {{ sem }}</div>
                  <div class="text-h6">School: {{ school }}</div>
                  <div class="text-h6">Course: {{ course }}</div>
                  <div>
                    <span class="text-h6">Term Required: </span>
                    <q-radio v-model="termreq" val="YES" label="YES" />
                    <q-radio v-model="termreq" val="NO" label="NO" />

                    <div class="q-pa-xs q-gutter-sm">
                      <q-btn
                        v-if="verif === false"
                        color="positive"
                        label="Verify Grades"
                        icon="verified"
                        @click="verifyBtn"
                        rounded
                      />
                      <q-btn
                        v-else
                        color="negative"
                        label="Disallow Grades"
                        icon="cancel"
                        rounded
                        @click="disAllowBtn"
                      />
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
                <div class="col-xs-12 col-sm-3 col-md-6">
                  <div class="float-right">
                    <span class="text-bold primary-text">Latest?</span>
                    <q-toggle v-model="toggle" />
                  </div>

                  <div class="text-h6">
                    Registration Form Verified by: {{ regVerified }}
                  </div>
                  <div class="text-h6">
                    Grades Verified by: {{ gradeVerified }}
                  </div>
                  <div class="text-h6">
                    Status (Start of Term):
                    <q-btn rounded flat color="blue" @click="startBtn">
                      {{ statStart }}
                    </q-btn>
                    -
                    <q-btn rounded flat color="blue" @click="endBtn">
                      {{ statEnd }}
                    </q-btn>
                  </div>

                  <div class="q-gutter-sm row items-start">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                      <div class="text-h6">Status (END of Term):</div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
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
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
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
              </div>
            </div>
          </q-card-section>

          <q-separator inset />

          <q-card-section>
            <q-form @submit.prevent="addTodo" id="CreateSubject">
              <div class="col-12">
                <div class="q-col-gutter-md row items-start">
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">SUBJECT CODE:</span>
                    <q-input
                      v-model="scode"
                      name="scode"
                      filled
                      :rules="[(val) => !!val || 'Subject code is required']"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">ACADEMIC:</span>
                    <q-checkbox
                      v-model="academic"
                      name="academic"
                      label="Include in computation?"
                      filled
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">UNITS:</span>
                    <q-input
                      v-model="units"
                      name="units"
                      filled
                      :rules="[(val) => !!val || 'Unit is required']"
                      mask="##.##"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">GRADE:</span>
                    <q-input
                      v-model="grade"
                      name="grade"
                      filled
                      :rules="[(val) => !!val || 'Grade is required']"
                      mask="#.##"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">COMPLETION:</span>
                    <q-input
                      v-model="completion"
                      name="completion"
                      filled
                      :rules="[(val) => !!val || 'Completion is required']"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">REMARKS:</span>
                    <q-input
                      v-model="remarks"
                      name="remarks"
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
                    @click="removeTodo(props.row.id, props.row.subject_id)"
                  />
                </q-td>
              </template>
            </q-table>

            <div class="q-pa-md">
              <div class="col-12">
                <div class="q-col-gutter-md row items-start">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <q-input
                      filled
                      v-model="computedTotalUnits"
                      label="Total Units:"
                      readonly
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
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
</template>

<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, reactive, computed, onMounted, inject, watchEffect } from "vue";
import router from "../router";
import { uid } from "quasar";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

import Swal from "sweetalert2";
import { c } from "vite/dist/node/types.d-aGj9QkWt";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

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

const toggle = ref("");
const todos = ref([
  {
    id: uid(),
    subject_id: "",
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
  {
    id: uid(),
    subject_id: "",
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
  {
    id: uid(),
    subject_id: "",
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
]);

const term_required = ref(0);

const sy = ref("");
const sem = ref("");
const school = ref("");
const course = ref("");
const termreq = ref("");
const regVerified = ref("");
const gradeVerified = ref("");
const statStart = ref("");
const statEnd = ref("");
const verif = ref();

const term_id = ref();
const addTodo = () => {
  term_id.value = route.params.id;

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
    var formData = new FormData(document.getElementById("CreateSubject"));

    formData.append("termid", term_id.value);

    axios.post("/create.php?createSubject", formData).then(function (response) {
      if (response.data == true) {
        populateEditGrades();
        scode.value = "";
        academic.value = false;
        units.value = "";
        grade.value = "";
        completion.value = "";
        remarks.value = "";
        $q.notify({
          type: "positive",
          message: "Grade Added Successfully",
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to add subject",
        });
      }
    });
  }
};

const removeTodo = (id, subject_id) => {
  var formData = new FormData();
  formData.append("subjectid", subject_id);
  const index = todos.value.findIndex((todo) => todo.id === id);

  if (index !== -1) {
    console.log(subject_id); // Log subject_id
    todos.value.splice(index, 1);

    axios.post("/delete.php?delGrades", formData).then(function (response) {
      if (response.data == true) {
        populateEditGrades();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to removed Grade",
        });
      }
    });
  }
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

var stat2options2 = [];
const stat2options = ref(stat2options2);
var stat1options2 = [];
const stat1options = ref(stat1options2);

const data = ref();
const id = ref();
onMounted(() => {
  populateEditGrades();
});

const populateEditGrades = () => {
  // console.log(toggle.value + "start");
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readEditGrades", formData).then((response) => {
    // console.log(response.data);

    sy.value = response.data.sy;
    sem.value = response.data.sem;
    school.value = response.data.school;
    course.value = response.data.course;
    termreq.value = response.data.term_required;
    regVerified.value = response.data.reg_verified_by;
    gradeVerified.value = response.data.grades_verified_by;
    statStart.value = response.data.pstart;
    statEnd.value = response.data.sstanding;
    toggle.value = response.data.latest_flag == 1 ? true : false;
    verif.value = response.data.verified_flag == 1 ? true : false;

    watchEffect(() => {
      termreq.value = term_required.value === 1 ? "YES" : "NO";
    });
  });

  axios.get("/read.php?readstat2").then((response) => {
    stat2options2 = response.data;
  });

  axios.get("/read.php?readstat1").then((response) => {
    stat1options2 = response.data;
  });

  axios.post("/read.php?readGrades", formData).then((response) => {
    data.value = response.data;

    todos.value = data.value.map((grade) => ({
      id: uid(), // Generate a unique id
      subject_id: grade.subj_id || "",
      scode: grade.subj_code || "", // Subject code from response
      academic: grade.academic_type, // Convert "Yes"/"No" to boolean
      units: grade.unit || "", // Units from response
      grade: grade.grade || "", // Grade from response
      completion: grade.completion || "", // Completion from response
      remarks: grade.remarks || "", // Remarks from response
    }));
  });
};

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

const spasid = ref();
const printGrades = () => {
  alert("Please click OK to print PDF");

  spasid.value = route.params.id;
  var formData = new FormData();

  formData.append("id", id.value);
  formData.append("grades", JSON.stringify(todos.value));
  formData.append("sy", sy.value);
  formData.append("sem", sem.value);
  formData.append("school", school.value);
  formData.append("course", course.value);
  formData.append("termreq", termreq.value);
  formData.append("regVerified", regVerified.value);
  formData.append("gradeVerified", gradeVerified.value);
  formData.append("statStart", statStart.value);
  formData.append("statEnd", statEnd.value);
  formData.append("stat1", state.stat1);
  formData.append("stat2", state.stat2);

  formData.append("computedTotalUnits", computedTotalUnits.value);
  formData.append("computedGwa", computedGwa.value);

  axios
    .post("/create.php?printGradesPDF", formData, { responseType: "blob" })
    .then(function (response) {
      var file = new Blob([response.data], { type: "application/pdf" });
      var fileURL = URL.createObjectURL(file);
      window.open(fileURL);
    });
};

const verifyBtn = () => {
  Swal.fire({
    icon: "success",
    title: "Verified",
    showConfirmButton: false,
    timer: 1500,
  });
};

const disAllowBtn = () => {
  Swal.fire({
    icon: "error",
    title: "Disalllowed Successfully",
    showConfirmButton: false,
    timer: 1500,
  });
};

// Session Storage
const spasids = ref();

const spasItem = sessionStorage.getItem("spasid");

if (spasItem) {
  spasids.value = JSON.parse(spasItem);
}

const startBtn = () => {
  router.push({
    path: "/historyrec/" + spasids.value,
  });
};

const endBtn = () => {
  router.push({
    path: "/historyrec/" + spasids.value,
  });
};

const term_IDs = ref();

const saveBtn = () => {
  term_IDs.value = route.params.id;

  var formData = new FormData();

  formData.append("termid", term_IDs.value);

  formData.append("user", user.username);

  todos.value.forEach((todo, index) => {
    formData.append(`todos[${index}][subj_id]`, todo.subject_id);
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
        .post("/update.php?updateGrades", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire("Saved!", "", "success");
            populateEditGrades();
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Grades not Updated",
            });
          }
        });
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
};
</script>
