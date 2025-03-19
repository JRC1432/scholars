<template>
  <div class="q-pa-md">
    <q-btn
      no-caps
      unelevated
      color="positive"
      @click="triggerPositive"
      label="Trigger 'positive'"
    />
  </div>
</template>

<script setup>
import { useQuasar } from "quasar";

const q$ = useQuasar();
const $q = useQuasar();

// const $q = useQuasar();

const triggerPositive = () => {
  $q.notify({
    message: "Grades has been set to latest!",
    color: "light-green-5",
    icon: "check_circle", // Adds a check icon in front
    position: "top-right", // Shows the toast at the top
    timeout: 2000, // Auto-closes in 2 seconds
    progress: true,
  });
};
</script>

<style scoped>
.custom-notify {
  font-size: 1.2rem; /* Increase text size */
  padding: 16px; /* Add more padding */
  min-width: 250px; /* Adjust width */
  border-radius: 10px; /* Smooth edges */
}
</style>
