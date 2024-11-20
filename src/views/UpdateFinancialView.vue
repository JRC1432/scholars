<template>
  <ScInfo />

  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Update Financial Statement
      </div>

      <q-card-section>
        <q-card flat class="my-card bordered">
          <q-banner inline-actions class="banner-2">
            <div class="text-subtitle1">School Year: {{ sy }}</div>
          </q-banner>

          <q-card-section>
            <q-btn
              rounded
              icon="add"
              unelevated
              color="primary"
              @click="addNewItem"
            ></q-btn>
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
              <template v-slot:body-cell-term_ids="props">
                <q-td :props="props">
                  <q-select
                    ref="reftermRec"
                    :options="filteredTermRecOptions"
                    v-model="props.row.term_ids"
                    name="termwthRec"
                    emit-value
                    map-options
                    use-input
                    input-debounce="0"
                    outlined
                    dense
                    hide-bottom-space
                    :rules="[myRule]"
                    style="width: 260px"
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-category="props">
                <q-td :props="props">
                  <q-select
                    ref="refitemType"
                    v-model="props.row.category"
                    name="itemType"
                    label="Category"
                    outlined
                    dense
                    hide-bottom-space
                    emit-value
                    use-input
                    map-options
                    :options="itemTypeOptions"
                    :rules="[myRule]"
                    @update:model-value="populateitems(props)"
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-year="props">
                <q-td :props="props">
                  <q-input
                    ref="refYear"
                    name="year"
                    v-model="props.row.year"
                    outlined
                    dense
                    hide-bottom-space
                    mask="####"
                    label="Year"
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-month="props">
                <q-td :props="props">
                  <q-select
                    ref="refMonth"
                    :options="etgOptions"
                    v-model="props.row.month"
                    name="month"
                    label="Month"
                    emit-value
                    outlined
                    dense
                    use-input
                    map-options
                    hide-bottom-space
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-date_process="props">
                <q-td :props="props">
                  <q-input
                    ref="refdateProcess"
                    v-model="props.row.date_process"
                    name="dateProcess"
                    label="Date Process"
                    dense
                    outlined
                    type="date"
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-amount="props">
                <q-td :props="props">
                  <q-input
                    ref="refAmount"
                    v-model="props.row.amount"
                    name="amount"
                    label="Amount"
                    dense
                    outlined
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-date_deposit="props">
                <q-td :props="props">
                  <q-input
                    v-model="props.row.date_deposit"
                    name="dateDeposit"
                    label="Date Deposit"
                    dense
                    outlined
                    type="date"
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-remarks="props">
                <q-td :props="props">
                  <q-input
                    v-model="props.row.remarks"
                    name="remarks"
                    label="Remarks"
                    dense
                    outlined
                  />
                </q-td>
              </template>

              <template v-slot:body-cell-action="props">
                <q-td :props="props">
                  <q-btn
                    flat
                    icon="delete"
                    color="negative"
                    @click="removeFinancial(props.row.financial_statement_ids)"
                  />
                </q-td>
              </template>
            </q-table>
          </q-card-section>
          <q-card-section>
            <q-chip outline color="teal" text-color="white" icon="payments">
              Total Amount: ₱ {{ formattedTotalAmount }}
            </q-chip>
          </q-card-section>
        </q-card>
      </q-card-section>

      <q-card-actions class="q-pa-md row justify-center">
        <q-btn
          unelevated
          rounded
          type="submit"
          style="width: 500px"
          color="green"
          @click="updateFinancial"
          >SAVE CHANGES</q-btn
        >
      </q-card-actions>
    </q-card>
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { uid } from "quasar";
import { useQuasar } from "quasar";
import { useRoute } from "vue-router";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

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

const inputRulesAmount = [
  (val) =>
    (val !== null && val !== undefined && val !== "") ||
    "Please type something",
];

const finance_id = ref(null);

const data = ref();

const financials_id = ref("");
const financial_statement_ids = ref(null);
const term_ids = ref();
const category = ref(false);
const year = ref("");
const month = ref("");
const date_process = ref("");
const amount = ref("");
const date_deposit = ref("");
const remarks = ref("");

const syList = ref([]);
const nameList = ref([]);
const itemTypeOptions = ref([]);
const termRecoptions = ref([]);
const etgOptions = ref([]);
const sy = ref();

const globalSPAS = route.params.id;

const todos = ref([
  {
    id: uid(),
    financials_id: "",
    term_ids: "",
    category: "",
    year: "",
    month: "",
    date_process: "",
    amount: "",
    date_deposit: "",
    remarks: "",
  },
]);

const columns = [
  {
    name: "term_ids",
    label: "School Year / Term",
    field: "term_ids",
    align: "center",
  },
  { name: "category", label: "Category", field: "category", align: "center" },
  { name: "year", label: "Year", field: "year", align: "center" },
  { name: "month", label: "Month", field: "month", align: "center" },
  {
    name: "date_process",
    label: "Date Process",
    field: "date_process",
    align: "center",
  },
  { name: "amount", label: "Amount", field: "amount", align: "center" },
  {
    name: "date_deposit",
    label: "Date Deposit",
    field: "date_deposit",
    align: "center",
  },
  { name: "remarks", label: "Remarks", field: "remarks", align: "center" },
  { name: "action", label: "Action", field: "action", align: "center" },
];

// Storage

const storedId = sessionStorage.getItem("id");

if (storedId) {
  finance_id.value = JSON.parse(storedId);
}

const populateAll = async () => {
  var formData = new FormData();
  formData.append("finance_id", finance_id.value);
  formData.append("id", globalSPAS);

  // Reading Terms

  await axios.post("/read.php?readTermRec", formData).then((response) => {
    termRecoptions.value = response.data;
  });

  // Reading Financials
  await axios.post("/read.php?readFinancial", formData).then((response) => {
    data.value = response.data;

    todos.value = data.value.map((financials) => ({
      id: uid(),
      financial_statement_ids: financials.financial_statement_id || "",
      financials_id: financials.financial_release_id || "",
      term_ids: financials.term_id || "",
      category: financials.category || "",
      year: financials.year,
      month: financials.month || "",
      date_process: financials.date_process || "",
      amount: financials.amount || "",
      date_deposit: financials.date_deposit || "",
      remarks: financials.remarks || "",
    }));
  });

  // Read Financial Release

  await axios
    .post("/read.php?readFinancialRelease", formData)
    .then((response) => {
      sy.value = response.data.sy;
    });

  // Select Items

  await axios.get("/read.php?readAllowance").then((response) => {
    itemTypeOptions.value = response.data;
  });

  // Select Month

  await axios.get("/read.php?etgMonth").then((response) => {
    etgOptions.value = response.data;
  });
};

const addNewItem = () => {
  todos.value.push({
    id: uid(), // Generates a unique ID for the new row
    financials_id: "",
    term_ids: "",
    category: "",
    year: "",
    month: "",
    date_process: "",
    amount: "",
    date_deposit: "",
    remarks: "",
  });
};

const populateitems = (props) => {
  // Ensure the item passed is the current item
  var formData = new FormData();
  formData.append("itemid", props.row.category); // use the item's type directly

  console.log(props.row.category); // Log the itemType for debugging

  axios.post("/read.php?itemids", formData).then(function (response) {
    props.row.amount = response.data.amount; // Update the amount directly on the item
  });
};

const filteredTermRecOptions = computed(() => {
  if (sy.value) {
    // Ensure termRecoptions is an array before attempting to filter
    const selectedYear = sy.value.split("-")[0]; // Get the first year of the SY

    // Guard against termRecoptions being undefined or not an array
    if (Array.isArray(termRecoptions.value)) {
      return termRecoptions.value.filter(
        (option) => option.label.includes(selectedYear) // Match the year with the term label
      );
    } else {
      console.error("termRecoptions is not an array", termRecoptions.value);
      return []; // Return an empty array if termRecoptions is not an array
    }
  }
  return termRecoptions.value || []; // If no school year is selected, return all terms
});

const formattedTotalAmount = computed(() => {
  const total = todos.value.reduce((total, card) => {
    const amount = parseFloat(card.amount); // Ensure it's a number
    return total + (isNaN(amount) ? 0 : amount); // Add 0 if amount is NaN
  }, 0);

  // Format as a money value without currency symbol
  return new Intl.NumberFormat("en-PH", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(total);
});

const removeFinancial = (financial_statement_ids) => {
  var formData = new FormData();
  formData.append("id", financial_statement_ids);

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/delete.php?delFinancial", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire({
              title: "Deleted!",
              text: "Financial data has been deleted.",
              icon: "success",
            });
            populateAll();
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to remove the financial data",
            });
          }
        });
    }
  });
};

const updateFinancial = () => {
  var formData = new FormData();

  formData.append("totalamt", formattedTotalAmount.value);
  formData.append("finance_id", finance_id.value); // Needed to insert in Financial relaease id column

  formData.append("user", user.username);

  todos.value.forEach((todo, index) => {
    formData.append(
      `todos[${index}][financial_statement_ids]`,
      todo.financial_statement_ids
    );
    console.log(
      `todos[${index}][financial_statement_ids]:`,
      todo.financial_statement_ids
    );

    formData.append(`todos[${index}][term_ids]`, todo.term_ids);
    console.log(`todos[${index}][term_ids]:`, todo.term_ids);

    formData.append(`todos[${index}][category]`, todo.category);
    console.log(`todos[${index}][category]:`, todo.category);

    formData.append(`todos[${index}][year]`, todo.year);
    console.log(`todos[${index}][year]:`, todo.year);

    formData.append(`todos[${index}][month]`, todo.month);
    console.log(`todos[${index}][month]:`, todo.month);

    formData.append(`todos[${index}][date_process]`, todo.date_process);
    console.log(`todos[${index}][date_process]:`, todo.date_process);

    formData.append(`todos[${index}][amount]`, todo.amount);
    console.log(`todos[${index}][amount]:`, todo.amount);

    formData.append(`todos[${index}][date_deposit]`, todo.date_deposit);
    console.log(`todos[${index}][date_deposit]:`, todo.date_deposit);

    formData.append(`todos[${index}][remarks]`, todo.remarks);
    console.log(`todos[${index}][remarks]:`, todo.remarks);
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
        .post("/update.php?updateFinancials", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire("Saved!", "", "success");
            router.push({
              path: "/financeassists/" + globalSPAS,
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Financial Records not updated",
            });
          }
        });
      axios
        .post("/update.php?upFinancialRelease", formData)
        .then(function (response) {
          if (response.data == true) {
            $q.notify({
              color: "positive",
              textColor: "white",
              message: "Financial Total Amount has been updated",
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Financial Records not updated",
            });
          }
        });
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
};

onMounted(() => {
  populateAll();
});
</script>
