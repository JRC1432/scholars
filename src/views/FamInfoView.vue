<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Family Information
      </div>
      <q-separator class="q-mt-md q-mb-xs" inset />

      <div class="q-pa-lg q-mb-md">
        <div class="col-12">
          <div class="q-col-gutter-md row items-start">
            <div class="col-xs-12">
              <span class="text-bold primary-text">Income:</span>
              <q-input
                ref="refincome"
                filled
                hide-bottom-space
                readonly
                v-model="state.income"
                name="income"
              />
            </div>
            <div class="col-xs-12">
              <span class="text-bold primary-text">Father Occupation:</span>
              <q-input
                ref="reffatherOccu"
                filled
                hide-bottom-space
                readonly
                v-model="state.fatherOccu"
                name="fatherOccu"
              />
            </div>
            <div class="col-xs-12">
              <span class="text-bold primary-text">Mother Occupation::</span>
              <q-input
                ref="refmotherOccu"
                filled
                hide-bottom-space
                readonly
                v-model="state.motherOccu"
                name="motherOccu"
              />
            </div>
            <div class="col-xs-12">
              <span class="text-bold primary-text">Type:</span>
              <q-input
                ref="reftype"
                filled
                hide-bottom-space
                readonly
                v-model="state.type"
                name="type"
              />
            </div>
          </div>
        </div>
      </div>
    </q-card>
  </div>
</template>

<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// @state v-model
const state = reactive({
  income: "",
  fatherOccu: "",
  motherOccu: "",
  type: "",
});

// Item References

const refincome = ref(null);
const reffatherOccu = ref(null);
const refmotherOccu = ref(null);
const reftype = ref(null);

const id = ref();
onMounted(() => {
  readFamInfo();
});

const readFamInfo = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readFamilyInfo", formData).then((response) => {
    let income = response.data.income;
    let formattedIncome = new Intl.NumberFormat("en-US", {
      style: "currency",
      currency: "php",
    }).format(income);
    state.income = formattedIncome;
    state.fatherOccu = response.data.father_occu;
    state.motherOccu = response.data.mother_occu;
    state.type = response.data.occu;
  });
};
</script>
