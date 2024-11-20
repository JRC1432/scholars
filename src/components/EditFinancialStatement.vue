<template>
  <!-- test -->
  <div class="q-pa-md">
    <q-btn
      push
      rounded
      color="primary"
      @click="openFinance"
      icon="add"
      label="Add New Financial Statement"
    />
  </div>

  <div class="q-pa-md" v-for="(finance_fors, key) in finance_for" :key="key">
    <transition
      appear
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
    >
      <q-card
        class="my-card no-shadow rounded-borders-20"
        bordered
        v-show="showSimulatedReturnData"
      >
        <q-banner inline-actions class="banner-2">
          <div class="text-subtitle1">School Year: {{ finance_fors.sy }}</div>

          <!-- Button to create a new card -->
          <template v-slot:action>
            <q-btn
              unelevated
              rounded
              color="positive"
              class="q-mr-sm"
              icon="download"
              label="receipt"
              @click="printFinance(finance_fors)"
            />
            <q-btn
              unelevated
              rounded
              color="primary"
              label="Update"
              icon="edit"
              @click="updateFinance(finance_fors.id)"
            />
          </template>
        </q-banner>

        <q-card-section>
          <q-table
            :rows="finance_fors.details"
            row-key="name"
            class="no-border"
            wrap-cells
            flat
            bordered
          />
        </q-card-section>

        <q-card-section>
          <q-chip outline color="teal" text-color="white" icon="payments">
            TOTAL AMOUNT: ₱ {{ finance_fors.total_amt }}
          </q-chip>
        </q-card-section>
      </q-card>
    </transition>
  </div>
  <q-inner-loading
    :showing="visible"
    label="Please wait..."
    label-class="text-teal"
    label-style="font-size: 1.1em"
  />
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute } from "vue-router";
import jsPDF from "jspdf";
import "jspdf-autotable";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

const route = useRoute();
const visible = ref(false);
const showSimulatedReturnData = ref(false);

const finance_for = ref([]);

const globalSPAS = route.params.id;

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

const populateAll = async () => {
  var formData = new FormData();

  formData.append("id", globalSPAS);

  // Select School Year
  await axios.post("/read.php?readFinanceIds", formData).then((response) => {
    finance_for.value = response.data;
  });
};

const openFinance = () => {
  router.push({
    path: "/addfinancial/" + globalSPAS,
  });
};

const updateFinance = (id) => {
  router.push(`/updatefinancial/${globalSPAS}`);
  sessionStorage.setItem("id", JSON.stringify(id));
};

// Print Financial

const printFinance = (financeDetails) => {
  const doc = new jsPDF();

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

  // Set a title for the PDF
  doc.setFontSize(15);
  doc.setFont("helvetica", "italic");
  doc.text("FINANCIAL STATEMENT", 77, 30);

  doc.setFontSize(9);
  doc.setFont("helvetica", "normal");
  doc.text(`NAME: ${financeDetails.full_name}`, 10, 50);

  doc.setFontSize(9);
  doc.setFont("helvetica", "normal");
  doc.text(`SPAS ID: ${financeDetails.spas_id}`, 150, 50);

  // Add a subtitle with the school year
  doc.setFontSize(9);
  doc.setFont("helvetica", "normal");
  doc.text(`SY: ${financeDetails.sy}`, 10, 55);

  doc.setFontSize(9);
  doc.setFont("helvetica", "normal");
  doc.text(`PROGRAM: ${financeDetails.program}`, 150, 55);

  const maxWidth = 120;
  doc.setFontSize(9);
  doc.setFont("helvetica", "normal");
  // Split the text into lines that fit within the maxWidth
  const schoolText = doc.splitTextToSize(
    `SCHOOL: ${financeDetails.schools}`,
    maxWidth
  );
  doc.text(schoolText, 10, 60);

  doc.setFontSize(9);
  doc.setFont("helvetica", "normal");
  // Split the text into lines that fit within the maxWidth
  const courseText = doc.splitTextToSize(
    `COURSE: ${financeDetails.course}`,
    maxWidth
  );
  doc.text(courseText, 10, 65);

  // Generate table data for PDF
  const tableRows = financeDetails.details.map((detail) => [
    detail.term,
    detail.sy,
    detail.category,
    detail.year,
    detail.month,
    detail.date_process,
    detail.amount,
    detail.date_deposit,
    detail.remarks,
  ]);

  // Add a table to the PDF
  doc.autoTable({
    head: [
      [
        "Term",
        "School Year",
        "Category",
        "Year",
        "Month",
        "Date Process",
        "Amount",
        "Date Deposit",
        "Remarks",
      ],
    ],
    body: tableRows,
    startY: 75,
  });

  // Add the total amount as a footer
  doc.setFontSize(14);
  doc.setFont("helvetica", "normal");
  doc.text(
    `Total amount: P. ${financeDetails.total_amt}`,
    130,
    doc.lastAutoTable.finalY + 10
  );

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text(`created by: ${user.username}`, 10, doc.lastAutoTable.finalY + 25);

  // Save or preview the PDF
  doc.save(`Financial_Statement_${financeDetails.sy}.pdf`);
};

onMounted(() => {
  populateAll(); // Fetch options on component mount
});
</script>

<style scoped>
.q-table td {
  text-align: left !important;
}
</style>
