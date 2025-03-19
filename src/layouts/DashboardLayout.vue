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
            <img src="../assets/seilogopng.png" />
          </q-avatar>
          <q-toolbar-title shrink class="text-weight-bold">
            DOST - SEI
          </q-toolbar-title>
        </q-btn>

        <div class="text-center text-caption">
          Undergraduate Scholarship Information System
          <q-badge align="top">V.2.0</q-badge>
        </div>
        <q-list padding>
          <!-- Users Item -->

          <q-item-section header class="text-bold" v-show="isAllowed"
            >USER MANAGEMENT</q-item-section
          >

          <q-expansion-item
            label="Users"
            icon="groups"
            dense
            v-show="isAllowed"
          >
            <q-list dense>
              <q-item
                clickable
                active-class="my-menu-link"
                to="/user"
                class="q-pl-none"
              >
                <q-item-section avatar>
                  <IconUsers :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section header>Staff Records</q-item-section>
              </q-item>
              <q-item clickable active-class="my-menu-link" to="/scholarrec">
                <q-item-section avatar>
                  <IconUserStar :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Scholar Records</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Scholars -->

          <q-item-section header class="text-bold">SCHOLARS</q-item-section>
          <q-item
            clickable
            v-ripple
            tag="a"
            to="/scholar"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <IconSchool :size="25" stroke-width="2" />
            </q-item-section>

            <q-item-section> Scholar Lists</q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-xs" />

          <!-- Monitoring Information -->

          <q-item-section header class="text-bold" v-show="isAllowed"
            >MONITORING</q-item-section
          >

          <q-expansion-item
            label="Monitoring Information"
            icon="screen_search_desktop"
            dense
            v-show="isAllowed"
          >
            <q-list dense>
              <q-item clickable active-class="my-menu-link" to="/regform">
                <q-item-section avatar>
                  <IconFiles :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section
                  >Registration Forms For Validation</q-item-section
                >
              </q-item>
              <q-item clickable active-class="my-menu-link" to="/gradeform">
                <q-item-section avatar>
                  <IconStar :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Grades For Validation</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Financial Information -->

          <q-item-section header class="text-bold" v-show="isAllowed"
            >FINANCIAL</q-item-section
          >

          <q-expansion-item
            label="Financial Information"
            icon="account_balance"
            dense
            v-show="isAllowed"
          >
            <q-list dense>
              <q-item clickable active-class="my-menu-link" to="/financial">
                <q-item-section avatar>
                  <q-icon name="volunteer_activism" />
                </q-item-section>
                <q-item-section>Financial Assistance</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Reports-->

          <q-item-section header class="text-bold">REPORTS</q-item-section>

          <q-expansion-item label="Data Reports" icon="query_stats" dense>
            <q-list dense>
              <q-item clickable active-class="my-menu-link" to="/reports">
                <q-item-section avatar>
                  <IconReport :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Quick Report</q-item-section>
              </q-item>
              <q-item
                clickable
                active-class="my-menu-link"
                to="/activityLogs"
                v-show="isAllowed"
              >
                <q-item-section avatar>
                  <IconFileTime :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Activity Logs</q-item-section>
              </q-item>
              <q-item
                clickable
                active-class="my-menu-link"
                to="/validate"
                v-show="isAllowed"
              >
                <q-item-section avatar>
                  <IconRosetteDiscountCheck :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Validate Status</q-item-section>
              </q-item>
              <q-item
                clickable
                active-class="my-menu-link"
                to="/release"
                v-show="isAllowed"
              >
                <q-item-section avatar>
                  <IconCash :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Release Allowance</q-item-section>
              </q-item>
            </q-list>
          </q-expansion-item>

          <!-- Batch Update -->

          <q-item-section header class="text-bold" v-show="isAllowed"
            >BATCH UPDATES</q-item-section
          >

          <q-expansion-item
            label="Batch Uploads"
            icon="cached"
            dense
            v-show="isAllowed"
          >
            <q-list dense>
              <q-item clickable active-class="my-menu-link" to="/contractstats">
                <q-item-section avatar>
                  <IconFileDescription :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Contract Status</q-item-section>
              </q-item>
              <q-item clickable active-class="my-menu-link" to="/progresstats">
                <q-item-section avatar>
                  <IconRosetteDiscountCheck :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Progress Status & Standing</q-item-section>
              </q-item>
              <!-- <q-item clickable active-class="my-menu-link" to="">
                <q-item-section avatar>
                  <IconShieldCheck :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Insurance</q-item-section>
              </q-item> -->
              <!-- <q-item
                clickable
                active-class="my-menu-link"
                to="/financialbatch"
              >
                <q-item-section avatar>
                  <IconCoins :size="25" stroke-width="2" />
                </q-item-section>
                <q-item-section>Financial</q-item-section>
              </q-item> -->
            </q-list>
          </q-expansion-item>

          <!-- Batch Update -->

          <q-item-section header class="text-bold" v-show="isAllowed"
            >MEMORANDUM</q-item-section
          >

          <q-item
            clickable
            v-ripple
            tag="a"
            to="/memo"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
            v-show="isAllowed"
          >
            <q-item-section avatar>
              <IconContract :size="25" stroke-width="2" />
            </q-item-section>

            <q-item-section> Memos Templates </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>
  </q-layout>
</template>
<script setup>
import DarkMode from "../components/DarkMode.vue";
import UserOpt from "../components/UserOpt.vue";

import { ref, inject, computed, onMounted } from "vue";

import {
  IconSchool,
  IconStar,
  IconFiles,
  IconFileDescription,
  IconReport,
  IconUsers,
  IconUserStar,
  IconRosetteDiscountCheck,
  IconBuildingBank,
  IconFileTime,
  IconShieldCheck,
  IconCash,
  IconCoins,
  IconContract,
} from "@tabler/icons-vue";

import router from "../router";

const user = inject("$user");

const isAllowed = computed(() => [300].includes(user.account_type));

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
  .overflow-hidden
  overflow: hidden


  .example-item
  height: 5px
</style>
