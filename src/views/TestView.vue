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
            <!-- <form id="" @submit.prevent.stop="populateyears">
              <div class="q-col-gutter-sm row item-end">
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="q-pl-xl q-pt-md" style="max-width: 200px">
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
                  <div class="q-pl-xl q-pt-md" style="max-width: 200px">
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
            </form> -->
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
    <div class="col-xs-12 col-sm-6">
      <div class="q-col-gutter-md row">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card-section>
              <div class="text-h6 text-bold primary-text">MERIT</div>
            </q-card-section>
            <q-card-section class="q-pa-md"
              ><Doughnut
                :data="data"
                :options="options"
                :height="195"
                :width="195"
            /></q-card-section>
          </q-card>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card-section>
              <div class="text-h6 text-bold primary-text">RA 10612</div>
            </q-card-section>
            <q-card-section class="q-pa-md">
              <Doughnut
                :data="data"
                :options="options"
                :height="195"
                :width="195"
              />
            </q-card-section>
          </q-card>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card-section>
              <div class="text-h6 text-bold primary-text">RA 7687</div>
            </q-card-section>
            <q-card-section class="q-pa-md">
              <Doughnut
                :data="data"
                :options="options"
                :height="195"
                :width="195"
              />
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>
  </div>

  <div class="q-pa-md">
    <q-card class="my-card surface-container rounded-borders-10">
      <div class="row items-center no-wrap q-mb-lg">
        <div class="col">
          <div class="q-pa-sm">
            <div class="text-h6 text-bold q-mb-md row items-center">
              <IconChartBar
                class="primary-text q-mr-sm"
                :size="40"
                stroke-width="2"
              />
              <span class="text-h6 text-bold primary-text">Scholar Charts</span>
            </div>
          </div>
        </div>
      </div>
      <q-card-section>
        <div class="row">
          <div class="col-12">
            <div class="row justify-center">
              <Line
                id="my-chart-id"
                :options="chartOptions"
                :data="chartData"
                style="height: 300px"
              />
            </div>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </div>

  <!-- <div class="q-pa-md">
    <div class="col-xs-12 col-sm-6">
      <div class="q-col-gutter-md row items-start">
        <div class="col-xs-12 col-sm-12 col-md-8">
          <q-card class="my-card surface-container rounded-borders-10">
            <div class="row items-center no-wrap q-mb-lg">
              <div class="col">
                <div class="q-pa-sm">
                  <div class="text-h6 text-bold q-mb-md row items-center">
                    <IconChartBar
                      class="primary-text q-mr-sm"
                      :size="40"
                      stroke-width="2"
                    />
                    <span class="text-h6 text-bold primary-text"
                      >Scholar Charts</span
                    >
                  </div>
                </div>
              </div>
            </div>
            <q-card-section>
              <div class="row">
                <div class="col-12">
                  <div class="row justify-center">
                    <Line
                      id="my-chart-id"
                      :options="chartOptions"
                      :data="chartData"
                    />
                  </div>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
        <div class="col-xs-12 q-gutter-y-lg col-sm-12 col-md-4">
          <q-card class="primary-text surface-container rounded-borders-20">
            <q-card-section>
              <div class="text-h6 text-bold">MERIT</div>
            </q-card-section>

            <q-card-section class="q-pa-md">
              <div class="q-pa-md">
                <q-card
                  flat
                  class="my-card white text-primary rounded-borders-20"
                >
                  <Doughnut
                    :data="data"
                    :options="options"
                    :height="195"
                    :width="195"
                  />
                </q-card>
              </div>
            </q-card-section>
          </q-card>
          <q-card class="primary-text surface-container rounded-borders-20">
            <q-card-section>
              <div class="text-h6 text-bold">RA 10612</div>
            </q-card-section>

            <q-card-section class="q-pa-md">
              <div class="q-pa-md">
                <q-card
                  flat
                  class="my-card white text-primary rounded-borders-20"
                >
                  <Doughnut
                    :data="datas"
                    :options="doptions"
                    :height="200"
                    :width="200"
                  />
                </q-card>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>
  </div> -->
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-fab
      icon="calendar_month"
      direction="up"
      class="primary-container"
      vertical-actions-align="right"
    >
      <form id="" @submit.prevent.stop="populateyears">
        <q-fab-action class="tertiary-container" padding="10px">
          <div class="q-px-sm">
            <span class="text-bold">Start Year</span>
            <q-select
              outlined
              dense
              behavior="menu"
              emit-value
              map-options
              use-input
              input-debounce="0"
              v-model="state.frstYearSelect"
              name="frstYearSelect"
              :options="yrsoptions"
              @filter="filteryrs"
              @update:model-value="populateyears"
              style="max-width: 80px"
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
        </q-fab-action>
        <q-fab-action class="tertiary-container" padding="10px">
          <div class="q-px-sm">
            <span class="text-bold">End Year</span>
            <q-select
              outlined
              dense
              behavior="menu"
              emit-value
              map-options
              use-input
              input-debounce="0"
              v-model="state.yearselect"
              name="yearselect"
              :options="yrsoptions"
              @filter="filteryrs"
              @update:model-value="populateyears"
              style="max-width: 80px"
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
        </q-fab-action>
      </form>
    </q-fab>
  </q-page-sticky>
</template>

<script setup>
import DashCounter from "../components/DashCounter.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { Line, Doughnut } from "vue-chartjs";
import {
  Chart as ChartJS,
  ArcElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";
import { IconChartBar } from "@tabler/icons-vue";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

ChartJS.register(
  ArcElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend
);

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

// ----- LINE GRAPH -----

const chartData = computed(() => {
  return {
    labels: allYear.value,
    datasets: [
      {
        label: "No. Of Scholars",
        backgroundColor: "#01377D",
        data: allScholar.value,
        borderColor: "rgb(75, 192, 192)",
      },
    ],
  };
});

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  tooltip: {
    enabled: true, // Show tooltips always
  },
});

// Pie Data for Merit

const data = computed(() => {
  return {
    labels: ["Good Standing", "LOA", "No Report", "On Extension", "Suspended"],
    datasets: [
      {
        backgroundColor: [
          "#A099E2",
          "#777094",
          "#E6DEFF",
          "#FFFBFF",
          "#C3E8FF",
        ],
        data: [60, 50, 100, 150, 200],
        borderWidth: 0,
      },
    ],
  };
});

const options = {
  responsive: true,
  cutout: 50,
  maintainAspectRatio: false,
};

// Pie Data for RA 10612

const datas = computed(() => {
  return {
    labels: ["Ongoing", "Graduated", "Terminated"],
    datasets: [
      {
        backgroundColor: ["#E6DEFF", "#FFFBFF", "#C3E8FF"],
        data: [10, 5, 20],
        borderWidth: 0,
      },
    ],
  };
});

const doptions = {
  responsive: true,
  cutout: 50,
  maintainAspectRatio: false,
};
</script>
