<template>
  <q-page padding class="q-pa-lg">
    <q-card class="rounded-borders-20">
      <q-banner inline-actions class="banner-2">
        <div class="text-subtitle1">STIPEND</div>

        <!-- Button to create a new table -->

        <template v-slot:action>
          <q-btn
            rounded
            color="primary"
            label="Add New Semester"
            @click="addNewTable"
            icon="add
          "
          />
        </template>
      </q-banner>

      <q-card-section>
        <div class="q-pa-md">
          <div class="row row_width q-col-gutter-xs">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="q-px-sm">
                <span class="text-bold">Book Allowance:</span>
                <q-input
                  ref="refbookAllowance"
                  outlined
                  dense
                  hide-bottom-space
                  name="bookAllowance"
                  v-model="state.bookAllowance"
                  label="₱"
                />
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="q-px-sm">
                <span class="text-bold">School Year:</span>
                <q-input
                  ref="refsy"
                  outlined
                  dense
                  hide-bottom-space
                  name="sy"
                  v-model="state.sy"
                  mask="####-####"
                />
              </div>
            </div>
          </div>
        </div>
      </q-card-section>

      <!-- Dynamically render tables with a remove table button -->
      <q-card-section v-for="(table, tableIndex) in tables" :key="tableIndex">
        <q-markup-table>
          <thead>
            <q-tr>
              <q-th align="left">School Year / Sem</q-th>
              <q-th align="left">Year</q-th>
              <q-th align="left">Month</q-th>
              <q-th align="left">Date Process</q-th>
              <q-th align="left">Amount</q-th>
              <q-th align="left">Date Deposit</q-th>
              <q-th align="left">Actions</q-th>
            </q-tr>
          </thead>
          <tbody>
            <!-- Loop through items in the current table -->
            <template v-for="(item, itemIndex) in table.items" :key="itemIndex">
              <q-tr>
                <q-td>{{ item.schoolYearSem }}</q-td>
                <q-td>{{ item.year }}</q-td>
                <q-td>{{ item.month }}</q-td>
                <q-td>{{ item.dateProcess }}</q-td>
                <q-td>{{ item.amount }}</q-td>
                <q-td>{{ item.dateDeposit }}</q-td>
                <q-td>
                  <q-btn
                    rounded
                    color="negative"
                    icon="delete"
                    @click="removeItem(tableIndex, itemIndex)"
                  />
                </q-td>
              </q-tr>
            </template>

            <!-- Row for adding a new item to this table -->
            <q-tr>
              <!-- Each input is aligned with its respective column -->
              <q-td>
                <q-input
                  v-model="table.newItem.schoolYearSem"
                  label="School Year / Sem"
                  dense
                  outlined
                  mask="#-##-##"
                />
              </q-td>
              <q-td>
                <q-input
                  v-model="table.newItem.year"
                  label="Year"
                  dense
                  outlined
                  mask="####"
                />
              </q-td>
              <q-td>
                <q-input
                  v-model="table.newItem.month"
                  label="Month"
                  dense
                  outlined
                />
              </q-td>
              <q-td>
                <q-input
                  v-model="table.newItem.dateProcess"
                  label="Date Process"
                  dense
                  outlined
                  type="date"
                />
              </q-td>
              <q-td>
                <q-input
                  v-model="table.newItem.amount"
                  label="Amount"
                  dense
                  outlined
                />
              </q-td>
              <q-td>
                <q-input
                  v-model="table.newItem.dateDeposit"
                  label="Date Deposit"
                  dense
                  outlined
                  type="date"
                />
              </q-td>
              <q-td>
                <q-btn
                  rounded
                  color="primary"
                  icon="add"
                  @click="addTodoToTable(tableIndex)"
                />
              </q-td>
            </q-tr>
          </tbody>
        </q-markup-table>

        <!-- Button to remove this entire table -->
        <q-btn
          rounded
          color="negative"
          label="Delete SEMESTER"
          icon="delete"
          @click="removeTable(tableIndex)"
          class="q-mt-md"
        />
        <div class="q-pa-md"><q-separator color="orange" inset /></div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";
import PasswordMeter from "vue-simple-password-meter";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

// Define tables array to store multiple tables and their items
const tables = ref([]);

const state = reactive({
  bookAllowance: "",
  sy: "",
});

// Function to add a new item to a specific table
const addTodoToTable = (tableIndex) => {
  const table = tables.value[tableIndex];
  const newItem = table.newItem;

  // Ensure that all fields are filled before adding
  if (
    newItem.schoolYearSem.trim() &&
    newItem.year.trim() &&
    newItem.month.trim() &&
    newItem.dateProcess.trim() &&
    newItem.amount.trim() &&
    newItem.dateDeposit.trim()
  ) {
    table.items.push({ ...newItem });
    table.newItem = {
      schoolYearSem: "",
      year: "",
      month: "",
      dateProcess: "",
      amount: "",
      dateDeposit: "",
    }; // Clear input after adding
  }
};

// Function to create a new table with empty list of items and new item inputs
const addNewTable = () => {
  tables.value.push({
    newItem: {
      schoolYearSem: "",
      year: "",
      month: "",
      dateProcess: "",
      amount: "",
      dateDeposit: "",
    },
    items: [],
  });
};

// Function to remove an item from a specific table
const removeItem = (tableIndex, itemIndex) => {
  tables.value[tableIndex].items.splice(itemIndex, 1);
};

// Function to remove the entire table
const removeTable = (tableIndex) => {
  tables.value.splice(tableIndex, 1);
};
</script>

<style scoped>
/* Add any custom styles here */
.q-mt-md {
  margin-top: 16px;
}
</style>
