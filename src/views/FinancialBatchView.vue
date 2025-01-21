<template>
  <div class="q-pa-md">
    <q-card class="rounded-borders-20">
      <q-card-section>
        <div class="text-h6">Batch Update Financial</div>
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
      </q-card-section>

      <q-card-action class="row justify-center">
        <q-btn
          rounded
          label="UPLOAD"
          color="primary"
          type="submit"
          class="q-mb-sm"
          style="width: 40%"
        ></q-btn>
      </q-card-action>
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

const fileUpload = ref();

const fileRules = (val) => {
  if (val === null) {
    return "Please Select a File!";
  }
  return true;
};
</script>
