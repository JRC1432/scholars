<template>
  <q-banner class="tertiary-container rounded-borders-10 text-h1">
    <div class="col-xs-12 col-sm-6">
      <div class="q-col-gutter-md row items-start">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="text-h6">
            Hello
            <strong class="primary-text text-bold">{{ user.username }}</strong
            >!! 🎉
          </div>

          <div class="text-body1 text-weight-medium">
            Welcome You Are Now Login To The System!!
          </div>

          <q-separator class="q-mt-md q-mb-xs" />
          <div class="text-h7">
            <strong class="primary-text text-bold">Employee ID: </strong>
            <text class="text-weight-bold">{{ user.internal_id }}</text>
          </div>
          <div class="text-h7">
            <strong class="primary-text text-bold">Name: </strong>
            <text class="text-weight-bold">{{ user.username }}</text>
          </div>
          <div class="text-h7">
            <strong class="primary-text text-bold">Region: </strong>
            <text class="text-weight-bold">{{ user.region }}</text>
          </div>
          <div class="text-h7">
            <strong class="primary-text text-bold">Email:</strong>
            <text class="text-weight-bold">{{}}</text>
          </div>
        </div>
        <div class="q-pa-md q-gutter-sm q-display-flex q-justify-end">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div
              class="fixed-right absolute-right fixed-top-right absolute-top-right"
            >
              <Vue3Lottie
                animationLink="https://lottie.host/0ad26d58-6934-435a-a467-4bad2176fbfe/UcnlcscUIL.json"
                style="height: calc(30vh)"
                :height="500"
                :width="500"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </q-banner>
</template>
<script setup>
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
