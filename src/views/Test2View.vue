<template>
  <div>
    <q-input
      v-model.number="inputNumber"
      type="number"
      label="Enter the number of cards"
      filled
      class="q-mb-md"
    />

    <div v-for="n in inputNumber" :key="n" class="q-mb-md">
      <q-card>
        <q-card-section>
          <div class="text-h6">Card {{ n }}</div>
          <div>This is card number {{ n }}</div>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const inputNumber = ref(0);
</script>
