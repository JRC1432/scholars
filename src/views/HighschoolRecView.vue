<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Highschool Record
      </div>

      <div class="q-pa-lg q-mb-md">
        <div class="col-12">
          <div class="q-col-gutter-md row items-start">
            <div class="col-xs-12">
              <span class="text-bold primary-text">School Name:</span>
              <q-input
                ref="refscname"
                filled
                hide-bottom-space
                readonly
                v-model="state.scname"
                name="scname"
                :rules="inputRules"
              />
            </div>
            <div class="col-xs-12">
              <span class="text-bold primary-text">School Code:</span>
              <q-input
                ref="refsccode"
                filled
                hide-bottom-space
                readonly
                v-model="state.sccode"
                name="sccode"
                :rules="inputRules"
              />
            </div>
            <div class="col-xs-12">
              <span class="text-bold primary-text">Year Gradauted:</span>
              <q-input
                ref="refyrgrad"
                filled
                hide-bottom-space
                readonly
                v-model="state.yrgrad"
                name="yrgrad"
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
  scname: "",
  sccode: "",
  yrgrad: "",
});

// Item References

const refscname = ref(null);
const refsccode = ref(null);
const refyrgrad = ref(null);

const id = ref();
onMounted(() => {
  readHS();
});

const readHS = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readHS", formData).then((response) => {
    state.scname = response.data.hs_name;
    state.sccode = response.data.hs_code;
    state.yrgrad = response.data.hs_grad;
  });
};
</script>
