<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-20">
      <q-card-section>
        <div class="text-h6 text-primary">
          Registration Forms For Validation
        </div>
      </q-card-section>
      <q-card-section>
        <RegFormTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import RegFormTbl from "../components/RegFormTbl.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
