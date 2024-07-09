<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-40">
      <q-card-section>
        <div class="text-h6 text-primary">Scholar Records</div>
        <div class="text-subtitle2 text-primary">Scholar Profile Details</div>
      </q-card-section>
      <q-card-section> <ScholarsRecTbl /> </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import ScholarsRecTbl from "../components/ScholarsRecTbl.vue";
</script>
