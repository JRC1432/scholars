<template>
  <q-page class="q-pa-md fullbody">
    <q-toolbar>
      <!-- <q-avatar size="xl" rounded class="q-mr-md">
        <img src="http://localhost/scholars/public/seilogopng.png" />
      </q-avatar> -->
      <q-toolbar-title class="text-bold text-h5 q-pt-sm text-black">
        <!-- <div style="line-height: 1">
          Department of Science and Technology
          <span class="text-subtitle1" style="display: block"
            >Science Education Institute</span
          >
        </div> -->
      </q-toolbar-title>
      <div class="q-gutter-sm row">
        <q-avatar size="xl" rounded class="q-mr-md">
          <img src="http://localhost/scholars/public/seilogopng.png" />
        </q-avatar>
        <div
          style="line-height: 1"
          class="text-bold text-h5 q-pt-sm text-black"
        >
          Department of Science and Technology
          <span class="text-subtitle1" style="display: block"
            >Science Education Institute</span
          >
        </div>
      </div>
    </q-toolbar>
  </q-page>
</template>

<script>
export default {
  data() {
    return {
      text: "",
    };
  },
  methods: {
    submit() {
      this.$q.notify({
        message: "You entered: " + this.text,
        type: "positive",
      });
    },
  },
};
</script>

<style scoped>
.flex-center {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.fullbody {
  background: url("bg.jpg") no-repeat;
}

.top-right-toolbar {
  position: absolute;
  top: 0;
  right: 0;
  display: flex;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.8); /* Adjust as needed */
  padding: 10px; /* Adjust as needed */
  border-radius: 0 0 0 10px; /* Adjust as needed */
  width: 100%; /* Ensure it spans the full width of the page */
  box-sizing: border-box;
}
</style>
