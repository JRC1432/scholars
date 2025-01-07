<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-20">
      <q-card-section>
        <div class="text-h6 text-primary">Release Allowance Table</div>
      </q-card-section>
      <q-card-section>
        <ReleaseAllowanceTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ReleaseAllowanceTbl from "../components/ReleaseAllowanceTbl.vue";
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
</script>
