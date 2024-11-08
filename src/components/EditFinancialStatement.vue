<template>
  <div class="q-pa-md" v-for="(finance_fors, key) in finance_for" :key="key">
    <q-card class="my-card no-shadow rounded-borders-20" bordered>
      <q-banner inline-actions class="banner-2">
        <!-- <text class="text-caption">{{ key }}</text> -->
        <div class="text-subtitle1">School Year: {{ finance_fors.sy }}</div>

        <!-- Button to create a new card -->
        <template v-slot:action>
          <q-btn
            unelevated
            rounded
            color="positive"
            class="q-mr-sm"
            icon="print"
          />
          <q-btn
            unelevated
            rounded
            color="primary"
            label="Update"
            icon="edit"
          />
        </template>
      </q-banner>

      <q-card-section>
        <q-table
          :rows="finance_fors.details"
          :columns="columns"
          row-key="name"
          class="no-border"
          wrap-cells
          flat
          bordered
        />
      </q-card-section>

      <q-card-section>
        <q-chip outline color="teal" text-color="white" icon="payments">
          TOTAL AMOUNT: ₱ {{ finance_fors.total_amt }}
        </q-chip>
      </q-card-section>
    </q-card>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import { useQuasar } from "quasar";
import { useRoute } from "vue-router";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const finance_for = ref([]);

const globalSPAS = route.params.id;

const populateAll = async () => {
  var formData = new FormData();

  formData.append("id", globalSPAS);

  // Select School Year
  await axios.post("/read.php?readFinanceIds", formData).then((response) => {
    finance_for.value = response.data;
  });
};

onMounted(() => {
  populateAll(); // Fetch options on component mount
});
</script>

<style scoped>
.q-table td {
  text-align: left !important;
}
</style>
