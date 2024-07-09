<template>
  <q-page class="q-pa-md">
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="text-h6">To-Do List</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit.prevent="addTodo">
          <div class="col-12">
            <div class="q-col-gutter-md row items-start">
              <div class="col-xs-12 col-sm-3 col-md-2">
                <span class="text-bold primary-text">SUBJECT CODE:</span>
                <q-input
                  v-model="scode"
                  filled
                  :rules="[(val) => !!val || 'Subject code is required']"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-2">
                <span class="text-bold primary-text">ACADEMIC:</span>
                <q-checkbox
                  v-model="academic"
                  label="Include in computation?"
                  filled
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-2">
                <span class="text-bold primary-text">UNITS:</span>
                <q-input
                  v-model="units"
                  filled
                  :rules="[(val) => !!val || 'Unit is required']"
                  mask="##.##"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-2">
                <span class="text-bold primary-text">GRADE:</span>
                <q-input
                  v-model="grade"
                  filled
                  :rules="[(val) => !!val || 'Grade is required']"
                  mask="#.##"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-2">
                <span class="text-bold primary-text">COMPLETION:</span>
                <q-input
                  v-model="completion"
                  filled
                  :rules="[(val) => !!val || 'Completion is required']"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-2">
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
    </q-card>
  </q-page>
</template>

<script setup>
import { ref, computed } from "vue";
import { uid } from "quasar";

const scode = ref("");
const academic = ref(false);
const units = ref("");
const grade = ref("");
const completion = ref("");
const remarks = ref("");

const todos = ref([]);

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
</script>

<style scoped>
/* Add your styles here */
</style>
