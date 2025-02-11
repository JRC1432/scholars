<template>
  <div class="q-pa-md" v-for="(term_fors, key) in term_for" :key="key">
    <transition
      appear
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
    >
      <q-card class="rounded-borders-20" v-show="showSimulatedReturnData">
        <q-banner inline-actions class="bg-primary text-white">
          <text class="text-caption">{{ key }}</text>
          <div>
            <text class="text-subtitle1">SY: {{ term_fors.sy }}, </text>
            <text class="text-subtitle1" v-if="term_fors.term === 1"
              >1st Term
            </text>
            <text class="text-subtitle1" v-else-if="term_fors.term === 2"
              >2nd Term
            </text>
            <text class="text-subtitle1" v-else-if="term_fors.term === 3"
              >Mid Year
            </text>
            <text class="text-subtitle1" v-else>Summer </text>
            <q-badge
              v-if="term_fors.term_required === 1"
              align="top"
              color="positive"
              >Term Required</q-badge
            >
            <q-badge v-else align="top" color="negative"
              >Term Not Required</q-badge
            >
            <q-badge
              v-if="term_fors.reg_verified_flag === 1"
              align="top"
              color="positive"
              >Register Form Verified</q-badge
            >
            <q-badge v-else align="top" color="negative"
              >Register Form Not Verified</q-badge
            >
          </div>
          <div class="text-subtitle1">
            {{ term_fors.school }}, {{ term_fors.courses }}
          </div>

          <template v-slot:action>
            <q-btn
              flat
              color="white"
              label="EDIT"
              @click="editGradesBtn(key)"
            />
          </template>
        </q-banner>

        <q-table
          :rows="term_fors.term_id"
          :columns="columns"
          row-key="name"
          class="no-border"
          wrap-cells
          flat
          bordered
        />

        <q-card-section>
          <div>
            <text class="text-subtitle1">
              Start of Term Status: {{ term_fors.progress_status_start }} -
              {{ term_fors.standing_start }}
            </text>
          </div>
          <div>
            <text class="text-subtitle1">
              End of Term Status: {{ term_fors.progress_status_end }} -
              {{ term_fors.standing_end }}
            </text>
          </div>
          <div class="q-ml-auto text-right">
            <q-chip color="amber-8" icon="grade">
              General Weighted Average: {{ term_fors.grade_ave }}
            </q-chip>
          </div>
        </q-card-section>
      </q-card>
    </transition>
  </div>

  <div class="q-pa-md">
    <q-chip
      outline
      color="deep-orange"
      text-color="white"
      icon="hotel_class"
      size="lg"
    >
      Total General Weighted Average:
      {{ totalGrades }}
    </q-chip>
  </div>

  <div class="row justify-center">
    <q-btn
      label="Print Grades"
      @click="printAllGrades"
      style="width: 40%"
      icon="print"
      rounded
      push
      color="accent"
    />
  </div>

  <q-inner-loading
    :showing="visible"
    label="Please wait..."
    label-class="text-teal"
    label-style="font-size: 1.1em"
  />
</template>
<script setup>
import { ref, onMounted, reactive, computed, inject } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import jsPDF from "jspdf";
import "jspdf-autotable";
import { IconMailFast } from "@tabler/icons-vue";

import Swal from "sweetalert2";
//
const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const rows = ref([]);

const showSimulatedReturnData = ref(false);
const visible = ref(false);

// Automatically show the loading state when the component is mounted
onMounted(() => {
  visible.value = true;
  showSimulatedReturnData.value = false;

  // Simulate an API call with a timeout
  setTimeout(() => {
    visible.value = false;
    showSimulatedReturnData.value = true;
  }, 2000);
});

const columns = [
  {
    name: "subj_code",
    required: true,
    label: "Subject Code",
    align: "left",
    field: "subj_code",
    sortable: true,
  },
  {
    name: "unit",
    required: true,
    label: "Units",
    align: "left",
    field: "unit",
    sortable: true,
  },
  {
    name: "grade",
    required: true,
    label: "Grades",
    align: "left",
    field: "grade",
    sortable: true,
  },
  {
    name: "completion",
    required: true,
    label: "Completion",
    align: "left",
    field: "completion",
    sortable: true,
  },
  {
    name: "remarks",
    required: true,
    label: "Remarks",
    align: "left",
    field: "remarks",
    sortable: true,
  },
];

const globalSPAS = ref();

const term_for = ref([]);
const totalGrades = ref();
const full_name = ref();

// Axios

const populateAll = () => {
  var formData = new FormData();
  globalSPAS.value = route.params.id;

  formData.append("id", globalSPAS.value);

  // Read TermID For Loop
  axios.post("/read.php?readTermIds", formData).then((response) => {
    term_for.value = response.data;
  });

  axios.post("/read.php?readTotalGrades", formData).then((response) => {
    totalGrades.value = parseFloat(
      parseFloat(response.data.average_grad_ave).toFixed(2)
    );
  });

  axios.post("/read.php?readScholarID", formData).then((response) => {
    full_name.value = response.data.full_name;
  });
};

const editGradesBtn = (key) => {
  router.push({
    path: "/editgrades/" + key,
  });

  sessionStorage.setItem("spasid", JSON.stringify(globalSPAS.value));
};

// Print Grades

const printAllGrades = () => {
  const doc = new jsPDF();
  const margin = 10; // PDF margins

  const logoUrl = new URL("../assets/seilogopng.png", import.meta.url).href; // Replace with your image URL

  // Add the image from the URL to the PDF
  doc.addImage(logoUrl, "PNG", 70, 5, 10, 10);

  // Set a title for the PDF
  doc.setFontSize(10);
  doc.setFont("helvetica", "bold");
  doc.text("Department of Science and Technology", 82, 8);

  doc.setFontSize(10);
  doc.setFont("helvetica", "bold");
  doc.text("SCIENCE EDUCATION INSTITUTE", 82, 13);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text(`Name: ${full_name.value}`, 10, 20);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text(`SPAS ID: ${globalSPAS.value}`, 150, 20);

  // Set a title for the PDF
  doc.setFontSize(15);
  doc.setFont("helvetica", "normal");
  doc.text("GRADE REPORT", 77, 30);

  // Prepare data for the table
  let rows = [];

  // Loop through term_for and segregate by term_id
  if (Array.isArray(term_for.value)) {
    // If term_for.value is an array of terms
    term_for.value.forEach((term_fors) => {
      if (Array.isArray(term_fors.term_id)) {
        // Create a header for the term with SY, term, and school
        const termHeader = `${term_fors.sy} - ${
          term_fors.term === 1
            ? "1st Term"
            : term_fors.term === 2
            ? "2nd Term"
            : term_fors.term === 3
            ? "Mid Year"
            : "Summer"
        } - ${term_fors.school}`;

        // Check if lastAutoTable.finalY is defined and is a number
        const startY =
          doc.lastAutoTable && doc.lastAutoTable.finalY
            ? doc.lastAutoTable.finalY + 20
            : margin + 35;

        // Add the term header with SY, term, and school
        doc.setFontSize(8);
        doc.text(termHeader, margin, startY);

        // Prepare the rows for the current term
        rows = [];

        // Loop through the courses of the current term
        term_fors.term_id.forEach((subject) => {
          rows.push([
            subject.subj_code,
            subject.unit,
            subject.grade,
            subject.completion,
            subject.remarks,
          ]);
        });

        // Columns headers for the table
        const columns = [
          "Subject Code",
          "Units",
          "Grades",
          "Completion",
          "Remarks",
        ];

        // Add the table for this term
        doc.autoTable(columns, rows, {
          startY: startY + 10, // Start below the previous content
          margin: { top: 20, left: margin },
          styles: { fontSize: 10, cellPadding: 5 },
          headStyles: { fillColor: [100, 149, 237] }, // Cornflower blue, readable and gentle
          bodyStyles: { fillColor: [240, 240, 240] }, // Custom row color
          theme: "striped", // Striped rows for better visibility
        });

        // Get the GWA for the term from the data
        const gwa = term_fors.grade_ave || "N/A"; // Assuming `grade_ave` holds the GWA for each term

        // Add the GWA for the term below the table
        doc.setFontSize(12);
        const gwaPosition =
          doc.lastAutoTable && doc.lastAutoTable.finalY
            ? doc.lastAutoTable.finalY + 10
            : startY + 10;
        doc.text(`GWA: ${gwa}`, margin, gwaPosition);
      }
    });
  } else if (typeof term_for.value === "object") {
    // If term_for.value is an object of terms
    for (let [key, val] of Object.entries(term_for.value)) {
      if (Array.isArray(val.term_id)) {
        // Create a header for the term with SY, term, and school
        const termHeader = `${val.sy} - ${
          val.term === 1
            ? "1st Term"
            : val.term === 2
            ? "2nd Term"
            : val.term === 3
            ? "Mid Year"
            : "Summer"
        } - ${val.school} - ${val.courses}`;

        // Check if lastAutoTable.finalY is defined and is a number
        const startY =
          doc.lastAutoTable && doc.lastAutoTable.finalY
            ? doc.lastAutoTable.finalY + 20
            : margin + 35;

        // Add the term header with SY, term, and school
        doc.setFontSize(8);
        doc.text(termHeader, margin, startY);

        // Prepare the rows for the current term
        rows = [];

        // Loop through the courses of the current term
        val.term_id.forEach((subject) => {
          rows.push([
            subject.subj_code,
            subject.unit,
            subject.grade,
            subject.completion,
            subject.remarks,
          ]);
        });

        // Columns headers for the table
        const columns = [
          "Subject Code",
          "Units",
          "Grades",
          "Completion",
          "Remarks",
        ];

        // Add the table for this term
        doc.autoTable(columns, rows, {
          startY: startY + 1, // Start below the previous content
          margin: { top: 20, left: margin },
          styles: { fontSize: 10, cellPadding: 5 },
          headStyles: { fillColor: [100, 149, 237] }, // Cornflower blue, readable and gentle
          bodyStyles: { fillColor: [240, 240, 240] }, // Custom row color
          theme: "striped", // Striped rows for better visibility
        });

        // Get the GWA for the term from the data
        const gwa = val.grade_ave || "N/A"; // Assuming `grade_ave` holds the GWA for each term

        // Add the GWA for the term below the table
        doc.setFontSize(12);
        const gwaPosition =
          doc.lastAutoTable && doc.lastAutoTable.finalY
            ? doc.lastAutoTable.finalY + 5
            : startY + 5;
        doc.text(`GWA: ${gwa}`, margin, gwaPosition);
      }
    }
  }

  // Add overall total grade at the bottom (from the main totalGrades)
  doc.setFontSize(12);
  const yPos =
    doc.lastAutoTable && doc.lastAutoTable.finalY
      ? doc.lastAutoTable.finalY + 20
      : 20; // Position below the last table
  doc.text(
    `Total General Weighted Average: ${totalGrades.value}`,
    margin,
    yPos
  );

  // Save the document
  doc.save("grades_report.pdf");
};

onMounted(() => {
  populateAll();
});
</script>
