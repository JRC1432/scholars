<template>
  <div class="q-pa-md" v-for="(term_fors, key) in term_for" :key="key">
    <q-card class="rounded-borders-20">
      <q-banner inline-actions class="bg-primary text-white">
        <text class="text-caption">{{ key }}</text>
        <div>
          <text class="text-subtitle1">SY: {{ term_fors.sy }}, </text>
          <text class="text-subtitle1" v-if="term_fors.term === 1"
            >1st Term
          </text>
          <text class="text-subtitle1" v-else-if="term_fors.term === 2"
            >2nd Term
          </text>
          <text class="text-subtitle1" v-else-if="term_fors.term === 3"
            >Mid Year
          </text>
          <text class="text-subtitle1" v-else>Summer </text>
          <q-badge
            v-if="term_fors.term_required === 1"
            align="top"
            color="positive"
            >Term Required</q-badge
          >
          <q-badge v-else align="top" color="negative"
            >Term Not Required</q-badge
          >
          <q-badge
            v-if="term_fors.reg_verified_flag === 1"
            align="top"
            color="positive"
            >Register Form Verified</q-badge
          >
          <q-badge v-else align="top" color="negative"
            >Register Form Not Verified</q-badge
          >
        </div>
        <div class="text-subtitle1">
          {{ term_fors.school }}, {{ term_fors.courses }}
        </div>

        <template v-slot:action>
          <q-btn flat color="white" label="EDIT" @click="editGradesBtn(key)" />
        </template>
      </q-banner>

      <q-table
        :rows="term_fors.term_id"
        :columns="columns"
        row-key="name"
        class="no-border"
        wrap-cells
        flat
        bordered
      />

      <q-card-section>
        <div>
          <text class="text-subtitle1">
            Start of Term Status: {{ term_fors.progress_status_start }} -
            {{ term_fors.standing_start }}
          </text>
        </div>
        <div>
          <text class="text-subtitle1">
            End of Term Status: {{ term_fors.progress_status_end }} -
            {{ term_fors.standing_end }}
          </text>
        </div>
        <div class="q-ml-auto text-right">
          <q-chip color="amber-8" icon="grade">
            General Weighted Average: {{ term_fors.grade_ave }}
          </q-chip>
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, computed, inject } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const rows = ref([]);

const columns = [
  {
    name: "subj_code",
    required: true,
    label: "Subject Code",
    align: "left",
    field: "subj_code",
    sortable: true,
  },
  {
    name: "unit",
    required: true,
    label: "Units",
    align: "left",
    field: "unit",
    sortable: true,
  },
  {
    name: "grade",
    required: true,
    label: "Grades",
    align: "left",
    field: "grade",
    sortable: true,
  },
  {
    name: "completion",
    required: true,
    label: "Completion",
    align: "left",
    field: "completion",
    sortable: true,
  },
  {
    name: "remarks",
    required: true,
    label: "Remarks",
    align: "left",
    field: "remarks",
    sortable: true,
  },
];

const globalSPAS = ref();

const term_for = ref([]);

// Axios

const populateAll = () => {
  var formData = new FormData();
  globalSPAS.value = route.params.id;

  formData.append("id", globalSPAS.value);

  // Read TermID For Loop
  axios.post("/read.php?readTermIds", formData).then((response) => {
    term_for.value = response.data;
  });
};

onMounted(() => {
  populateAll();
});

const editGradesBtn = (key) => {
  router.push({
    path: "/editgrades/" + key,
  });

  sessionStorage.setItem("spasid", JSON.stringify(globalSPAS.value));
};
</script>
