<template>
  <div class="q-pa-md">
    <div class="col-xs-12 col-sm-6">
      <div class="q-col-gutter-md row items-start">
        <div class="col-xs-12 col-sm-12 col-md-9">
          <q-banner class="tertiary-container rounded-borders-10 text-h1">
            <div class="col-xs-12 col-sm-6">
              <div class="q-col-gutter-md row items-start justify-between">
                <div class="col-xs-12 col-sm-12 col-md-4">
                  <div class="text-h6">
                    Hello
                    <strong class="primary-text text-bold">{{
                      user.username
                    }}</strong
                    >!! 🎉
                  </div>

                  <div class="text-body1 text-weight-medium">
                    Welcome You Are Now Login To The System!!
                  </div>

                  <q-separator class="q-mt-md q-mb-xs" />
                  <div class="text-h7">
                    <strong class="primary-text text-bold"
                      >Employee ID:
                    </strong>
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
                    <strong class="primary-text text-bold">Email: </strong>
                    <text class="text-weight-bold">{{ userMails }}</text>
                  </div>
                </div>
                <div
                  class="col-xs-12 col-sm-6 col-md-4 row justify-end hide-small"
                >
                  <div class="absolute" style="top: 10px">
                    <Vue3Lottie
                      animationLink="https://lottie.host/0ad26d58-6934-435a-a467-4bad2176fbfe/UcnlcscUIL.json"
                      :height="300"
                      :width="300"
                    />
                  </div>
                </div>
              </div>
            </div>
          </q-banner>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
          <q-banner class="surface-container rounded-borders-10 text-h1">
            <div class="row justify-center items-center" style="height: 70px">
              <q-icon name="school" size="xl" class="primary-text"></q-icon>
            </div>
            <div class="q-py-sm text-h4 text-bold primary-text text-center">
              <vue3-autocounter
                ref="counter"
                :startAmount="0"
                :endAmount="meritcounts + ra10612counts + ra7687counts"
                :duration="3"
                class="text-bold"
              />
            </div>
            <div class="text-center text-h5">Total Number of Scholars:</div>
          </q-banner>
        </div>
      </div>
    </div>
  </div>

  <div class="q-pa-md">
    <div class="col-xs-12 col-sm-6">
      <div class="q-col-gutter-md row">
        <div class="col-xs-12 col-sm-6 col-md-8">
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
                      style="height: 348px"
                    />
                  </div>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card-section>
              <div class="text-h6 text-bold primary-text">All Data</div>
            </q-card-section>
            <q-card-section class="q-pa-md">
              <Pie
                :data="allData"
                :options="allOptions"
                :height="250"
                :width="250"
              />
            </q-card-section>
            <q-card-section>
              <q-markup-table class="no-shadow surface-container">
                <thead>
                  <tr>
                    <th class="text-center primary-text text-bold">
                      Good Standing
                    </th>
                    <th class="text-center primary-text text-bold">LOA</th>
                    <th class="text-center primary-text text-bold">
                      No Report
                    </th>
                    <th class="text-center primary-text text-bold">
                      On Extension
                    </th>
                    <th class="text-center primary-text text-bold">
                      Suspended
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center q-td--no-hover">
                      {{ allG_standing }}
                    </td>
                    <td class="text-center q-td--no-hover">{{ all_Loa }}</td>
                    <td class="text-center q-td--no-hover">
                      {{ all_Reports }}
                    </td>
                    <td class="text-center q-td--no-hover">
                      {{ all_Extension }}
                    </td>
                    <td class="text-center q-td--no-hover">
                      {{ all_Suspended }}
                    </td>
                  </tr>
                </tbody>
              </q-markup-table>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>
  </div>

  <div class="q-pa-md">
    <div class="col-xs-12 col-sm-6">
      <div class="q-col-gutter-md row">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card class="surface-container no-shadow rounded-borders-10">
              <div class="row">
                <div class="col-2 q-pa-md">
                  <div
                    class="row justify-center items-center"
                    style="height: 70px"
                  >
                    <q-icon
                      name="workspace_premium"
                      size="xl"
                      class="primary-text"
                    ></q-icon>
                  </div>
                </div>
                <div class="col-10 surface-container rounded-borders-10">
                  <div class="row items-center" style="height: 95px">
                    <div class="q-ml-md">
                      <div
                        class="text-h4 text-bold primary-text"
                        id="number_up"
                      >
                        <vue3-autocounter
                          ref="counter"
                          :startAmount="0"
                          :endAmount="meritcounts"
                          :duration="3"
                          class="text-bold"
                        />
                      </div>
                      <div id="number_up"></div>
                      <div class="text-subtitle2">MERIT:</div>
                    </div>
                  </div>
                </div>
              </div>
            </q-card>

            <q-card-section class="q-pa-md">
              <Doughnut
                :data="data"
                :options="options"
                :height="195"
                :width="195"
              />
            </q-card-section>
            <q-card-section>
              <q-markup-table class="no-shadow surface-container">
                <thead>
                  <tr>
                    <th class="text-center primary-text text-bold">
                      Good Standing
                    </th>
                    <th class="text-center primary-text text-bold">LOA</th>
                    <th class="text-center primary-text text-bold">
                      No Report
                    </th>
                    <th class="text-center primary-text text-bold">
                      On Extension
                    </th>
                    <th class="text-center primary-text text-bold">
                      Suspended
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center q-td--no-hover">{{ mgstanding }}</td>
                    <td class="text-center q-td--no-hover">{{ mloa }}</td>
                    <td class="text-center q-td--no-hover">{{ mnreport }}</td>
                    <td class="text-center q-td--no-hover">{{ mextension }}</td>
                    <td class="text-center q-td--no-hover">{{ msuspended }}</td>
                  </tr>
                </tbody>
              </q-markup-table>
            </q-card-section>
          </q-card>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card class="surface-container no-shadow rounded-borders-10">
              <div class="row">
                <div class="col-2 q-pa-md">
                  <div
                    class="row justify-center items-center"
                    style="height: 70px"
                  >
                    <q-icon
                      name="military_tech"
                      size="xl"
                      class="primary-text"
                    ></q-icon>
                  </div>
                </div>
                <div class="col-10 surface-container rounded-borders-10">
                  <div class="row items-center" style="height: 95px">
                    <div class="q-ml-md">
                      <div class="text-h4 text-bold primary-text">
                        <vue3-autocounter
                          ref="counter"
                          :startAmount="0"
                          :endAmount="ra10612counts"
                          :duration="3"
                          class="text-bold"
                        />
                      </div>
                      <div class="text-subtitle2">RA 10612:</div>
                    </div>
                  </div>
                </div>
              </div>
            </q-card>
            <q-card-section class="q-pa-md">
              <Doughnut
                :data="datas"
                :options="doptions"
                :height="195"
                :width="195"
              />
            </q-card-section>

            <q-card-section>
              <q-markup-table class="no-shadow surface-container">
                <thead>
                  <tr>
                    <th class="text-center primary-text text-bold">
                      Good Standing
                    </th>
                    <th class="text-center primary-text text-bold">LOA</th>
                    <th class="text-center primary-text text-bold">
                      No Report
                    </th>
                    <th class="text-center primary-text text-bold">
                      On Extension
                    </th>
                    <th class="text-center primary-text text-bold">
                      Suspended
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center q-td--no-hover">
                      {{ ra1gstanding }}
                    </td>
                    <td class="text-center q-td--no-hover">{{ ra1LOA }}</td>
                    <td class="text-center q-td--no-hover">{{ ra1nreport }}</td>
                    <td class="text-center q-td--no-hover">
                      {{ ra1extension }}
                    </td>
                    <td class="text-center q-td--no-hover">
                      {{ ra1suspended }}
                    </td>
                  </tr>
                </tbody>
              </q-markup-table>
            </q-card-section>
          </q-card>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <q-card class="my-card surface-container rounded-borders-10">
            <q-card class="surface-container no-shadow rounded-borders-10">
              <div class="row">
                <div class="col-2 q-pa-md">
                  <div
                    class="row justify-center items-center"
                    style="height: 70px"
                  >
                    <q-icon
                      name="military_tech"
                      size="xl"
                      class="primary-text"
                    ></q-icon>
                  </div>
                </div>
                <div class="col-10 surface-container rounded-borders-10">
                  <div class="row items-center" style="height: 95px">
                    <div class="q-ml-md">
                      <div class="text-h4 text-bold primary-text">
                        <vue3-autocounter
                          ref="counter"
                          :startAmount="0"
                          :endAmount="ra7687counts"
                          :duration="3"
                          class="text-bold"
                        />
                      </div>
                      <div class="text-subtitle2">RA 7687:</div>
                    </div>
                  </div>
                </div>
              </div>
            </q-card>
            <q-card-section class="q-pa-md">
              <Doughnut
                :data="datar"
                :options="roptions"
                :height="195"
                :width="195"
              />
            </q-card-section>

            <q-card-section>
              <q-markup-table class="no-shadow surface-container">
                <thead>
                  <tr>
                    <th class="text-center primary-text text-bold">
                      Good Standing
                    </th>
                    <th class="text-center primary-text text-bold">LOA</th>
                    <th class="text-center primary-text text-bold">
                      No Report
                    </th>
                    <th class="text-center primary-text text-bold">
                      On Extension
                    </th>
                    <th class="text-center primary-text text-bold">
                      Suspended
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center q-td--no-hover">
                      {{ ra7gstanding }}
                    </td>
                    <td class="text-center q-td--no-hover">{{ ra7LOA }}</td>
                    <td class="text-center q-td--no-hover">
                      {{ ra7nreport }}
                    </td>
                    <td class="text-center q-td--no-hover">
                      {{ ra7extension }}
                    </td>
                    <td class="text-center q-td--no-hover">
                      {{ ra7suspended }}
                    </td>
                  </tr>
                </tbody>
              </q-markup-table>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>
  </div>

  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-tooltip class="primary">Year Adjustment</q-tooltip>
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
              style="max-width: 120px"
              clearable
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
              style="max-width: 120px"
              clearable
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
import { ref, onMounted, reactive, inject, computed, watch } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { Line, Doughnut, Pie } from "vue-chartjs";
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

const meritcounts = ref([]);
const ra10612counts = ref([]);
const ra7687counts = ref([]);

const allScholar = ref([]);
const allYear = ref([]);

// Merit Count
const mgstanding = ref(0);
const mloa = ref(0);
const mnreport = ref(0);
const mextension = ref(0);
const msuspended = ref(0);

// RA 10612

const ra1gstanding = ref(0);
const ra1LOA = ref(0);
const ra1nreport = ref(0);
const ra1extension = ref(0);
const ra1suspended = ref(0);

// RA 7687

const ra7gstanding = ref(0);
const ra7LOA = ref(0);
const ra7nreport = ref(0);
const ra7extension = ref(0);
const ra7suspended = ref(0);

const allG_standing = ref(0);
const all_Loa = ref(0);
const all_Reports = ref(0);
const all_Extension = ref(0);
const all_Suspended = ref(0);

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

const populateyears = async () => {
  var formData = new FormData();
  formData.append("frstYearSelect", state.frstYearSelect);
  formData.append("yearselect", state.yearselect);

  try {
    // Scholar Charts
    const responses = await Promise.all([
      axios.post("/read.php?LineDataScholar", formData),
      axios.post("/read.php?meritCountStanding", formData),
      axios.post("/read.php?meritCountLoa", formData),
      axios.post("/read.php?meritCountNReport", formData),
      axios.post("/read.php?meritCountOExtension", formData),
      axios.post("/read.php?meritCountSuspended", formData),
      axios.post("/read.php?ra1CountGStanding", formData),
      axios.post("/read.php?ra1CountLOA", formData),
      axios.post("/read.php?ra1CountNreport", formData),
      axios.post("/read.php?ra1CountExtension", formData),
      axios.post("/read.php?ra1CountSuspended", formData),
      axios.post("/read.php?ra7CountGStanding", formData),
      axios.post("/read.php?ra7CountLoa", formData),
      axios.post("/read.php?ra7CountNreport", formData),
      axios.post("/read.php?ra7CountExtension", formData),
      axios.post("/read.php?ra7CountSuspended", formData),
      axios.post("/read.php?merit", formData),
      axios.post("/read.php?ra10612", formData),
      axios.post("/read.php?ra7687", formData),
    ]);

    // Extract data from responses
    const [
      responseScholar,
      responseMeritStanding,
      responseMeritLoa,
      responseMeritNReport,
      responseMeritExtension,
      responseMeritSuspended,
      responseRa1GStanding,
      responseRa1LOA,
      responseRa1NReport,
      responseRa1Extension,
      responseRa1Suspended,
      responseRa7GStanding,
      responseRa7LOA,
      responseRa7NReport,
      responseRa7Extension,
      responseRa7Suspended,
      responsemeritcount,
      responsera10612count,
      responsera7687count,
    ] = responses.map((response) => response.data);

    // Assign values to variables
    allYear.value = responseScholar.year;
    allScholar.value = responseScholar.scholar;
    mgstanding.value = responseMeritStanding.merit_g_standing;
    mloa.value = responseMeritLoa.merit_loa;
    mnreport.value = responseMeritNReport.merit_nreport;
    mextension.value = responseMeritExtension.merit_extension;
    msuspended.value = responseMeritSuspended.merit_suspended;
    ra1gstanding.value = responseRa1GStanding.ra1_g_standing;
    ra1LOA.value = responseRa1LOA.ra1_loa;
    ra1nreport.value = responseRa1NReport.ra1_nreport;
    ra1extension.value = responseRa1Extension.ra1_extension;
    ra1suspended.value = responseRa1Suspended.ra1_suspended;
    ra7gstanding.value = responseRa7GStanding.ra7_g_standing;
    ra7LOA.value = responseRa7LOA.ra7_loa;
    ra7nreport.value = responseRa7NReport.ra7_nreport;
    ra7extension.value = responseRa7Extension.ra7_extension;
    ra7suspended.value = responseRa7Suspended.ra7_suspended;
    meritcounts.value = responsemeritcount.meritcount;
    ra10612counts.value = responsera10612count.ra10612count;
    ra7687counts.value = responsera7687count.ra7687count;

    // Calculate allG_standing.value
    allG_standing.value =
      mgstanding.value + ra1gstanding.value + ra7gstanding.value;
    // LOA
    all_Loa.value = mloa.value + ra1LOA.value + ra7LOA.value;
    all_Reports.value = mnreport.value + ra1nreport.value + ra7nreport.value;
    all_Extension.value =
      mextension.value + ra1extension.value + ra7extension.value;
    all_Suspended.value =
      msuspended.value + ra1suspended.value + ra7suspended.value;

    console.log(all_Loa.value);
  } catch (error) {
    console.error("Error fetching data:", error);
    // Handle errors here
  }
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
          "#4BC0C0",
          "#B2C0E1",
          "#E1C27F",
          "#FFFFFF",
          "#E2A1C9",
        ],
        data: [
          mgstanding.value,
          mloa.value,
          mnreport.value,
          mextension.value,
          msuspended.value,
        ],
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
    labels: ["Good Standing", "LOA", "No Report", "On Extension", "Suspended"],
    datasets: [
      {
        backgroundColor: [
          "#4BC0C0",
          "#B2C0E1",
          "#E1C27F",
          "#FFFFFF",
          "#E2A1C9",
        ],
        data: [
          ra1gstanding.value,
          ra1LOA.value,
          ra1nreport.value,
          ra1extension.value,
          ra1suspended.value,
        ],
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

// Pie Data for RA 10612

const datar = computed(() => {
  return {
    labels: ["Good Standing", "LOA", "No Report", "On Extension", "Suspended"],
    datasets: [
      {
        backgroundColor: [
          "#4BC0C0",
          "#B2C0E1",
          "#E1C27F",
          "#FFFFFF",
          "#E2A1C9",
        ],
        data: [
          ra7gstanding.value,
          ra7LOA.value,
          ra7nreport.value,
          ra7extension.value,
          ra7suspended.value,
        ],
        borderWidth: 0,
      },
    ],
  };
});

const roptions = {
  responsive: true,
  cutout: 50,
  maintainAspectRatio: false,
};

// Pie Data for All

const allData = computed(() => {
  return {
    labels: ["Good Standing", "LOA", "No Report", "On Extension", "Suspended"],
    datasets: [
      {
        backgroundColor: [
          "#4BC0C0",
          "#B2C0E1",
          "#E1C27F",
          "#FFFFFF",
          "#E2A1C9",
        ],
        data: [
          allG_standing.value,
          all_Loa.value,
          all_Reports.value,
          all_Extension.value,
          all_Suspended.value,
        ],
        borderWidth: 0,
      },
    ],
  };
});

const allOptions = {
  responsive: true,

  maintainAspectRatio: false,
};

// Read Users Email
const userMails = ref("");

const userID = user.id;

onMounted(() => {
  populateUserMail();
});

const populateUserMail = () => {
  console.log(userID);
  var formData = new FormData();
  formData.append("idMail", userID);
  axios.post("/read.php?readUserMail", formData).then((response) => {
    userMails.value = response.data.email;
  });
};
</script>

<style scoped>
@media screen and (max-width: 1000px) {
  .hide-small {
    display: none;
  }
}
</style>
