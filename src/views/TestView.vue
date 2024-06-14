<template>
  <form id="" @submit.prevent.stop="populateyears">
    <div class="q-pa-md">
      <q-select
        hint="Start Year"
        outlined
        behavior="menu"
        emit-value
        map-options
        use-input
        input-debounce="0"
        label="Year From"
        v-model="state.frstYearSelect"
        name="frstYearSelect"
        :options="yrsoptions"
        @filter="filteryrs"
        @update:model-value="populateyears"
      >
        <template v-slot:no-option>
          <q-item>
            <q-item-section class="text-grey"> No results </q-item-section>
          </q-item>
        </template>
      </q-select>
    </div>

    <div class="q-pa-md">
      <q-select
        hint="End Year"
        outlined
        behavior="menu"
        emit-value
        map-options
        use-input
        input-debounce="0"
        label="Year To"
        v-model="state.yearselect"
        name="yearselect"
        :options="yrsoptions"
        @filter="filteryrs"
        @update:model-value="populateyears"
      >
        <template v-slot:no-option>
          <q-item>
            <q-item-section class="text-grey"> No results </q-item-section>
          </q-item>
        </template>
      </q-select>
    </div>

    <div class="q-pa-md">
      <q-card class="my-card surface-container rounded-borders-10">
        <div class="q-pa-lg">
          <Line id="my-chart-id" :options="chartOptions" :data="chartData" />
        </div>
      </q-card>
    </div>
  </form>
</template>

<script setup>
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
