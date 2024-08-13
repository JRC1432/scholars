<template>
  <div>SPAS ID: {{ props.spasid.spas_id }}</div>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed, defineProps } from "vue";

// props.spasid define the spasid

const props = defineProps({
  spasid: {
    type: [String, Number],
    default: null, // Use default if the value might be undefined
  },
});
</script>
