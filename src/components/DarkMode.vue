<template>
  <div class="q-pa-xs">
    <q-btn flat round @click="changetheme">
      <IconMoonStars :size="30" stroke-width="2" v-if="isMoonStars" />
      <IconBrightness2 v-else :size="30" stroke-width="2" />
      <q-tooltip>Light/Dark Modes</q-tooltip>
    </q-btn>
  </div>
</template>

<script setup>
import { useQuasar } from "quasar";
import { watch, ref, onMounted } from "vue";
import { IconMoonStars, IconBrightness2 } from "@tabler/icons-vue";

const $q = useQuasar();

// Initialize isMoonStars from session storage, default to true if not present
const isMoonStars = ref(sessionStorage.getItem("isMoonStars") === "true");

const changetheme = () => {
  isMoonStars.value = !isMoonStars.value;
  sessionStorage.setItem("isMoonStars", isMoonStars.value);
  $q.dark.set(isMoonStars.value);
};

// Sync Quasar's dark mode with isMoonStars when the component mounts
onMounted(() => {
  if (isMoonStars.value !== $q.dark.isActive) {
    $q.dark.set(isMoonStars.value);
  }
});

watch(
  () => $q.dark.isActive,
  (val) => {
    console.log(val ? "dark" : "light");
  }
);
</script>

<style scoped>
.body--light {
}
.body--dark {
}
</style>
