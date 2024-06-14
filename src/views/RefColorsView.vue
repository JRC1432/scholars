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
          to="/scholar"
        >
          <q-avatar size="28px" rounded>
            <img src="http://localhost/scholars/public/seilogopng.png" />
          </q-avatar>
          <q-toolbar-title shrink class="text-weight-bold">
            DOST - SEI
          </q-toolbar-title>
        </q-btn>
        <q-list padding>
          <q-item
            clickable
            v-ripple
            tag="a"
            to="/user"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <!-- <q-icon name="groups" /> -->
              <IconUsersGroup :size="30" stroke-width="2" />
            </q-item-section>

            <q-item-section> User Management </q-item-section>
          </q-item>

          <!-- <q-separator class="q-my-md" /> -->

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

            <q-item-section> Scholars </q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-xs" />

          <q-item
            clickable
            v-ripple
            tag="a"
            to="/"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <IconUserPlus :size="30" stroke-width="2" />
            </q-item-section>

            <q-item-section> Add New Scholar </q-item-section>
          </q-item>
          <q-item
            clickable
            v-ripple
            tag="a"
            to="/viewscholar"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <IconSchool :size="30" stroke-width="2" />
            </q-item-section>

            <q-item-section> Scholars </q-item-section>
          </q-item>
          <q-item
            clickable
            v-ripple
            tag="a"
            to="/school"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <IconBuildingCommunity :size="30" stroke-width="2" />
            </q-item-section>

            <q-item-section> Schools </q-item-section>
          </q-item>
          <q-item
            clickable
            v-ripple
            tag="a"
            to="/log"
            class="rounded-borders q-my-xs"
            active-class="my-menu-link"
          >
            <q-item-section avatar>
              <IconFileInfo :size="30" stroke-width="2" />
            </q-item-section>

            <q-item-section> Logs </q-item-section>
          </q-item>
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
  IconChartPie,
  IconUsersGroup,
  IconUserPlus,
  IconSchool,
  IconBuildingCommunity,
  IconFileInfo,
  IconAlertOctagon,
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

  .example-item
  height: 5px
</style>
