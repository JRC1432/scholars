<template>
  <div class="col-xs-12 col-sm-6">
    <div class="q-col-gutter-md row items-start">
      <div class="col-xs-12 col-sm-6 col-md-3">
        <q-card class="surface-container no-shadow rounded-borders-10">
          <div class="row">
            <div class="col-2 q-pa-md">
              <div class="row justify-center items-center" style="height: 70px">
                <q-icon name="school" size="xl" class="primary-text"></q-icon>
              </div>
            </div>
            <div class="col-10 surface-container rounded-borders-10">
              <div class="row items-center" style="height: 95px">
                <div class="q-ml-md">
                  <div class="text-h4 text-bold primary-text">
                    <vue3-autocounter
                      ref="counter"
                      :startAmount="0"
                      :endAmount="meritcounts + ra10612counts + ra7687counts"
                      :duration="3"
                      class="text-bold"
                    />
                  </div>
                  <div class="text-subtitle2">Total Number of Scholars:</div>
                </div>
              </div>
            </div>
          </div>
        </q-card>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <q-card class="surface-container no-shadow rounded-borders-10">
          <div class="row">
            <div class="col-2 q-pa-md">
              <div class="row justify-center items-center" style="height: 70px">
                <q-icon
                  name="workspace_premium"
                  size="xl"
                  class="primary-text"
                ></q-icon>
              </div>
            </div>
            <div class="col-10 surface-container rounded-borders-10">
              <div class="row items-center" style="height: 95px">
                <div class="q-ml-md">
                  <div class="text-h4 text-bold primary-text" id="number_up">
                    <vue3-autocounter
                      ref="counter"
                      :startAmount="0"
                      :endAmount="meritcounts"
                      :duration="3"
                      class="text-bold"
                    />
                  </div>
                  <div id="number_up"></div>
                  <div class="text-subtitle2">MERIT:</div>
                </div>
              </div>
            </div>
          </div>
        </q-card>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <q-card class="surface-container no-shadow rounded-borders-10">
          <div class="row">
            <div class="col-2 q-pa-md">
              <div class="row justify-center items-center" style="height: 70px">
                <q-icon
                  name="military_tech"
                  size="xl"
                  class="primary-text"
                ></q-icon>
              </div>
            </div>
            <div class="col-10 surface-container rounded-borders-10">
              <div class="row items-center" style="height: 95px">
                <div class="q-ml-md">
                  <div class="text-h4 text-bold primary-text">
                    <vue3-autocounter
                      ref="counter"
                      :startAmount="0"
                      :endAmount="ra10612counts"
                      :duration="3"
                      class="text-bold"
                    />
                  </div>
                  <div class="text-subtitle2">RA 10612:</div>
                </div>
              </div>
            </div>
          </div>
        </q-card>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <q-card class="surface-container no-shadow rounded-borders-10">
          <div class="row">
            <div class="col-2 q-pa-md">
              <div class="row justify-center items-center" style="height: 70px">
                <q-icon
                  name="military_tech"
                  size="xl"
                  class="primary-text"
                ></q-icon>
              </div>
            </div>
            <div class="col-10 surface-container rounded-borders-10">
              <div class="row items-center" style="height: 95px">
                <div class="q-ml-md">
                  <div class="text-h4 text-bold primary-text">
                    <vue3-autocounter
                      ref="counter"
                      :startAmount="0"
                      :endAmount="ra7687counts"
                      :duration="3"
                      class="text-bold"
                    />
                  </div>
                  <div class="text-subtitle2">RA 7687:</div>
                </div>
              </div>
            </div>
          </div>
        </q-card>
      </div>
    </div>
  </div>
</template>
<script setup>
import WelcomeBanner from "../components/WelcomeBanner.vue";
import { ref, reactive, onMounted, inject, computed, watch } from "vue";
import { useQuasar } from "quasar";
// import vue3Autocounter from "vue3-autocounter";
import Vue3Autocounter from "vue3-autocounter";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

const meritcounts = ref([]);
const ra10612counts = ref([]);
const ra7687counts = ref([]);

onMounted(() => {
  counters();
});

const counters = () => {
  axios.get("/read.php?merit").then(function (response) {
    meritcounts.value = response.data.meritcount;
  });

  axios.get("/read.php?ra10612").then(function (response) {
    ra10612counts.value = response.data.ra10612count;
  });

  axios.get("/read.php?ra7687").then(function (response) {
    ra7687counts.value = response.data.ra7687count;
  });
};
</script>
