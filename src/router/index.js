import { createRouter, createWebHashHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
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
          path: "/scholarrec",
          name: "scholarrec",
          component: () => import("../views/ScholarRecView.vue"),
        },
        {
          path: "/reports",
          name: "reports",
          component: () => import("../views/ReportsView.vue"),
        },
        {
          path: "/scholarmunicipality",
          name: "scholarmunicipality",
          component: () => import("../views/MunicipalityScholarsView.vue"),
        },
        {
          path: "/forappeal",
          name: "forappeal",
          component: () => import("../views/ForAppealView.vue"),
        },
        {
          path: "/validate",
          name: "validate",
          component: () => import("../views/ValidateView.vue"),
        },
        {
          path: "/contractstats/",
          name: "contractstats",
          component: () => import("../views/ContractStatusView.vue"),
        },
        {
          path: "/progresstats/",
          name: "progresstats",
          component: () => import("../views/ProgressStatsView.vue"),
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
          path: "/historyrec/:id",
          name: "historyrec",
          component: () => import("../views/HistoryView.vue"),
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
          path: "/examinfo/:id",
          name: "examinfo",
          component: () => import("../views/ExamInfoView.vue"),
        },
        {
          path: "/gradtrackinfo/:id",
          name: "gradtrackinfo",
          component: () => import("../views/GradObTrackInfoView.vue"),
        },
        {
          path: "/financeassists/:id",
          name: "financeassists",
          component: () => import("../views/FinancialsView.vue"),
        },
        {
          path: "/monitorsheet/:id",
          name: "monitorsheet",
          component: () => import("../views/MonitorSheetView.vue"),
        },
        {
          path: "/enrollmentinfo/:id",
          name: "enrollmentinfo",
          component: () => import("../views/EnrollmentInfoView.vue"),
        },
        {
          path: "/newenrollmentinfo/:id",
          name: "newenrollmentinfo",
          component: () => import("../views/NewEnrollmentInfoView.vue"),
        },
        {
          path: "/financial/",
          name: "financial",
          component: () => import("../views/FinancialAssistView.vue"),
        },
        {
          path: "/addfinancial/:id",
          name: "addfinancial",
          component: () => import("../views/AddFinancialView.vue"),
        },
        {
          path: "/updatefinancial/:id",
          name: "updatefinancial",
          component: () => import("../views/UpdateFinancialView.vue"),
        },
        {
          path: "/editgrades/:id",
          name: "editgrades",
          component: () => import("../views/EditGradesView.vue"),
        },
      ],
    },
  ],
});

export default router;
