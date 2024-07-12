<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        <IconTool :size="30" stroke-width="2" />
        Monitoring Sheet
      </div>
    </q-card>
    <EditGrades />
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import EditGrades from "../components/EditGrades.vue";

import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconTool } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();
</script>
