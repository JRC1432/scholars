<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-40">
      <q-card-section>
        <div class="text-h6 text-primary">Scholars By Municipality</div>
      </q-card-section>
      <q-card-section>
        <ScholarsMunicipalityTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ScholarsMunicipalityTbl from "../components/ScholarsMunicipalityTbl.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
