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
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <q-card-section
        ><div class="q-pa-md text-center">
          <q-banner
            inline-actions
            rounded
            class="text-bold banner rounded-borders-20"
          >
            <div class="text-h3">
              <IconEdit :size="40" stroke-width="2" />
              EDIT GRADES
            </div>
          </q-banner>
        </div></q-card-section
      >

      <q-card-section><EditGrades /></q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import EditGrades from "../components/EditGrades.vue";

import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconTool, IconEdit } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Session Storage
const spasids = ref();

const spasItem = sessionStorage.getItem("spasid");

if (spasItem) {
  spasids.value = JSON.parse(spasItem);
}

const showMonitor = () => {
  router.push({
    path: "/monitorsheet/" + spasids.value,
  });
};

function goBack() {
  window.history.back();
}
</script>
