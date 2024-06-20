<template>
  <div class="q-pa-md">
    <q-banner class="tertiary-container rounded-borders-10 text-h1">
      <div class="col-xs-12 col-sm-6">
        <div class="q-col-gutter-md row items-start">
          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="text-h6">
              Hello
              <strong class="primary-text text-bold">{{ user.username }}</strong
              >!! 🎉
            </div>

            <div class="text-body1 text-weight-medium">
              Welcome You Are Now Login To The System!!
            </div>

            <q-separator class="q-mt-md q-mb-xs" />
            <div class="text-h7">
              <strong class="primary-text text-bold">Employee ID: </strong>
              <text class="text-weight-bold">{{ user.internal_id }}</text>
            </div>
            <div class="text-h7">
              <strong class="primary-text text-bold">Name: </strong>
              <text class="text-weight-bold">{{ user.username }}</text>
            </div>
            <div class="text-h7">
              <strong class="primary-text text-bold">Region: </strong>
              <text class="text-weight-bold">{{ user.region }}</text>
            </div>
            <div class="text-h7">
              <strong class="primary-text text-bold">Email:</strong>
              <text class="text-weight-bold">{{}}</text>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4">
            <form id="" @submit.prevent.stop="populateyears">
              <div class="q-col-gutter-sm row item-end">
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="q-pl-xl q-pt-md">
                    <q-select
                      hint="Start Year"
                      behavior="menu"
                      emit-value
                      map-options
                      use-input
                      input-debounce="0"
                      label="From"
                      v-model="state.frstYearSelect"
                      name="frstYearSelect"
                      :options="yrsoptions"
                      @filter="filteryrs"
                      @update:model-value="populateyears"
                    >
                      <template v-slot:no-option>
                        <q-item>
                          <q-item-section class="text-grey">
                            No results
                          </q-item-section>
                        </q-item>
                      </template>
                    </q-select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                  <div class="q-pl-xl q-pt-md">
                    <q-select
                      hint="End Year"
                      behavior="menu"
                      emit-value
                      map-options
                      use-input
                      input-debounce="0"
                      label="To"
                      v-model="state.yearselect"
                      name="yearselect"
                      :options="yrsoptions"
                      @filter="filteryrs"
                      @update:model-value="populateyears"
                    >
                      <template v-slot:no-option>
                        <q-item>
                          <q-item-section class="text-grey">
                            No results
                          </q-item-section>
                        </q-item>
                      </template>
                    </q-select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="q-pa-md q-gutter-sm q-display-flex q-justify-end">
            <div class="col-xs-12 col-sm-6 col-md-4">
              <div
                class="fixed-right absolute-right fixed-top-right absolute-top-right"
              >
                <Vue3Lottie
                  animationLink="https://lottie.host/0ad26d58-6934-435a-a467-4bad2176fbfe/UcnlcscUIL.json"
                  style="height: calc(30vh)"
                  :height="500"
                  :width="500"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </q-banner>
  </div>
  <div class="q-pa-md">
    <DashCounter />
  </div>
  <div class="q-pa-md">
    <q-card class="my-card surface-container rounded-borders-10">
      <div class="q-pa-lg">
        <Line id="my-chart-id" :options="chartOptions" :data="chartData" />
      </div>
    </q-card>
  </div>
</template>

<script setup>
import DashCounter from "../components/DashCounter.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { Line } from "vue-chartjs";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Declared Variables

const state = reactive({
  frstYearSelect: 2016,
  yearselect: 2023,
});

const allScholar = ref([]);
const allYear = ref([]);

// BAck-End Code
// Showing Years

var yrsoptions2 = [];
const yrsoptions = ref(yrsoptions2);

onMounted(() => {
  populateyrs();
});

const populateyrs = () => {
  axios.get("/read.php?years").then((response) => {
    yrsoptions2 = response.data;
  });
};

const filteryrs = (val, update) => {
  if (val === "") {
    update(() => {
      yrsoptions.value = yrsoptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toString().toLowerCase();
    yrsoptions.value = yrsoptions2.filter((option) => {
      return option.label.toString().toLowerCase().includes(needle);
    });
  });
};

//Showing Years to Graphs

onMounted(() => {
  populateyears();
});

const populateyears = () => {
  var formData = new FormData();
  formData.append("frstYearSelect", state.frstYearSelect);
  formData.append("yearselect", state.yearselect);

  axios.post("/read.php?LineDataScholar", formData).then(function (response) {
    allYear.value = response.data.year;
    allScholar.value = response.data.scholar;
    console.log(response.data.yr_awarded);
    console.log(response.data.scholar);
  });
};

// Charts Configurations

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

const chartData = computed(() => {
  return {
    labels: allYear.value,
    datasets: [
      {
        label: "Scholars Charts",
        backgroundColor: "#01377D",
        data: allScholar.value,
        borderColor: "rgb(75, 192, 192)",
      },
    ],
  };
});

const chartOptions = ref({
  responsive: true,
  tooltip: {
    enabled: true, // Show tooltips always
  },
});
</script>
