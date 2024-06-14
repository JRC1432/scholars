<template>
  <div class="q-pa-md">
    <WelcomeBanner />
  </div>
  <div class="q-pa-md">
    <DashCounter />
  </div>
</template>
<script setup>
import WelcomeBanner from "../components/WelcomeBanner.vue";
import DashCounter from "../components/DashCounter.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";
import Vue3autocounter from "vue3-autocounter";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
</script>
