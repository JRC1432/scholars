<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Graduate Obligation & Tracking Informations
      </div>
      <q-separator class="q-mt-md q-mb-xs" inset />

      <div style="display: flex; justify-content: center">
        <div class="q-pa-xl" style="width: fit-content">
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">
                  Service Obligation Status:
                </td>
                <td class="on-surface-text text-bold">{{ servObStats }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">
                  Service Obligation Years:
                </td>
                <td class="on-surface-text text-bold">{{ servObYrs }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Mode of Clearance:</td>
                <td class="on-surface-text text-bold">{{ modClear }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Year Cleared:</td>
                <td class="on-surface-text text-bold">{{ yrClear }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Clearance Date:</td>
                <td class="on-surface-text text-bold">{{ clearDate }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Refunded Amount:</td>
                <td class="on-surface-text text-bold">{{ refAmount }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Remarks:</td>
                <td class="on-surface-text text-bold">{{ remarks }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">TOR Submitted:</td>
                <td class="on-surface-text text-bold">{{ torSub }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Date TOR Submitted:</td>
                <td class="on-surface-text text-bold">{{ dateTor }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Diploma Submitted::</td>
                <td class="on-surface-text text-bold">{{ dipSub }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Date Diploma Submitted</td>
                <td class="on-surface-text text-bold">{{ dateDipSub }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">
                  Certificate of Graduation Submitted:
                </td>
                <td class="on-surface-text text-bold">{{ certGradSub }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">
                  Date Certificate of Graduation Submitted:
                </td>
                <td class="on-surface-text text-bold">{{ dateCertGrad }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Academic Award:</td>
                <td class="on-surface-text text-bold">{{ acadAward }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Board Passer:</td>
                <td class="on-surface-text text-bold">{{ boardPass }}</td>
              </tr>
            </tbody>
          </q-markup-table>
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
