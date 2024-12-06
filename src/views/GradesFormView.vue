<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-20">
      <q-card-section>
        <div class="text-h6 text-primary">Grades For Validation</div>
      </q-card-section>
      <q-card-section>
        <GradesFormTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import GradesFormTbl from "../components/GradesFormTbl.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
