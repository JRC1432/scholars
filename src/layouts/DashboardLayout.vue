<template>
  <q-layout view="lHh LpR fFf" class="background">
    <q-header flat height-hint="58" class="background secondary-text">
      <!-- Apply surface-container-lowest if needed -->
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="toggleLeftDrawer"
          aria-label="Menu"
          icon="menu"
        />

        <q-space />

        <div class="q-gutter-xs row items-center no-wrap">
          <DarkMode />
          <UserOpt />
        </div>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      class="q-pa-md primary-container"
      :width="240"
    >
      <q-scroll-area class="fit">
        <q-btn
          flat
          no-caps
          no-wrap
          class="q-ml-xs"
          v-if="$q.screen.gt.xs"
          to="/reports"
        >
          <q-avatar size="28px" rounded>
            <img src="http://localhost/scholars/public/seilogopng.png" />
          </q-avatar>
          <q-toolbar-title shrink class="text-weight-bold">
            DOST - SEI
          </q-toolbar-title>
        </q-btn>
        <q-list padding>
          <!-- Users Item -->
          <q-expansion-item label="User Management" icon="groups">
            <q-list>
              <q-item clickable active-class="my-menu-link" to="/user">
                <q-item-section avatar>
                  <IconUsers :size="30" stroke-width="2" />
                </q-item-section>
                <q-item-section>Staff Records</q-item-section>
              </q-item>
              <q-item clickable active-class="my-menu-link" to="/scholarrec">
                <q-item-section avatar>
                  <IconUserStar :size="30" stroke-width="2" />
                </q-item-section>
                <q-item-section>Scholar Records</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Scholars -->
          <q-item
            clickable
            v-ripple
            tag="a"
            to="/scholar"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <IconSchool :size="30" stroke-width="2" />
            </q-item-section>

            <q-item-section> Scholars</q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-xs" />

          <!-- Monitoring Information -->

          <q-expansion-item
            label="Monitoring Information"
            icon="screen_search_desktop"
          >
            <q-list>
              <q-item clickable active-class="my-menu-link" to="">
                <q-item-section avatar>
                  <IconFiles :size="30" stroke-width="2" />
                </q-item-section>
                <q-item-section
                  >Registration Forms For Validation</q-item-section
                >
              </q-item>
              <q-item clickable active-class="my-menu-link" to="">
                <q-item-section avatar>
                  <IconStar :size="30" stroke-width="2" />
                </q-item-section>
                <q-item-section>Grades For Validation</q-item-section>
              </q-item>
              <q-item clickable active-class="my-menu-link" to="">
                <q-item-section avatar>
                  <IconCertificate :size="30" stroke-width="2" />
                </q-item-section>
                <q-item-section>List of Scholars "FOR APPEAL"</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Financial Information -->

          <q-expansion-item
            label="Financial Information"
            icon="account_balance"
          >
            <q-list>
              <q-item clickable active-class="my-menu-link" to="/financial">
                <q-item-section avatar>
                  <q-icon name="volunteer_activism" />
                </q-item-section>
                <q-item-section>Financial Assistance</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Reports-->

          <q-expansion-item label="Reports" icon="query_stats">
            <q-list>
              <q-item clickable active-class="my-menu-link" to="/reports">
                <q-item-section avatar>
                  <IconReport :size="30" stroke-width="2" />
                </q-item-section>
                <q-item-section>Quick Report</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>
  </q-layout>
</template>
<script setup>
import DarkMode from "../components/DarkMode.vue";
import UserOpt from "../components/UserOpt.vue";

import { ref, inject, reactive, onMounted } from "vue";

import {
  IconUsersGroup,
  IconSchool,
  IconStar,
  IconFiles,
  IconReport,
  IconCertificate,
  IconUsers,
  IconUserStar,
} from "@tabler/icons-vue";

import router from "../router";

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>

<style lang="sass" scoped>

.my-menu-link
  color: white
  background: #27ADE4
  .my-card
  width: 100%
  max-width: 350px
  .rounded-borders-40
  border-radius: 40px !important // Adjust the radius as needed


  .example-item
  height: 5px
</style>
