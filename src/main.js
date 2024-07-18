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
const myApp = createApp(App);

// const baseURL =
//   process.env.NODE_ENV === "development"
//     ? rootDomain + "/scholars_backend/"
//     : "/scholars_backend/";
const baseURL = import.meta.env.DEV
  ? "http://localhost/scholars/scholars_backend/"
  : "../scholars/scholars_backend/";

const axios = axiosMain.create({
  baseURL,
  withCredentials: true,
});
myApp.provide("$axios", axios);
router.beforeEach((to, from, next) => {
  // console.log("text");
  // ...
  // explicitly return false to cancel the navigation
  axios
    .get("/read.php?authLog", {
      withCredentials: true,
    })
    .then(function (response) {
      user = response.data;
      // console.log(user);
      myApp.provide("$user", user);

      // console.log(response.data);
      // next();
      // return;

      if (response.data == false || response.data?.username == undefined) {
        // console.log(to);
        // next();

        if (to.path !== "/") {
          router.push("/");
          //   next();
        } else {
          next();
        }
      } else {
        if (to.path == "/") {
          router.push("/reports");
          //   next();
        }

        if (to?.meta?.access_level) {
          if (to?.meta?.access_level == user.access_level) {
            next();
          } else {
            router.push("/reports");
            // next();
          }
        } else {
          next();
        }
      }
    });
});

myApp.use(router);
myApp.use(Vue3Lottie);
myApp.use(Vue3Autocounter);
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
