<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-40">
      <q-card-section>
        <div class="text-h6 text-primary">Scholar Lists</div>
        <div class="text-subtitle2 text-primary">Scholar Profile Details</div>
      </q-card-section>
      <q-card-section>
        <ScholarsTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ScholarsTbl from "../components/ScholarsTbl.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
