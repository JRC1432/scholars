<template>
  <label>{{ user.username }}</label>
  <q-btn round flat>
    <q-avatar size="35px">
      <img :src="'http://localhost/backdbase/' + regpic" />
    </q-avatar>
    <q-menu>
      <q-item clickable v-close-popup>
        <q-item-section @click="showPic = true">Upload Photo</q-item-section>
      </q-item>
      <q-item clickable v-close-popup @click="logOut">
        <q-item-section>Log out</q-item-section>
      </q-item>
    </q-menu>
    <q-tooltip>Account</q-tooltip>
  </q-btn>
</template>
<script setup>
import { ref, inject, reactive, onMounted } from "vue";
import { useQuasar } from "quasar";
import router from "../router";

const axios = inject("$axios");
const user = inject("$user");

const logOut = () => {
  axios.post("/read.php?authlogout").then(function (response) {
    router.push("/");
  });
};
</script>
