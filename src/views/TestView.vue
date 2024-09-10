<template>
  <q-page class="q-pa-md">
    <q-card class="q-mb-md">
      <q-skeleton v-if="loading" type="rect" width="100%" height="100px" />
      <div v-else>
        <!-- Replace this div with your actual content -->
        <q-card-section>
          <div class="text-h6">Loaded Content</div>
          <div>This is the content displayed after the skeleton delay.</div>
        </q-card-section>
      </div>
    </q-card>
    <q-btn label="Simulate Load" color="primary" @click="simulateLoad" />
  </q-page>
</template>

<script setup>
import { ref } from "vue";

const loading = ref(false);

function simulateLoad() {
  loading.value = true;
  // Simulating an API call delay
  setTimeout(() => {
    loading.value = false;
  }, 3000); // Delay of 3 seconds
}
</script>
