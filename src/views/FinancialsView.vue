<template>
  <ScInfo />
  <FinancialStatement />
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
</script>
