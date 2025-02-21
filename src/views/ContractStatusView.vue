<template>
  <div class="q-pa-md">
    <q-card class="my-card rounded-borders-20">
      <q-card-section>
        <div class="text-h6">Update Contract Status</div>
        <!-- <div class="text-subtitle2">by John Doe</div> -->
      </q-card-section>

      <q-card-section class="q-pt-none">
        <q-tabs
          v-model="tab"
          dense
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="left"
          narrow-indicator
        >
          <q-tab name="contract" label="Contract Status and Info" />
          <!-- <q-tab name="didNAvail" label="DID NOT AVAIL" /> -->
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="contract">
            <div class="q-pa-md">
              <Contract />
            </div>
          </q-tab-panel>

          <!-- <q-tab-panel name="didNAvail">
            <DidNotAvail />
          </q-tab-panel> -->
        </q-tab-panels>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import Contract from "../components/Contract.vue";
import DidNotAvail from "../components/DidNotAvail.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

const tab = ref("contract");
</script>
