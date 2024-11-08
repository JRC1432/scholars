<template>
  <q-card class="rounded-borders-20">
    <q-banner inline-actions class="banner-2">
      <div class="text-subtitle1">Financial Records</div>

      <!-- Button to create a new card -->
      <template v-slot:action>
        <q-btn
          rounded
          color="primary"
          label="Add New Semester"
          @click="addNewCard"
          icon="add"
        />
      </template>
    </q-banner>

    <div class="q-pa-md">
      <div class="row row_width q-col-gutter-sm">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <span class="text-bold">School Year:</span>
          <q-select
            ref="refsy"
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
            :options="syoptions"
            @filter="filtersy"
            :rules="[myRule]"
            mask="#### - ####"
            clearable
            style="width: 300px"
          >
          </q-select>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="row justify-end">
            <q-btn icon="print" color="positive" @click="printReceipt"></q-btn>
          </div>
        </div>
      </div>
    </div>

    <!-- Dynamically render cards with a remove card button -->
    <q-card-section
      v-for="(card, cardIndex) in cards"
      :key="cardIndex"
      class="bor"
    >
      <q-card class="my-card">
        <q-banner inline-actions class="banner-6">
          <div class="q-pa-xs">
            <div class="q-px-sm">
              <span class="text-bold">Term Record:</span>
              <q-select
                ref="reftermRec"
                :options="termRecoptions"
                v-model="card.termwthRec"
                name="termwthRec"
                emit-value
                map-options
                use-input
                input-debounce="0"
                outlined
                dense
                hide-bottom-space
                :rules="[myRule]"
                style="width: 300px"
              />
            </div>
          </div>
        </q-banner>

        <div class="q-pa-md">
          <q-btn
            rounded
            color="primary"
            @click="addNewItem(cardIndex)"
            icon="add"
          />
        </div>

        <div
          class="q-pa-xs"
          v-for="(item, itemIndex) in card.items"
          :key="itemIndex"
        >
          <div class="q-pa-xs">
            <div class="row row_width q-col-gutter-sm">
              <div class="col-xs-12 col-sm-6 col-md-2">
                <q-select
                  ref="refitemType"
                  v-model="item.itemType"
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
                  @update:model-value="populateitems(item)"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-1">
                <q-input
                  name="year"
                  v-model="item.year"
                  outlined
                  dense
                  hide-bottom-space
                  mask="####"
                  label="Year"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2">
                <q-select
                  :options="etgOptions"
                  v-model="item.month"
                  name="month"
                  label="Month"
                  emit-value
                  outlined
                  dense
                  use-input
                  map-options
                  hide-bottom-space
                  :rules="[myRule]"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2">
                <q-input
                  ref="refdateProcess"
                  v-model="item.dateProcess"
                  name="dateProcess"
                  label="Date Process"
                  dense
                  outlined
                  type="date"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-1">
                <q-input
                  ref="refAmount"
                  v-model="item.amount"
                  name="amount"
                  label="Amount"
                  dense
                  outlined
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2">
                <q-input
                  v-model="item.dateDeposit"
                  name="dateDeposit"
                  label="Date Deposit"
                  dense
                  outlined
                  type="date"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-1">
                <q-input
                  v-model="item.remarks"
                  name="remarks"
                  label="Remarks"
                  dense
                  outlined
                />
              </div>

              <div class="col-xs-12 col-sm-6 col-md-1 q-gutter-none">
                <div class="row justify-end">
                  <q-btn
                    rounded
                    color="warning"
                    icon="delete"
                    @click="removeItem(cardIndex, itemIndex)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </q-card>

      <!-- Button to remove this entire card -->
      <div class="q-pa-md row justify-end">
        <q-btn
          rounded
          color="negative"
          label="Remove Sem"
          icon="delete"
          @click="removeCard(cardIndex)"
        />
      </div>

      <div class="q-pa-xs"><q-separator color="orange" inset /></div>
    </q-card-section>

    <q-card-section>
      <q-chip
        outline
        color="teal"
        text-color="white"
        icon="payments"
        v-model="totalAmount"
        name="totalAmount"
      >
        Total Amount: {{ formattedTotalAmount }}
      </q-chip>
    </q-card-section>

    <q-card-actions class="q-pa-md row justify-end">
      <q-btn type="submit">SUBMIT</q-btn>
    </q-card-actions>
  </q-card>
</template>

<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import { useQuasar } from "quasar";
import { useRoute } from "vue-router";

const user = inject("$user");
const q$ = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Validations
const myRule = (val) => (val ? true : "You must make a selection!");

const refsy = ref(null);
const reftermRec = ref(null);
const refitemType = ref(null);
const refdateProcess = ref(null);
const refAmount = ref(null);

const state = reactive({
  sy: "",
});

const item = reactive({
  itemType: "",
  year: "",
  month: "",
  dateProcess: "",
  amount: "",
  dateDeposit: "",
  remarks: "",
});

const etgOptions = ref([]);
const itemTypeOptions = ref([]);
const cards = ref([]);
const totalAmount = ref();

const termRecoptions = ref([]);
const globalSPAS = route.params.id;

const syList = ref([]);
const nameList = ref([]);
var syoptions2 = [];
const syoptions = ref(syoptions2);

// Fetching options for months and item types
const populateAll = async () => {
  var formData = new FormData();
  formData.append("id", globalSPAS);

  const termRecResponse = await axios.post("/read.php?readTermRec", formData);
  const processedData = termRecResponse.data.map((item) => {
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

  // Select Month

  await axios.get("/read.php?etgMonth").then((response) => {
    etgOptions.value = response.data;
  });

  // Select Items

  await axios.get("/read.php?readAllowance").then((response) => {
    itemTypeOptions.value = response.data;
  });

  // Select School Year
  await axios.get("/read.php?school_years").then((response) => {
    syoptions2 = response.data;
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

const populateitems = (item) => {
  // Ensure the item passed is the current item
  var formData = new FormData();
  formData.append("itemid", item.itemType); // use the item's type directly

  console.log(item.itemType); // Log the itemType for debugging

  axios.post("/read.php?itemids", formData).then(function (response) {
    item.amount = response.data.amount; // Update the amount directly on the item
  });
};

// Preset Value of card

const presetCard = {
  termwthRec: "", // Term preset value
  items: [
    {
      itemType: 1,
      year: "",
      month: "",
      dateProcess: "",
      amount: 8000,
      dateDeposit: "",
      remarks: "",
    },
    {
      itemType: 1,
      year: "",
      month: "",
      dateProcess: "",
      amount: 8000,
      dateDeposit: "",
      remarks: "",
    },
    {
      itemType: 1,
      year: "",
      month: "",
      dateProcess: "",
      amount: 8000,
      dateDeposit: "",
      remarks: "",
    },
    {
      itemType: 1,
      year: "",
      month: "",
      dateProcess: "",
      amount: 8000,
      dateDeposit: "",
      remarks: "",
    },
    {
      itemType: 1,
      year: "",
      month: "",
      dateProcess: "",
      amount: 8000,
      dateDeposit: "",
      remarks: "",
    },
  ],
};

// Function to create a new card with empty fields
const addNewCard = () => {
  cards.value.push({
    termwthRec: "",
    items: [],
  });
};

// Function to add a new item to a specific card
const addNewItem = (cardIndex) => {
  cards.value[cardIndex].items.push({
    itemType: "", // Initialize itemType
    year: "",
    month: "",
    dateProcess: "", // Empty field for new item
    amount: 0, // Initialize amount to 0
    dateDeposit: "", // Empty field for new item
    remarks: "",
  });
};

// Function to remove an item from a specific card
const removeItem = (cardIndex, itemIndex) => {
  cards.value[cardIndex].items.splice(itemIndex, 1);
};

// Function to remove the entire card
const removeCard = (cardIndex) => {
  cards.value.splice(cardIndex, 1);
};

const formattedTotalAmount = computed(() => {
  const total = cards.value.reduce((total, card) => {
    return (
      total +
      card.items.reduce((cardTotal, item) => {
        const amount = parseFloat(item.amount); // Ensure it's a number
        return cardTotal + (isNaN(amount) ? 0 : amount); // Add 0 if amount is NaN
      }, 0)
    );
  }, 0);

  return new Intl.NumberFormat("en-PH", {
    style: "currency",
    currency: "PHP",
  }).format(total);
});

const printReceipt = () => {
  alert("Please click OK to print PDF");

  var formData = new FormData();

  formData.append("spasid", globalSPAS);

  formData.append("sy", state.sy);

  cards.value.forEach((card, cardIndex) => {
    // Append termwthRec as a JSON string for the card
    const termwthRecJson = JSON.stringify(card.termwthRec.label);
    formData.append(`card[${cardIndex}][termwthRec]`, termwthRecJson);

    card.items.forEach((item, itemIndex) => {
      // Append each item property as a JSON string
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][itemType]`,
        JSON.stringify(item.itemType.item)
      );
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][year]`,
        JSON.stringify(item.year)
      );
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][month]`,
        JSON.stringify(item.month)
      );
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][dateProcess]`,
        JSON.stringify(item.dateProcess)
      );
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][amount]`,
        JSON.stringify(item.amount)
      );
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][dateDeposit]`,
        JSON.stringify(item.dateDeposit)
      );
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][remarks]`,
        JSON.stringify(item.remarks)
      );

      // Append the termwthRec value to each item as well
      formData.append(
        `card[${cardIndex}][items][${itemIndex}][termwthRec]`,
        termwthRecJson
      );
    });
  });

  // Log each entry in FormData as a JSON string
  // for (let [key, value] of formData.entries()) {
  //   console.log(key, value);
  // }

  formData.append("amount", formattedTotalAmount.value);

  axios
    .post("/create.php?printReceipt", formData, { responseType: "blob" })
    .then(function (response) {
      var file = new Blob([response.data], { type: "application/pdf" });
      var fileURL = URL.createObjectURL(file);
      window.open(fileURL);
    });
};

onMounted(() => {
  populateAll(); // Fetch options on component mount
  cards.value.push(presetCard);
});
</script>

<style scoped>
.q-mt-md {
  margin-top: 16px;
}
</style>
