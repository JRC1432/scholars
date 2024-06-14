<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Scholarship Informations
      </div>
      <q-separator class="q-mt-md q-mb-xs" inset />

      <div class="q-pa-md">
        <div class="text-subtitle1 primary-text text-bold">
          Service Obligation Status:
          <text class="on-surface-text">{{ servObStats }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Service Obligation Years:
          <text class="on-surface-text">{{ servObYrs }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Mode of Clearance:
          <text class="on-surface-text">{{ modClear }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Year Cleared:
          <text class="on-surface-text">{{ yrClear }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Clearance Date:
          <text class="on-surface-text">{{ clearDate }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Refunded Amount:
          <text class="on-surface-text">{{ refAmount }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Remarks:
          <text class="on-surface-text">{{ remarks }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          TOR Submitted:
          <text class="on-surface-text">{{ torSub }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Date TOR Submitted:
          <text class="on-surface-text">{{ dateTor }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Diploma Submitted:
          <text class="on-surface-text">{{ dipSub }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Date Diploma Submitted:
          <text class="on-surface-text">{{ dateDipSub }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Certificate of Graduation Submitted:
          <text class="on-surface-text">{{ certGradSub }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Date Certificate of Graduation Submitted:
          <text class="on-surface-text">{{ dateCertGrad }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Academic Award:
          <text class="on-surface-text">{{ acadAward }}</text>
        </div>
        <div class="text-subtitle1 primary-text text-bold">
          Board Passer:
          <text class="on-surface-text">{{ boardPass }}</text>
        </div>
      </div>
    </q-card>
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Items Variables

const servObStats = ref(null);
const servObYrs = ref(null);
const modClear = ref(null);
const yrClear = ref(null);
const clearDate = ref(null);
const refAmount = ref(null);
const remarks = ref(null);
const torSub = ref(null);
const dateTor = ref(null);
const dipSub = ref(null);
const dateDipSub = ref(null);
const certGradSub = ref(null);
const dateCertGrad = ref(null);
const acadAward = ref(null);
const boardPass = ref(null);

const id = ref();
onMounted(() => {
  readGradObTrack();
});

const readGradObTrack = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readGRObTrackInfo", formData).then((response) => {
    servObStats.value = response.data.so;
    servObYrs.value = response.data.so_years;
    modClear.value = response.data.mode_of_clearance;
    yrClear.value = response.data.year_cleared;
    clearDate.value = response.data.clearance_date;
    refAmount.value = response.data.refunded_amt;
    remarks.value = response.data.remarks;
    torSub.value = response.data.tor;
    dateTor.value = response.data.tor_submitted;
    dipSub.value = response.data.diploma;
    dateDipSub.value = response.data.diploma_submitted;
    certGradSub.value = response.data.cert;
    dateCertGrad.value = response.data.cert_submitted;
    acadAward.value = response.data.acad_award;
    boardPass.value = response.data.board_pass;
  });
};
</script>
