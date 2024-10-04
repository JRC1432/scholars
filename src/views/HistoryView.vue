<template>
  <div class="q-mb-md q-px-lg">
    <q-btn
      color="primary"
      icon="reply"
      label="BACK"
      rounded
      flat
      @click="goBack"
    />
  </div>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-40 banner-2">
      <q-card-section>
        <div class="text-h6 text-primary">View History</div>
      </q-card-section>
      <q-card-section class="row justify-center">
        <div class="q-ml-md">
          <q-badge color="green" rounded class="q-mr-sm" />Verified
        </div>
        <div class="q-ml-md">
          <q-badge color="orange" rounded class="q-mr-sm" />Unverified
        </div>
        <div class="q-ml-md">
          <q-badge color="red-4" rounded class="q-mr-sm" />None
        </div>
      </q-card-section>
      <q-card-section>
        <HistoryTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import HistoryTbl from "../components/HistoryTbl.vue";
import ScInfo from "../components/ScInfo.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

function goBack() {
  window.history.back();
}
</script>
