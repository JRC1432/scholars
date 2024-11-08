<template>
  <div class="q-mb-md q-px-lg">
    <q-btn
      color="primary"
      icon="reply"
      label="BACK"
      rounded
      flat
      to="/scholar"
    />
  </div>
  <div class="q-px-lg">
    <div class="tertiary-container text-black rounded-borders-20">
      <q-toolbar>
        <q-btn flat round dense icon="assignment_ind" class="primary-text" />

        <q-toolbar-title class="text-bold primary-text"
          >{{ fnameScholar }}
        </q-toolbar-title>

        <div class="q-mr-xs">
          <div class="text-bold primary-text">{{ spasid }}</div>
        </div>
      </q-toolbar>

      <q-toolbar padding>
        <!-- or inset -->
        <q-breadcrumbs class="primary-text" style="font-size: 14px" gutter="xs">
          <template #separator> <q-icon name="arrow_right" /> </template>

          <q-breadcrumbs-el
            label="Personal Info"
            icon="person"
            :to="'/personal/' + scids"
            :class="
              route.name == 'personal'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          >
          </q-breadcrumbs-el>
          <q-breadcrumbs-el
            label="Scholarship Info"
            icon="school"
            :to="'/scholarinfo/' + scids"
            :class="
              route.name == 'scholarinfo'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Undergraduate Record"
            icon="history_edu"
            :to="'/undergradinfo/' + scids"
            :class="
              route.name == 'undergradinfo'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Status Record"
            icon="check_circle"
            :to="'/statsrecord/' + scids"
            :class="
              route.name == 'statsrecord'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Monitoring Sheet"
            icon="info"
            :to="'/monitorsheet/' + scids"
            :class="
              route.name == 'monitorsheet'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="High School Record"
            icon="inventory"
            :to="'/highschoolrec/' + scids"
            :class="
              route.name == 'highschoolrec'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Family Info"
            icon="diversity_3"
            :to="'/familyinfo/' + scids"
            :class="
              route.name == 'familyinfo'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Exam Info"
            icon="diversity_3"
            :to="'/examinfo/' + scids"
            :class="
              route.name == 'examinfo'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Graduate Obligation & Tracking Info"
            icon="gavel"
            :to="'/gradtrackinfo/' + scids"
            :class="
              route.name == 'gradtrackinfo'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
          <q-breadcrumbs-el
            label="Financial Assistance "
            icon="volunteer_activism"
            :to="'/financeassists/' + scids"
            :class="
              route.name == 'financeassists'
                ? 'primary-text text-bold on-primary q-px-md rounded-borders-10'
                : 'primary-text text-bold '
            "
          />
        </q-breadcrumbs>
      </q-toolbar>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

const user = inject("$user");
const axios = inject("$axios");
const route = useRoute();
const scids = route.params.id;
const fnameScholar = ref();
const spasid = ref();

const id = ref();
onMounted(() => {
  readscholar();
});

const readscholar = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readScholarID", formData).then((response) => {
    fnameScholar.value = response.data.full_name;
    spasid.value = response.data.spas_id;
  });
};
</script>
