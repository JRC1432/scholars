<template>
  <div>
    <div class="row items-center q-pb-xl q-pa-md">
      <q-icon name="history_edu" size="md" class="q-mr-sm" color="primary" />
      <div class="text-h6 text-bold">Memorandum Templates</div>
    </div>

    <!-- Search Bar -->
    <div class="q-pa-md">
      <q-input
        v-model="searchQuery"
        outlined
        debounce="300"
        placeholder="SEARCH TEMPLATES..."
        clearable
      />
    </div>

    <!-- Memo Templates -->
    <div class="q-pa-md row items-start q-gutter-md justify-center">
      <q-card
        v-for="(template, index) in filteredTemplates"
        :key="index"
        class="my-card rounded-borders-10 hover-card"
        bordered
        hoverable
      >
        <q-img :src="template.image" style="max-height: 180px" />

        <q-card-section>
          <q-btn
            fab
            :color="template.color"
            :icon="template.icon"
            class="absolute"
            style="top: 0; right: 12px; transform: translateY(-50%)"
          >
            <q-popup-proxy>
              <q-card>
                <img :src="template.preview" />
              </q-card>
            </q-popup-proxy>
            <q-tooltip
              transition-show="rotate"
              transition-hide="rotate"
              class="bg-primary"
            >
              Preview
            </q-tooltip>
          </q-btn>
          <div class="row no-wrap items-center">
            <div class="col text-h6 ellipsis">{{ template.title }}</div>
            <div
              class="col-auto text-grey text-caption q-pt-md row no-wrap items-center"
            >
              <!-- <q-icon name="place" />
              {{ template.distance }} -->
            </div>
          </div>
          <!-- <q-rating v-model="template.stars" :max="5" size="32px" /> -->
        </q-card-section>

        <q-card-section class="q-pt-none q-card-sec">
          <div class="text-subtitle1">{{ template.subtitle }}</div>
          <div class="text-caption text-grey">
            {{ template.description }}
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions class="row justify-center">
          <q-btn
            rounded
            flat
            color="primary"
            @click="callFunction(template.btn)"
          >
            Use this template
          </q-btn>
        </q-card-actions>
      </q-card>

      <q-dialog v-model="terminate" persistent>
        <TerminateMemo />
      </q-dialog>

      <q-dialog v-model="submitgrades" persistent>
        <SubmitGradesMemo />
      </q-dialog>

      <q-dialog v-model="continued" persistent>
        <ContinuedMemo />
      </q-dialog>

      <q-dialog v-model="partialallowance" persistent>
        <PartialAllowanceMemo />
      </q-dialog>

      <q-dialog v-model="scholarstats" persistent>
        <ScholarStatsMemo />
      </q-dialog>
    </div>
  </div>
</template>

<script setup>
import TerminateMemo from "../components/TerminateMemo.vue";
import SubmitGradesMemo from "@/components/SubmitGradesMemo.vue";
import ContinuedMemo from "@/components/ContinuedMemo.vue";
import PartialAllowanceMemo from "@/components/PartialAllowanceMemo.vue";
import ScholarStatsMemo from "@/components/ScholarStatsMemo.vue";

import { ref, computed, onMounted, watch } from "vue";
import { IconUserCancel } from "@tabler/icons-vue";
import jsPDF from "jspdf";
import JsBarcode from "jsbarcode";
import "jspdf-autotable";

const searchQuery = ref("");
const terminate = ref(false);
const submitgrades = ref(false);
const continued = ref(false);
const scholarstats = ref(false);
const partialallowance = ref(false);

// Sample template data
const memoTemplates = ref([
  {
    title: "Scholar",
    image: new URL("../assets/scholars.avif", import.meta.url).href, // Corrected path
    distance: "250 ft",
    stars: 4,
    subtitle: "Scholar Status",
    description: "S&T SCHOLARSHIP STATUS",
    icon: "school",
    color: "green-4",
    btn: "openScholarstats",
    preview: new URL("../assets/scholarstats.png", import.meta.url).href,
  },

  {
    title: "Partial Allowance",
    image: new URL("../assets/money.png", import.meta.url).href, // Corrected path
    distance: "250 ft",
    stars: 5,
    subtitle: "Continued w/ Partial Allowance",
    description: "S&T SCHOLARSHIP STATUS CONTINUED WITH PARTIAL ALLOWANCE",
    icon: "volunteer_activism",
    color: "orange-4",
    btn: "openPartialAllowance",
    preview: new URL("../assets/partialAllowance.png", import.meta.url).href,
  },
  {
    title: "Continued",
    image: new URL("../assets/continue.png", import.meta.url).href, // Corrected path
    distance: "250 ft",
    stars: 5,
    subtitle: "Continued Scholars",
    description: "S&T SCHOLARSHIP STATUS - CONTINUED",
    icon: "autorenew",
    color: "purple-4",
    btn: "openContinued",
    preview: new URL("../assets/continuedstats.png", import.meta.url).href,
  },
  {
    title: "Submit Grades",
    image: new URL("../assets/notice.avif", import.meta.url).href, // Corrected path
    distance: "250 ft",
    stars: 5,
    subtitle: "Completion",
    description:
      "S&T SCHOLARSHIP STATUS CONTINUED: TO SUBMIT GRADES UPON COMPLETION",
    icon: "task",
    color: "pink-4",
    btn: "openSubmitGrades",
    preview: new URL("../assets/submitgrades.png", import.meta.url).href,
  },
  {
    title: "Terminate",
    image: new URL("../assets/terminated.jpg", import.meta.url).href, // Corrected path
    distance: "250 ft",
    stars: 5,
    subtitle: "Terminate Scholars",
    description: "S&T SCHOLARSHIP STATUS - TERMINATED WITH SERVICE OBLIGATION",
    icon: "cancel",
    color: "red-4",
    btn: "openTerminate",
    preview: new URL("../assets/terminatememo.png", import.meta.url).href,
  },

  // Add more templates here...
]);

// Filtered templates based on search query
const filteredTemplates = computed(() =>
  memoTemplates.value.filter((template) =>
    template.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
);

const callFunction = (btn) => {
  if (btn === "openTerminate") {
    terminate.value = true;
  } else if (btn === "openSubmitGrades") {
    submitgrades.value = true;
  } else if (btn === "openContinued") {
    continued.value = true;
  } else if (btn === "openPartialAllowance") {
    partialallowance.value = true;
  } else if (btn === "openScholarstats") {
    scholarstats.value = true;
  }
};
</script>

<style scoped>
.my-card {
  max-width: 300px;
  width: 100%;
  min-height: 400px;
  height: 400px;
}

.q-card-sec {
  min-height: 100px !important;
}

.hover-card {
  transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
  transform: translateY(-6px); /* Lift effect */
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3); /* Stronger shadow effect */
}

/* Add spacing between images */
.marquee-container {
  display: flex; /* Ensure images align properly */
  gap: 16px; /* Space between images */
}

.marquee-image {
  margin: 0 100px; /* Optional: Add spacing around each image */
}

.container {
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
}
</style>
