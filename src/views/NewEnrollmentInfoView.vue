<template>
  <NewTerm />
</template>

<script setup>
import NewTerm from "../components/NewTerm.vue";
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
