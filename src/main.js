import "./assets/main.css";

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { Quasar, Notify, Loading, Dialog, LoadingBar } from "quasar";
import "./assets/light.scss";
import "./assets/dark.scss";
import axiosMain from "axios";

import Vue3Lottie from "vue3-lottie";
import Vue3Autocounter from "vue3-autocounter";
import PasswordMeter from "vue-simple-password-meter";

// Import icon libraries
import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/material-icons-outlined/material-icons-outlined.css";
import "@quasar/extras/material-icons-round/material-icons-round.css";
import "@quasar/extras/material-icons-sharp/material-icons-sharp.css";
import "@quasar/extras/material-symbols-outlined/material-symbols-outlined.css";
import "@quasar/extras/material-symbols-rounded/material-symbols-rounded.css";
import "@quasar/extras/material-symbols-sharp/material-symbols-sharp.css";

// Fonts styles imports
import "@fontsource/koho/200.css";
import "@fontsource/koho/300.css";
import "@fontsource/koho/400.css";
import "@fontsource/koho/500.css";
import "@fontsource/koho/600.css";
import "@fontsource/koho/700.css";

// Import Quasar css
import "quasar/src/css/index.sass";

var user = [];
var rootDomain = "http://localhost/scholars";

// const baseURL =
//   process.env.NODE_ENV === "development"
//     ? rootDomain + "/scholars_backend/"
//     : "/scholars_backend/";
export const baseURL = import.meta.env.DEV
  ? "http://localhost/scholars/scholars_backend/"
  : "../scholars/scholars_backend/";

const axios = axiosMain.create({
  baseURL,
  withCredentials: true,
});
const myApp = createApp(App);
myApp.provide("$axios", axios);

router.beforeEach(async (to, from, next) => {
  try {
    const response = await axios.get("/read.php?authLog", {
      withCredentials: true,
    });
    const user = response.data;

    myApp.provide("$user", user);

    if (!user || !user.username) {
      // Redirect to login if not logged in
      if (to.meta.requiresAuth) {
        return next("/");
      }
      return next();
    }

    if (to.path === "/") {
      return next("/reports");
    }

    // Check if the route has access restrictions
    if (to.meta.requiresAuth && to.meta.accountType) {
      if (!to.meta.accountType.includes(user.account_type)) {
        Notify.create({
          type: "negative",
          message: "Unauthorized access!",
        });
        return next("/reports"); // Redirect unauthorized users
      }
    }

    return next();
  } catch (error) {
    console.error("Auth Check Error:", error);
    return next("/");
  }
});

myApp.use(router);
myApp.use(Vue3Lottie);
myApp.use(Vue3Autocounter);
myApp.use(PasswordMeter);
myApp.use(Quasar, {
  plugins: { Notify, Loading, Dialog, LoadingBar },
  config: {
    loadingBar: {
      skipHijack: false,
      color: "primary",
      size: "3px",
    },
  }, // import Quasar plugins and add here
});

// Assumes you have a <div id="app"></div> in your index.html
myApp.mount("#app");
