<template>
  <div class="q-pa-md">
    <q-card flat bordered class="my-card rounded-borders-40">
      <q-card-section>
        <div class="text-h6 text-primary">Staff Records</div>
        <div class="text-subtitle2 text-primary">Staff Profile Details</div>
      </q-card-section>
      <q-card-section>
        <UserTbl />
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import UserTbl from "../components/UserTbl.vue";
</script>
