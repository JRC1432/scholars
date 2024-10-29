<template>
  <q-page padding class="q-pa-lg">
    <q-card class="rounded-borders-20">
      <form>
        <q-banner inline-actions class="banner-2">
          <div class="text-subtitle1">Financial Statements</div>

          <!-- Button to create a new card -->
          <template v-slot:action>
            <q-btn
              rounded
              color="primary"
              label="Add New Month"
              @click="addNewCard"
              icon="add"
            />
          </template>
        </q-banner>

        <div class="q-pa-md">
          <span class="text-bold">Academic Year:</span>
          <q-input
            ref="refsy"
            name="sy"
            v-model="state.sy"
            outlined
            dense
            hide-bottom-space
            label="####-####"
            mask="####-####"
            style="width: 100px"
          />
        </div>

        <!-- Dynamically render cards with a remove card button -->
        <q-card-section v-for="(card, cardIndex) in cards" :key="cardIndex">
          <q-card class="my-card bordered">
            <q-banner inline-actions class="banner-6">
              <div class="q-pa-xs">
                <div class="row row_width q-col-gutter-sm">
                  <div class="col-xs-12 col-sm-6 col-md-4">
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
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="q-px-sm">
                      <span class="text-bold">Year</span>
                      <q-input
                        ref="refYear"
                        name="year"
                        v-model="card.year"
                        outlined
                        dense
                        hide-bottom-space
                        mask="####"
                        label="####"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="q-px-sm">
                      <span class="text-bold">Month</span>
                      <q-select
                        ref="refmonth"
                        :options="etgOptions"
                        v-model="card.month"
                        name="month"
                        emit-value
                        outlined
                        dense
                        use-input
                        map-options
                        hide-bottom-space
                        :rules="[myRule]"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </q-banner>

            <div class="q-pa-md">
              <q-btn
                rounded
                color="primary"
                label="Add Item"
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
                  <div class="col-xs-12 col-sm-6 col-md-4">
                    <q-select
                      ref="refitemType"
                      v-model="item.itemType"
                      name="itemType"
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
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <q-input
                      v-model="item.dateProcess"
                      label="Date Process"
                      dense
                      outlined
                      type="date"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <q-input
                      v-model="item.amount"
                      label="Amount"
                      dense
                      outlined
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <q-input
                      v-model="item.dateDeposit"
                      label="Date Deposit"
                      dense
                      outlined
                      type="date"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2 q-gutter-none">
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
              label="Remove Month"
              icon="delete"
              @click="removeCard(cardIndex)"
            />
          </div>

          <div class="q-pa-xs"><q-separator color="orange" inset /></div>
        </q-card-section>

        <q-card-section>
          <q-chip outline color="teal" text-color="white" icon="payments">
            Total Amount: {{ formattedTotalAmount }}
          </q-chip>
        </q-card-section>

        <q-card-actions class="q-pa-md row justify-end">
          <q-btn type="submit">SUBMIT</q-btn>
        </q-card-actions>
      </form>
    </q-card>
  </q-page>
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

const state = reactive({
  sy: "",
});

const etgOptions = ref([]);
const itemTypeOptions = ref([]);
const cards = ref([]);

const termRecoptions = ref([]);
const globalSPAS = route.params.id;

const syList = ref([]);
const nameList = ref([]);

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

  await axios.get("/read.php?etgMonth").then((response) => {
    etgOptions.value = response.data;
  });

  await axios.get("/read.php?readAllowance").then((response) => {
    itemTypeOptions.value = response.data;
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

// Function to create a new card with empty fields
const addNewCard = () => {
  cards.value.push({
    semsy: "",
    year: "",
    month: "",
    items: [],
  });
};

// Function to add a new item to a specific card
const addNewItem = (cardIndex) => {
  cards.value[cardIndex].items.push({
    itemType: "", // Initialize itemType
    dateProcess: "", // Empty field for new item
    amount: 0, // Initialize amount to 0
    dateDeposit: "", // Empty field for new item
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

onMounted(() => {
  populateAll(); // Fetch options on component mount
});
</script>

<style scoped>
.q-mt-md {
  margin-top: 16px;
}
</style>
