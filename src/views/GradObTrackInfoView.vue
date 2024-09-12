<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Graduate Obligation & Tracking Informations
      </div>

      <div
        style="display: flex; justify-content: center"
        v-if="
          servObStats ||
          servObYrs ||
          modClear ||
          yrClear ||
          clearDate ||
          refAmount ||
          remarks ||
          torSub ||
          dateTor ||
          dipSub ||
          dateDipSub ||
          certGradSub ||
          dateCertGrad ||
          acadAward ||
          boardPass
        "
      >
        <div class="q-pa-xl" style="width: fit-content">
          <q-markup-table
            separator="cell"
            flat
            bordered
            class="rounded-borders-20 banner"
          >
            <tbody>
              <tr>
                <td class="primary-text text-bold">
                  Service Obligation Status:
                </td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ servObStats }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">
                  Service Obligation Years:
                </td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ servObYrs }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Mode of Clearance:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">{{ modClear }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Year Cleared:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">{{ yrClear }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Clearance Date:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ clearDate }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Refunded Amount:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ refAmount }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Remarks:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">{{ remarks }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">TOR Submitted:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">{{ torSub }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Date TOR Submitted:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">{{ dateTor }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Diploma Submitted:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">{{ dipSub }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Date Diploma Submitted:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ dateDipSub }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">
                  Certificate of Graduation Submitted:
                </td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ certGradSub }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">
                  Date Certificate of Graduation Submitted:
                </td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ dateCertGrad }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Academic Award:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ acadAward }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Board Passer:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else class="on-surface-text text-bold">
                  {{ boardPass }}
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </div>
      </div>
      <div class="q-pa-md" v-else>
        <q-card flat class="my-card surface-container rounded-borders-20">
          <q-card-section>
            <q-banner inline-actions class="banner rounded-borders-10">
              <template v-slot:avatar>
                <q-icon name="error" color="negative" />
              </template>

              No Records Found
            </q-banner>
          </q-card-section>
        </q-card>
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

// Loading Simulation

const loading = ref(false);

const simulateLoad = () => {
  loading.value = true;
  // Simulating an API call delay
  setTimeout(() => {
    loading.value = false;
  }, 2000); // Delay of 3 seconds
};

const id = ref();
onMounted(() => {
  readGradObTrack();
});

const readGradObTrack = async () => {
  simulateLoad();
  try {
    id.value = route.params.id;
    const formData = new FormData();
    formData.append("id", id.value);

    // Await the response from the axios POST request
    const response = await axios.post("/read.php?readGRObTrackInfo", formData);

    // Use the response data as before
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
  } catch (error) {
    // Handle the error
    console.error("Error reading graduation object track:", error);
  }
};
</script>
