<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-40">
      <q-card-section>
        <div class="text-h6 text-primary">Unvalidated Status List</div>
      </q-card-section>
      <q-card-section>
        <ValidateTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ValidateTbl from "../components/ValidateTbl.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
