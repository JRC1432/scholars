<template>
  <q-card flat bordered class="my-card">
    <q-card-section>
      <div class="q-pa-md q-gutter-sm">
        <q-btn icon="download" color="primary" unelevated label="Availing" />
        <q-btn icon="download" color="primary" unelevated label="Deferred" />
        <q-btn
          icon="download"
          color="primary"
          unelevated
          label="Did Not Avail"
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
          ref="refavailingUpload"
          outlined
          dense
          hide-bottom-space
          v-model="availingUpload"
          name="availingUpload"
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
          v-model="state.contract"
          emit-value
          name="gender"
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
            style="width: 80%"
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

const availingUpload = ref(null);

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

const state = reactive({
  contract: "",
});

// SELECT OPTIONS
const contractoptions = computed(() => [
  { label: "Availing", value: "AVAILING", color: "primary" },
  { label: "Deferred", value: "DEFERRED", color: "primary" },
  { label: "Did Not Avail", value: "DID NOT AVAIL", color: "primary" },
]);
</script>
