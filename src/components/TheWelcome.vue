<template>
  <q-page class="q-pa-md fullbody">
    <q-toolbar>
      <q-toolbar-title class="text-bold text-h5 q-pt-sm text-white text-center">
        <q-avatar size="xl" rounded class="q-mr-md">
          <img src="../assets/seilogopng.png" />
        </q-avatar>
        <div style="line-height: 1" class="text-bold">
          Department of Science and Technology - Science Education Institute
          <span class="text-subtitle1" style="display: block"
            >Undergraduate Scholarship Information System V2.0</span
          >
        </div>
      </q-toolbar-title>
    </q-toolbar>

    <q-card class="login-card rounded-borders-20 primary-container">
      <q-card-section>
        <div class="col-12 col-lg-4 col-md-4 q-px-sm">
          <div class="justify-center">
            <div class="text-h5 text-center text-bold q-pa-md">Login</div>

            <q-space />

            <div class="q-pa-md">
              <q-banner
                class="bg-orange-1 text-orange-14 rounded-borders text-center"
              >
                Please sign-in to your account
              </q-banner>
              <q-form
                id="login"
                @submit.prevent.stop="LogSubmit"
                class="q-gutter-md"
              >
                <q-input
                  ref="nameRef"
                  label="Username"
                  name="usernames"
                  v-model="state.username"
                  :dense="dense"
                  hide-bottom-space
                  no-error-icon
                  lazy-rules
                  :rules="inputRules"
                >
                  <template v-slot:prepend>
                    <q-icon name="person" />
                  </template>
                </q-input>
                <q-input
                  ref="passRef"
                  label="Password"
                  name="password"
                  v-model="state.password"
                  lazy-rules
                  :type="isPwd ? 'password' : 'text'"
                  :rules="inputpassRules"
                  hide-bottom-space
                  no-error-icon
                >
                  <template v-slot:prepend>
                    <q-icon name="password" />
                  </template>
                  <template v-slot:append>
                    <q-icon
                      :name="isPwd ? 'visibility_off' : 'visibility'"
                      class="cursor-pointer"
                      @click="isPwd = !isPwd"
                    />
                  </template>
                </q-input>
                <div class="q-pa-lg">
                  <q-btn
                    rounded
                    color="primary"
                    label="Log In"
                    type="submit"
                    style="width: 100%"
                  />
                </div>
              </q-form>
            </div>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { useQuasar } from "quasar";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";

const q$ = useQuasar();
const $q = useQuasar();
// Items Variables
const isPwd = ref(true);
const nameRef = ref(null);
const passRef = ref(null);
const axios = inject("$axios");

const state = reactive({
  username: "",
  password: "",
});

// Rules & Validations
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
];

const inputpassRules = [
  (val) => !!val || "Field is required",
  (val) => val.length >= 6 || "Please use minimum of 6 characters",
];

const LogSubmit = async () => {
  // (optional) Wait until recaptcha has been loaded.
  // await recaptchaLoaded();

  // Execute reCAPTCHA with action "login".
  // const token = await executeRecaptcha("login");

  // Do stuff with the received token.
  // console.log({ token });
  nameRef.value.validate();
  passRef.value.validate();

  if (nameRef.value.hasError || passRef.value.hasError) {
    // form has error
  } else {
    var formData = new FormData(document.getElementById("login"));

    axios.post("/read.php?usnames", formData).then(function (response) {
      console.log(response.data);
      if (response.data.error) {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Login Failed",
        });
      } else {
        router.push("/reports");
      }
    });
  }
};
</script>

<style>
.login-card {
  max-width: 400px;
  margin: 0 auto;
  margin-top: 150px;
  /* Glass Type Please set 1st to white background */
  /* background: rgba(255, 255, 255, 0.25) !important;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37) !important;
  backdrop-filter: blur(4px) !important;
  -webkit-backdrop-filter: blur(4px) !important;
  border-radius: 10px !important;
  border: 1px solid rgba(255, 255, 255, 0.18) !important; */
}

.rounded-borders-40 {
  border-radius: 40px !important; /* Adjust the radius as needed */
}

.rounded-borders-10 {
  border-radius: 10px !important; /* Adjust the radius as needed */
}

.rounded-borders-20 {
  border-radius: 20px !important; /* Adjust the radius as needed */
}

.fullbody {
  background: url("../assets/bg.jpg") no-repeat;
  background-size: cover;
}
</style>
