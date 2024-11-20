<template>
  <q-card>
    <q-img
      v-if="base64Image"
      :src="base64Image"
      style="max-width: 300px; margin: auto"
    />
    <p v-else>Loading image...</p>
  </q-card>
</template>

<script setup>
import { ref, onMounted } from "vue";

const base64Image = ref(null);

onMounted(() => {
  // Load the image as Base64
  const imgPath = new URL("../assets/seilogopng.png", import.meta.url).href;
  fetch(imgPath)
    .then((response) => response.blob())
    .then((blob) => {
      const reader = new FileReader();
      reader.onloadend = () => {
        base64Image.value = reader.result;
      };
      reader.readAsDataURL(blob);
    })
    .catch((error) => {
      console.error("Failed to convert image to Base64:", error);
    });
});
</script>
