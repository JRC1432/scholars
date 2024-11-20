<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Financial Statement
      </div>
      <q-card-section>
        <FinancialStatement />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import FinancialStatement from "../components/FinancialStatement.vue";
import { ref, onMounted, reactive, computed, inject } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconTool, IconClipboardPlus, IconFilesOff } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// const globalSPAS = route.params.id;
// const financeCheck = ref();

// const populateAll = () => {
//   var formData = new FormData();
//   formData.append("id", globalSPAS);

//   axios.post("/read.php?checkFinancial", formData).then((response) => {
//     financeCheck.value = response.data;
//   });
// };

// onMounted(() => {
//   populateAll();
// });
</script>
