import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/AboutView.vue"),
    },
    {
      path: "/ref",
      name: "ref",
      component: () => import("../views/RefColorsView.vue"),
    },
    {
      path: "/dashboards",
      component: () => import("../layouts/DashboardLayout.vue"),
      children: [
        {
          path: "/scholar",
          name: "scholar",
          component: () => import("../views/ScholarView.vue"),
        },
        {
          path: "/user",
          name: "user",
          component: () => import("../views/UserView.vue"),
        },
        {
          path: "/reports",
          name: "reports",
          component: () => import("../views/ReportsView.vue"),
        },
        {
          path: "/test/",
          name: "test",
          component: () => import("../views/TestView.vue"),
        },
        {
          path: "/test2/",
          name: "test2",
          component: () => import("../views/Test2View.vue"),
        },
        {
          path: "/personal/:id",
          name: "personal",
          component: () => import("../views/PersonalInfoView.vue"),
        },
        {
          path: "/scholarinfo/:id",
          name: "scholarinfo",
          component: () => import("../views/ScholarshipInfoView.vue"),
        },
        {
          path: "/undergradinfo/:id",
          name: "undergradinfo",
          component: () => import("../views/UndergradInfoView.vue"),
        },
        {
          path: "/statsrecord/:id",
          name: "statsrecord",
          component: () => import("../views/StatusRecordView.vue"),
        },
        {
          path: "/highschoolrec/:id",
          name: "highschoolrec",
          component: () => import("../views/HighschoolRecView.vue"),
        },
        {
          path: "/familyinfo/:id",
          name: "familyinfo",
          component: () => import("../views/FamInfoView.vue"),
        },
        {
          path: "/gradtrackinfo/:id",
          name: "gradtrackinfo",
          component: () => import("../views/GradObTrackInfoView.vue"),
        },
        {
          path: "/monitorsheet/:id",
          name: "monitorsheet",
          component: () => import("../views/MonitorSheetView.vue"),
        },
        {
          path: "/financial/",
          name: "financial",
          component: () => import("../views/FinancialAssistView.vue"),
        },
      ],
    },
  ],
});

export default router;
