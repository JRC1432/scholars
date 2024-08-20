<template>
  <NewGrades />
</template>

<script setup>
import NewGrades from "../components/NewGrades.vue";
import { ref, reactive, computed, onMounted, watchEffect, inject } from "vue";
import router from "../router";
import { uid } from "quasar";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();
</script>
