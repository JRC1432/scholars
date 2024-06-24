<template>
  <div>
    <label>
      mloa:
      <input v-model.number="mloa" type="number" />
    </label>
    <br />
    <label>
      ra1LOA:
      <input v-model.number="ra1LOA" type="number" />
    </label>
    <br />
    <label>
      ra7LOA:
      <input v-model.number="ra7LOA" type="number" />
    </label>
    <br />
    <div>all_Loa: {{ all_Loa }}</div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";

const mloa = ref(0);
const ra1LOA = ref(0);
const ra7LOA = ref(10);
const all_Loa = ref(0);

const sumValues = () => {
  const sum = mloa.value + ra1LOA.value + ra7LOA.value;
  return isNaN(sum) ? 0 : sum;
};

watch(
  [mloa, ra1LOA, ra7LOA],
  () => {
    all_Loa.value = sumValues();
  },
  { immediate: true }
);

console.log(all_Loa.value);
</script>

<style>
/* Add any component-specific styles here */
</style>
