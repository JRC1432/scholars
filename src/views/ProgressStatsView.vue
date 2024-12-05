<template>
  <div class="q-pa-md">
    <q-card class="my-card rounded-borders-20">
      <form id="bulkUploadForm" @submit.prevent.stop="bulkUpload">
        <q-card-section>
          <div class="text-h6">
            Batch Update Progress Status and Standing of Scholars
          </div>
        </q-card-section>

        <q-card-section>
          <q-btn
            icon="download"
            color="primary"
            unelevated
            label="Download Template"
            href="http://localhost/scholars/scholars_backend/upload/Progress_Stats.csv"
          >
            <q-tooltip class="bg-primary"
              >Download Progress Status and Standing of Scholars
              Template</q-tooltip
            >
          </q-btn>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <div class="text-weight-bold">
            Select CSV file to upload. (Max size: 2 MB)
          </div>
        </q-card-section>

        <q-separator inset />

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">Lists of Records</span>
            <q-file
              ref="reffileUpload"
              outlined
              dense
              hide-bottom-space
              v-model="fileUpload"
              name="fileUpload"
              label="*CSV FILES ONLY"
              color="primary"
              clearable
              counter
              :rules="[fileRules]"
            >
              <template v-slot:prepend>
                <q-icon name="attach_file" />
              </template>
            </q-file>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Start / End: </span>
            <q-btn-toggle
              v-model="startEnd"
              class="my-custom-toggle"
              no-caps
              rounded
              push
              toggle-color="primary"
              color="white"
              size="sm"
              text-color="primary"
              :options="[
                { label: 'START', value: 'START' },
                { label: 'END', value: 'END' },
              ]"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is Latest?</span>
            <q-toggle
              :label="stats"
              v-model="stats"
              name="records"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold"
              >Records are active? (Records are of New/Ongoing Scholars)</span
            >
            <q-toggle
              :label="records"
              v-model="records"
              name="records"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Skip Validation</span>
            <q-toggle
              :label="validation"
              v-model="validation"
              name="records"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
        </q-card-section>
        <q-card-actions>
          <div class="row fit justify-center">
            <q-btn
              rounded
              label="UPLOAD"
              color="primary"
              type="submit"
              class="q-mb-sm"
              style="width: 40%"
            />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, computed, inject } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const stats = ref("NO");
const records = ref("NO");
const validation = ref("NO");
const startEnd = ref("");
const fileUpload = ref();

const reffileUpload = ref(null);

const bulkUpload = () => {
  var formData = new FormData(document.getElementById("bulkUploadForm"));

  formData.append("startEnd", startEnd.value);
  formData.append("stats", stats.value);
  formData.append("actflag", records.value);
  formData.append("validation", validation.value);
  formData.append("user", user.username);
  formData.append("userid", user.id);
  //

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Update it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/update.php?updateBatchProgressStats", formData)
        .then(function (response) {
          if (response.data == true) {
            let timerInterval;
            Swal.fire({
              title: "Auto close alert!",
              html: "I will close in <b></b> milliseconds.",
              timer: 2000,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                  timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
              },
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                console.log("I was closed by the timer");
                Swal.fire({
                  title: "Success!",
                  text: "Successfully Updated.",
                  icon: "success",
                });
              }
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to Update Progress Status",
            });
          }
        });
    }
  });
};
</script>
