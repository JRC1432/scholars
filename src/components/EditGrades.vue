<template>
  <q-card flat class="my-card surface-container rounded-borders-20">
    <div class="q-pa-md q-gutter-sm">
      <div class="text-bold text-h6 primary-text">Edit Grades</div>
    </div>

    <q-card-section>
      <q-page class="q-pa-md">
        <q-card class="q-pa-md rounded-borders-20">
          <q-card-section>
            <div class="col-12">
              <div class="q-col-gutter-md row items-start">
                <div class="col-xs-12 col-sm-3 col-md-6">
                  <div class="text-h6" v-if="sem === 1">
                    SY: {{ sy }}, {{ sem }}st Term
                  </div>
                  <div class="text-h6" v-else-if="sem === 2">
                    SY: {{ sy }}, {{ sem }}nd Term
                  </div>
                  <div class="text-h6" v-else-if="sem === 3">
                    SY: {{ sy }}, Summer
                  </div>
                  <div class="text-h6" v-else>SY: {{ sy }}, Midyear</div>
                  <div class="text-h6">School: {{ school }}</div>
                  <div class="text-h6">Course: {{ course }}</div>
                  <div>
                    <span class="text-h6">Term Required: </span>
                    <q-radio v-model="termreq" val="YES" label="YES" />
                    <q-radio v-model="termreq" val="NO" label="NO" />

                    <div class="q-pa-xs q-gutter-sm">
                      <q-btn
                        color="positive"
                        label="Verify Grades"
                        icon="verified"
                        rounded
                      />
                      <q-btn
                        color="negative"
                        label="Disallow Grades"
                        icon="cancel"
                        rounded
                      />
                      <q-btn
                        color="warning"
                        label="Print"
                        icon="print"
                        rounded
                        @click="exportToCSV"
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
                    Status (Start of Term): {{}} - {{ statEnd }}
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
                      />
                    </div>
                  </div>
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
            <q-table
              :rows="todos"
              :columns="columns"
              row-key="id"
              flat
              bordered
              separator="cell"
            >
              <template v-slot:body-cell-academic="props">
                <q-td :props="props">
                  <q-checkbox v-model="props.row.academic" disable />
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
            <q-btn rounded style="width: 40%" color="primary">SAVE</q-btn>
            <q-btn
              rounded
              style="width: 40%"
              color="warning"
              @click="resetTodos"
              >RESET</q-btn
            >
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

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const state = reactive({
  term: "",
  stat1: "SELECT",
  stat2: "SELECT",
});
const scode = ref("");
const academic = ref(false);
const units = ref("");
const grade = ref("");
const completion = ref("");
const remarks = ref("");

const toggle = ref("");
const todos = ref([]);

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
  todos.value = [];
  scode.value = "";
  academic.value = "";
  units.value = "";
  grade.value = "";
  completion.value = "";
  remarks.value = "";
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
    .reduce((total, todo) => total + todo.units, 0)
    .toFixed(2);
});

const computedGwa = computed(() => {
  const academicTodos = todos.value.filter((todo) => todo.academic);
  const totalUnits = academicTodos.reduce(
    (total, todo) => total + todo.units,
    0
  );
  const totalGradePoints = academicTodos.reduce(
    (total, todo) => total + todo.units * todo.grade,
    0
  );
  return totalUnits > 0 ? (totalGradePoints / totalUnits).toFixed(2) : "0.00";
});

// Select Term
var stat2options2 = [];
const stat2options = ref(stat2options2);

onMounted(() => {
  populatestat2();
});

const populatestat2 = () => {
  axios.get("/read.php?readstat2").then((response) => {
    stat2options2 = response.data;
  });
};

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
var stat1options2 = [];
const stat1options = ref(stat1options2);

onMounted(() => {
  populatestat1();
});

const populatestat1 = () => {
  axios.get("/read.php?readstat1").then((response) => {
    stat1options2 = response.data;
  });
};

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

// Method to export table data to CSV
const exportToCSV = () => {
  const headers = columns.map((col) => col.label);
  const rows = todos.value.map((todo) => [
    todo.scode,
    todo.academic ? "Yes" : "No",
    todo.units,
    todo.grade,
    todo.completion,
    todo.remarks,
  ]);

  let csvContent =
    "data:text/csv;charset=utf-8," +
    [headers.join(","), ...rows.map((e) => e.join(","))].join("\n");

  const encodedUri = encodeURI(csvContent);
  const link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "grades.csv");
  document.body.appendChild(link);

  link.click();
  document.body.removeChild(link);
};

// Grades Info

const id = ref();
onMounted(() => {
  populateEditGrades();
});

const populateEditGrades = () => {
  console.log(toggle.value + "start");
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readEditGrades", formData).then((response) => {
    console.log(response.data);

    sy.value = response.data.sy;
    sem.value = response.data.term;
    school.value = response.data.college_name;
    course.value = response.data.course_name;
    termreq.value = response.data.term_required;
    regVerified.value = response.data.reg_verified_by;
    gradeVerified.value = response.data.grades_verified_by;
    statEnd.value = response.data.standing;
    toggle.value = response.data.latest_flag == 1 ? true : false;

    watchEffect(() => {
      termreq.value = term_required.value === 1 ? "YES" : "NO";
    });
  });
};
</script>
