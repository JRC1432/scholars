<template>
  <div id="app">
    <label>Password</label>
    <input type="password" v-model="password" @input="validatePassword" />
    <span style="color: red" v-if="errorMessage">{{ errorMessage }}</span>
    <PasswordMeter @score="onScore" :password="password" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import PasswordMeter from "vue-simple-password-meter";

// Reactive variables
const password = ref("");
const score = ref(null);
const errorMessage = ref("");

// Validation rules
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
  (val) => val.length >= 8 || "Password must be at least 8 characters long",
  (val) => score.value > 0 || "Use a better password",
];

// Function to validate password
const validatePassword = () => {
  for (const rule of inputRules) {
    const result = rule(password.value);
    if (result !== true) {
      errorMessage.value = result;
      return;
    }
  }
  errorMessage.value = "";
};

// Function to handle score from PasswordMeter
const onScore = (payload) => {
  console.log(payload.score); // from 0 to 4
  console.log(payload.strength); // one of: 'risky', 'guessable', 'weak', 'safe', 'secure'
  score.value = payload.score;
  validatePassword(); // Revalidate password whenever score changes
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  max-width: 400px;
  margin: 40px auto;
}

input {
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
}
</style>
