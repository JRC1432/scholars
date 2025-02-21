<template>
  <q-card flat bordered class="my-card">
    <q-card-section>
      <div class="q-pa-md q-gutter-sm">
        <q-btn
          icon="download"
          color="primary"
          unelevated
          label="Availing"
          no-caps
          tag="a"
          href="http://localhost/scholars/scholars_backend/upload/template_availing.csv"
          target="_blank"
        />
        <q-btn
          icon="download"
          color="primary"
          unelevated
          label="Deferred"
          no-caps
          tag="a"
          href="http://localhost/scholars/scholars_backend/upload/template_deferred.csv"
          target="_blank"
        />
        <q-btn
          icon="download"
          color="primary"
          unelevated
          label="Did Not Avail"
          no-caps
          tag="a"
          href="http://localhost/scholars/scholars_backend/upload/template_dna.csv"
          target="_blank"
        />
      </div>
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
          ref="refFileUpload"
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
        <span class="text-bold">Select Contract Status:</span>

        <q-select
          ref="refcontract"
          :options="contractoptions"
          v-model="contract"
          emit-value
          name="contract"
          outlined
          dense
          hide-bottom-space
          :rules="[myRule]"
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
        <span class="text-bold">New status is latest?</span>
        <q-toggle
          :label="newstatus"
          v-model="newstatus"
          name="newstatus"
          checked-icon="check"
          color="green"
          unchecked-icon="clear"
          false-value="NO"
          true-value="YES"
        />
      </div>
      <q-card-actions>
        <div class="row fit justify-center">
          <q-btn
            rounded
            label="UPLOAD"
            color="primary"
            type="submit"
            class="q-mb-sm"
            style="width: 40%"
            @click="updateContract"
          />
        </div>
      </q-card-actions>
    </q-card-section>
  </q-card>
</template>
<script setup>
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

const refcontract = ref(null);
const refFileUpload = ref(null);
const fileUpload = ref("");

const records = ref("NO");
const newstatus = ref("NO");
const contract = ref(null);

// Validation

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

const fileRules = (val) => {
  if (val === null) {
    return "Please Select a File!";
  }
  return true;
};

// SELECT OPTIONS
const contractoptions = computed(() => [
  { label: "Availing", value: "AVAILING", color: "primary" },
  { label: "Deferred", value: "DEFERRED", color: "primary" },
  { label: "Did Not Avail", value: "DID NOT AVAIL", color: "primary" },
]);

const timer = () => {
  let timerInterval;
  Swal.fire({
    title: "Uploading!",
    html: "Batch Upload is Currently In Progress.",
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
      Swal.fire({
        icon: "success",
        title: "Uploaded Successfully",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });
};

const updateContract = () => {
  var formData = new FormData();

  formData.append("fileUpload", fileUpload.value);
  formData.append("contract", contract.value);
  formData.append("records", records.value);
  formData.append("newstatus", newstatus.value);
  formData.append("user", user.username);
  formData.append("userid", user.id);

  axios.post("/update.php?updateContracts", formData).then(function (response) {
    if (response.data == true) {
      timer();
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message:
          "Error uploading the csv. Please make sure inputs are corrected.",
      });
    }
  });
};
</script>
