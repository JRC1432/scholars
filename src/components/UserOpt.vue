<template>
  <label>{{ user.username }}</label>
  <q-btn round flat>
    <IconSettings :size="30" stroke-width="2" />
    <q-menu>
      <q-item clickable v-close-popup @click="logOut">
        <q-item-section>Log out</q-item-section>
      </q-item>
    </q-menu>
    <q-tooltip>Settings</q-tooltip>
  </q-btn>
</template>
<script setup>
import { ref, inject, reactive, onMounted } from "vue";
import { useQuasar } from "quasar";
import router from "../router";
import { IconSettings } from "@tabler/icons-vue";

const axios = inject("$axios");
const user = inject("$user");

const logOut = () => {
  axios.post("/read.php?authlogout").then(function (response) {
    router.push("/");
  });
};
</script>
