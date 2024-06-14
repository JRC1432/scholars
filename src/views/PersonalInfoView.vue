<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Personal Informations
      </div>
      <q-separator class="q-mt-md q-mb-xs" inset />
      <div class="q-pa-lg q-mb-md">
        <q-scroll-area
          :thumb-style="thumbStyle"
          :bar-style="barStyle"
          style="height: 800px; max-width: 5000px"
        >
          <div class="col-12">
            <div class="q-col-gutter-md row items-start">
              <div class="col-xs-12">
                <span class="text-bold primary-text">SPAS ID:</span>
                <q-input
                  ref="refspas"
                  rounded
                  outlined
                  hide-bottom-space
                  readonly
                  v-model="state.spasid"
                  name="spasid"
                  style="max-width: 200px"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <span class="text-bold primary-text">First Name:</span>
                <q-input
                  ref="reffname"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.fname"
                  name="fname"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <span class="text-bold primary-text">Middle Name:</span>
                <q-input
                  ref="refmname"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.mname"
                  name="mname"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <span class="text-bold primary-text">Last Name:</span>
                <q-input
                  ref="reflname"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.lname"
                  name="lname"
                />
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <span class="text-bold primary-text">Suffix Name:</span>
                <q-input
                  ref="refsname"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.sname"
                  name="sname"
                />
              </div>
              <div class="col-xs-12 col-sm-4 col-md-4">
                <span class="text-bold primary-text">Sex:</span>
                <q-input
                  ref="refsex"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.sex"
                  name="sex"
                />
              </div>
              <div class="col-xs-12 col-sm-4 col-md-4">
                <span class="text-bold primary-text">Birthday:</span>
                <q-input
                  ref="refbirthday"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.birthday"
                  name="birthday"
                />
              </div>
              <div class="col-xs-12 col-sm-4 col-md-4">
                <span class="text-bold primary-text">Place of Birth:</span>
                <q-input
                  ref="refbirth"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.birth"
                  name="birth"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <span class="text-bold primary-text">Email:</span>
                <q-input
                  ref="refemail"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.email"
                  name="email"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <span class="text-bold primary-text">Contact:</span>
                <q-input
                  ref="refcontact"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.contact"
                  name="contact"
                />
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <span class="text-bold primary-text">Tribe:</span>
                <q-input
                  ref="reftribe"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.tribe"
                  name="tribe"
                />
              </div>

              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="q-pa-md text-left text-bold primary-text text-h4">
                  Address
                </div>
              </div>

              <div class="col-xs-12 col-sm-6 col-md-12">
                <span class="text-bold primary-text">Street:</span>
                <q-input
                  ref="refstreet"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.street"
                  name="street"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-3">
                <span class="text-bold primary-text">Village:</span>
                <q-input
                  ref="refvillage"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.village"
                  name="village"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-3">
                <span class="text-bold primary-text">Barangay:</span>
                <q-input
                  ref="refbrgy"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.brgy"
                  name="brgy"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-3">
                <span class="text-bold primary-text">Municipality:</span>
                <q-input
                  ref="refmun"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.mun"
                  name="mun"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-3">
                <span class="text-bold primary-text">Province:</span>
                <q-input
                  ref="refprovince"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.province"
                  name="province"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <span class="text-bold primary-text">Region:</span>
                <q-input
                  ref="refregion"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.region"
                  name="region"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <span class="text-bold primary-text">District:</span>
                <q-input
                  ref="refdistrict"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.district"
                  name="district"
                />
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <span class="text-bold primary-text">Zip Code:</span>
                <q-input
                  ref="refzip"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.zip"
                  name="zip"
                />
              </div>
              <div class="col-xs-12">
                <span class="text-bold primary-text">Current Address:</span>
                <q-input
                  ref="refcurrentAdd"
                  filled
                  hide-bottom-space
                  readonly
                  v-model="state.currentAdd"
                  name="currentAdd"
                />
              </div>
            </div>
          </div>
        </q-scroll-area>
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
  spasid: "",
  fname: "",
  mname: "",
  lname: "",
  sname: "",
});

// Rules & Validations
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
];

const id = ref();
onMounted(() => {
  readscholar();
});

const readscholar = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readScholarID", formData).then((response) => {
    state.spasid = response.data.spas_id;
    state.fname = response.data.first_name;
    state.mname = response.data.middle_name;
    state.lname = response.data.last_name;
    state.sname = response.data.suffix_name;
    state.sex = response.data.sex;
    state.birthday = response.data.dob;
    state.birth = response.data.pob;
    state.email = response.data.email;
    state.contact = response.data.contact_no;
    state.tribe = response.data.tribe;
    state.street = response.data.street;
    state.village = response.data.village;
    state.brgy = response.data.barangay;
    state.mun = response.data.municipality;
    state.province = response.data.province;
    state.region = response.data.region;
    state.district = response.data.district;
    state.zip = response.data.zipcode;
    state.currentAdd = response.data.diff_curr_add;
  });
};
</script>
