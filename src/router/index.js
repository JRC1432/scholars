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
          meta: { requiresAuth: true, accountType: [300, 100] },
        },
        {
          path: "/user",
          name: "user",
          component: () => import("../views/UserView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/scholarrec",
          name: "scholarrec",
          component: () => import("../views/ScholarRecView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/reports",
          name: "reports",
          component: () => import("../views/ReportsView.vue"),
          meta: { requiresAuth: true, accountType: [300, 100] },
        },
        {
          path: "/scholarmunicipality",
          name: "scholarmunicipality",
          component: () => import("../views/MunicipalityScholarsView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/forappeal",
          name: "forappeal",
          component: () => import("../views/ForAppealView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/validate",
          name: "validate",
          component: () => import("../views/ValidateView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/contractstats/",
          name: "contractstats",
          component: () => import("../views/ContractStatusView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/progresstats/",
          name: "progresstats",
          component: () => import("../views/ProgressStatsView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/test/",
          name: "test",
          component: () => import("../views/TestView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/test2/",
          name: "test2",
          component: () => import("../views/Test2View.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/personal/:id",
          name: "personal",
          component: () => import("../views/PersonalInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/scholarinfo/:id",
          name: "scholarinfo",
          component: () => import("../views/ScholarshipInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/undergradinfo/:id",
          name: "undergradinfo",
          component: () => import("../views/UndergradInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/statsrecord/:id",
          name: "statsrecord",
          component: () => import("../views/StatusRecordView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/historyrec/:id",
          name: "historyrec",
          component: () => import("../views/HistoryView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },

        {
          path: "/highschoolrec/:id",
          name: "highschoolrec",
          component: () => import("../views/HighschoolRecView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/familyinfo/:id",
          name: "familyinfo",
          component: () => import("../views/FamInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/examinfo/:id",
          name: "examinfo",
          component: () => import("../views/ExamInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/gradtrackinfo/:id",
          name: "gradtrackinfo",
          component: () => import("../views/GradObTrackInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/financeassists/:id",
          name: "financeassists",
          component: () => import("../views/FinancialsView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/monitorsheet/:id",
          name: "monitorsheet",
          component: () => import("../views/MonitorSheetView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/enrollmentinfo/:id",
          name: "enrollmentinfo",
          component: () => import("../views/EnrollmentInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/newenrollmentinfo/:id",
          name: "newenrollmentinfo",
          component: () => import("../views/NewEnrollmentInfoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/financial/",
          name: "financial",
          component: () => import("../views/FinancialAssistView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/addfinancial/:id",
          name: "addfinancial",
          component: () => import("../views/AddFinancialView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/updatefinancial/:id",
          name: "updatefinancial",
          component: () => import("../views/UpdateFinancialView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/editgrades/:id",
          name: "editgrades",
          component: () => import("../views/EditGradesView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/regform/",
          name: "regform",
          component: () => import("../views/RegFormView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/gradeform/",
          name: "gradeform",
          component: () => import("../views/GradesFormView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/activityLogs/",
          name: "activityLogs",
          component: () => import("../views/ActLogView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/release/",
          name: "release",
          component: () => import("../views/ReleaseAllowanceView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/financialbatch/",
          name: "financialbatch",
          component: () => import("../views/FinancialBatchView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
        {
          path: "/memo/",
          name: "memo",
          component: () => import("../views/MemoView.vue"),
          meta: { requiresAuth: true, accountType: [300] },
        },
      ],
    },
  ],
});

export default router;
