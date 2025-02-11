<template>
  <q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
    <q-toolbar>
      <IconUserCancel :size="30" stroke-width="2" />

      <q-toolbar-title
        ><span class="text-weight-bold" color="primary">TERMINATE</span>
        SCHOLAR
      </q-toolbar-title>

      <q-btn flat round icon="close" v-close-popup />
    </q-toolbar>

    <q-card-section>
      <q-scroll-area style="height: 600px; max-width: 800px">
        <div class="q-pa-sm">
          <div class="row row_width q-col-gutter-xs">
            <!-- <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Scholar E-mail</span>
                <q-input outlined dense hide-bottom-space v-model="email" />
              </div>
            </div> -->
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Full Name:</span>
                <q-input outlined dense hide-bottom-space v-model="name" />
              </div>
            </div>
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Coordinator Name:</span>
                <q-input outlined dense hide-bottom-space v-model="cname" />
              </div>
            </div>
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Position:</span>
                <q-input outlined dense hide-bottom-space v-model="position" />
              </div>
            </div>
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Address:</span>
                <q-input outlined dense hide-bottom-space v-model="address" />
              </div>
            </div>
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">City:</span>
                <q-input outlined dense hide-bottom-space v-model="city" />
              </div>
            </div>
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Subject:</span>
                <q-input
                  readonly
                  outlined
                  dense
                  hide-bottom-space
                  v-model="subject"
                />
              </div>
            </div>

            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Reasons:</span>
                <q-option-group
                  :options="options"
                  type="checkbox"
                  v-model="group"
                />
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <span class="text-bold">Semester:</span>
              <q-input outlined dense hide-bottom-space v-model="sem" />
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <span class="text-bold">School Year:</span>
              <q-input
                outlined
                dense
                hide-bottom-space
                v-model="sy"
                mask="####-####"
              />
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <span class="text-bold">Year:</span>
              <q-input
                outlined
                dense
                hide-bottom-space
                v-model="year"
                mask="##"
              />
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <span class="text-bold">Months:</span>
              <q-input
                outlined
                dense
                hide-bottom-space
                v-model="months"
                mask="##"
              />
            </div>
            <div class="col-xs-12">
              <span class="text-bold">Signatory:</span>
              <q-input
                outlined
                dense
                readonly
                hide-bottom-space
                v-model="signatory"
              />
            </div>

            <div class="col-xs-12">
              <span class="text-bold">Input Code:</span>
              <div class="q-pa-md">
                <input
                  outlined
                  dense
                  hide-bottom-space
                  v-model="inputCode"
                  @input="generateBarcode"
                />
              </div>
            </div>
            <div class="col-xs-12">
              <q-checkbox v-model="showBarcode"> Show Barcode </q-checkbox>
            </div>
            <div class="col-xs-12">
              <canvas v-show="showBarcode" ref="barcodeCanvas"></canvas>
            </div>
          </div>
        </div>
      </q-scroll-area>
    </q-card-section>

    <q-dialog v-model="showMail">
      <div class="q-pa-md">
        <q-card
          style="min-width: 500px; width: 500px"
          class="rounded-borders-20"
        >
          <q-toolbar>
            <IconMailFast :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">Send</span>
              E-mail to Scholar
            </q-toolbar-title>

            <q-btn flat round dense icon="close" v-close-popup />
          </q-toolbar>
          <q-card-section>
            <div class="q-pa-xs">
              <span class="text-bold">E-Mail Address:</span>
              <q-input v-model="sendEmails" filled type="email" />

              <div class="q-pt-sm">
                <span class="text-bold">Attached File:</span>
                <q-file
                  ref="refBulkUpload"
                  filled
                  v-model="attachFile"
                  name="attachFile"
                  label="*PDF FILES ONLY"
                  color="primary"
                  clearable
                  counter
                  :rules="[fileRules]"
                >
                  <template v-slot:prepend>
                    <q-icon name="attach_file" />
                  </template>
                </q-file>
              </div>
            </div>

            <div></div>
          </q-card-section>
          <q-card-actions class="row justify-left"
            ><q-btn
              color="primary"
              icon="send"
              @click="sendMailNow"
              rounded
              label="Send Mail"
          /></q-card-actions>
        </q-card>
      </div>
    </q-dialog>

    <q-card-actions class="row justify-center">
      <q-btn
        rounded
        unelevated
        style="width: 80%"
        class="q-my-sm q-mx-sm inverse-primary"
        @click="printTerminate"
        >Print</q-btn
      >
      <q-btn
        rounded
        unelevated
        @click="showMail = true"
        style="width: 80%"
        class="q-my-sm q-mx-sm inverse-primary"
        >Send e-mail to scholar</q-btn
      >
    </q-card-actions>
  </q-card>
</template>
<script setup>
import { ref, computed, onMounted, watch, inject } from "vue";

import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import router from "../router";
import jsPDF from "jspdf";
import JsBarcode from "jsbarcode";
import "jspdf-autotable";
import { IconUserCancel, IconMailFast } from "@tabler/icons-vue";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const attachFile = ref([]);

const fileRules = (val) => {
  if (val === null) {
    return "Please Select a File!";
  }
  return true;
};

const email = ref("");
const group = ref([]);
const group2 = ref([]);
const name = ref("");
const showMail = ref(false);
const sendEmails = ref("");

const cname = ref("");
const position = ref("");
const address = ref("");
const city = ref("");

const subject = ref(
  "S&T SCHOLARSHIP STATUS CONTINUED: TO SUBMIT GRADES UPON COMPLETION"
);
const sem = ref("");
const sy = ref("");
const year = ref("");
const months = ref("");
const signatory = ref("JAYEEL S. CORNELIO, PhD");

const showBarcode = ref(true);
const inputCode = ref("");
const barcodeCanvas = ref(null);

// Function to generate the barcode
const generateBarcode = () => {
  if (showBarcode.value) {
    const canvas = barcodeCanvas.value;
    if (canvas) {
      JsBarcode(canvas, inputCode.value, {
        format: "CODE128",
        textPosition: "top",
        textAlign: "left",
      });
    }
  }
};

// Watcher for `showBarcode` to clear the canvas when unchecked
watch(showBarcode, (newValue) => {
  if (!newValue && barcodeCanvas.value) {
    const ctx = barcodeCanvas.value.getContext("2d");
    ctx.clearRect(0, 0, barcodeCanvas.value.width, barcodeCanvas.value.height);
  }
});

const options = [
  {
    label: "Two (2) or more grades of 5.0 (F) at the end of the Semester/Term.",
    value: "Two (2) or more grades of 5.0 (F) at the end of the Semester/Term.",
  },
  {
    label:
      "Third gradeof 5.0 (F) in a semester and did NOT pass two (2) failing grades incurred in two (2) previous semesters.",
    value:
      "Third gradeof 5.0 (F) in a semester and did NOT pass two (2) failing grades incurred in two (2) previous semesters.",
  },
];

const printTerminate = async () => {
  // Create a new instance of jsPDF
  const doc = new jsPDF();

  const logoUrl = new URL("../assets/seilogopng.png", import.meta.url).href; // Replace with your image URL
  const bpUrl = new URL("../assets/pilipinas.png", import.meta.url).href; // Replace with your image URL
  const tuvUrl = new URL("../assets/tuv.png", import.meta.url).href; // Replace with your image URL

  const imageCompression = 0.7;

  const canvas = barcodeCanvas.value;

  // Get Date
  const today = new Date();
  const formattedDate = today.toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  // Add the image from the URL to the PDF
  doc.addImage(logoUrl, "PNG", 10, 5, 20, 20, null, "FAST", imageCompression);

  // Set a title for the PDF

  doc.setFontSize(10);
  doc.setFont("helvetica", "bold");
  doc.text("Republic of the Philippines", 32, 11);

  doc.setFontSize(13);
  doc.setFont("helvetica", "bold");
  doc.text("DEPARTMENT OF SCIENCE AND TECHNOLOGY", 32, 17);

  doc.setFontSize(13);
  doc.setFont("helvetica", "bold");
  doc.text("SCIENCE EDUCATION INSTITUTE", 32, 23);

  // Add the image from the URL to the PDF
  doc.addImage(bpUrl, "PNG", 150, 5, 20, 20, null, "FAST", imageCompression);
  doc.addImage(tuvUrl, "PNG", 170, 5, 33, 20, null, "FAST", imageCompression);

  doc.setLineWidth(0.5);
  doc.line(10, 27, 203, 27); // x1, y1, x2, y2

  doc.setFontSize(8);
  doc.setFont("helvetica", "italic");
  doc.text("Service. Excellence. Innovation.", 10, 30);

  doc.setFont("helvetica", "normal"); // Set font and style
  doc.setFontSize(12); // Set font size
  doc.text(`${formattedDate}`, 140, 43); // Add the date to position (10, 10)

  doc.setFontSize(13);
  doc.setFont("helvetica", "bold");
  doc.text("MEMORANDUM", 30, 50);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text("FOR:", 43, 60);
  doc.setFontSize(12);
  doc.setFont("helvetica", "bold");
  doc.text((name.value || "N/A").toUpperCase(), 67, 60);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(cname.value || "N/A", 67, 65);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(position.value || "N/A", 67, 70);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(address.value || "N/A", 67, 75);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(city.value || "N/A", 67, 80);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text("SUBJECT:", 43, 95);
  doc.setFontSize(12);
  doc.setFont("helvetica", "bold");
  doc.text((subject.value || "N/A").toUpperCase(), 67, 95, { maxWidth: 120 });

  doc.setLineWidth(1.5);
  doc.line(30, 103, 190, 103); // x1, y1, x2, y2

  const paragraph = `        Per evaluation of your academic performace, we regret to inform you that you have incurred the following deficiencies:`;
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph, 34, 110, { maxWidth: 150, align: "justify" });

  // Add checkboxes and selected reasons
  const checkboxX = 44;
  let checkboxY = 130;

  options.forEach((option) => {
    // Draw a checkbox
    doc.rect(checkboxX, checkboxY, 5, 5);

    // Check if this option is selected
    if (group.value.includes(option.value)) {
      // Draw a checkmark inside the checkbox
      doc.text("X", checkboxX + 1, checkboxY + 4);
    }

    // Render the label next to the checkbox
    doc.text(option.label, checkboxX + 10, checkboxY + 4, { maxWidth: 140 });

    // Move to the next line
    checkboxY += 10;
  });

  // Set line thickness (border width)
  doc.setLineWidth(0.1);

  // Set position for the input box
  const inputX = 150;
  const inputY = 30;
  const inputWidth = 42;
  const inputHeight = 7;

  // Draw a rectangle (input box)
  doc.rect(inputX, inputY, inputWidth, inputHeight);

  // Add text inside the box (like the content inside an input box)
  const text = "SCHOLSTATForm5";
  doc.text(text, inputX + 2, inputY + 5); // Adjusted to fit inside the box

  const paragraph2 = `        In view of your unsatisfactory academic performance, you hereby advised that your DOST-SEI scholarship is TERMINATED WITH RETURN SERVICE effective end of the ${sem.value} Semester/Term of SY ${sy.value}. You are required to render service obligation after graduation for a period of ${year.value} year and ${months.value} months.`;
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph2, 34, 170, { maxWidth: 150, align: "justify" });

  const paragraph3 = `        Thank you for your understanding. We wish you the best in your future endeavors.`;
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph3, 34, 200, { maxWidth: 150, align: "justify" });

  doc.setFont("helvetica", "bold"); // Set font and style
  doc.setFontSize(12); // Set font size
  doc.text(`${signatory.value}`, 128, 230); // Add the date to position (10, 10)
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("DIRECTOR IV", 148, 235);

  // BarCode

  if (showBarcode.value && canvas) {
    const barcodeDataUrl = canvas.toDataURL("image/png");
    // Add the barcode to the PDF
    doc.addImage(barcodeDataUrl, "PNG", 34, 240, 70, 20);
  } else {
    // Add only the input code as text
    doc.text(inputCode.value, 34, 250);
  }

  // Footer

  doc.setLineWidth(0.5);
  doc.line(10, 275, 203, 275); // x1, y1, x2, y2

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("1st and 2nd Levels, Science Heritage Building", 10, 279);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("DOST Compound, General Santos Avenue", 10, 283);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("Bicutan, Taguig City, Philippines, 1631", 10, 287);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("URL: http://www.sei.dost.gov.ph", 10, 291);

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text(
    "Office of the Director (OD): (02) 8775-9005; Office of the Deputy Director (ODD): (02) 8775-9003;",
    112,
    278
  );

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text(
    "Science Education Innovations Division (SEID): (02) 8330-8912; Science and Technology Scholarship",
    107,
    281
  );

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text("Division (STSD): (02) 8330-8876, (02) 8330-8826;", 156, 284);

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text(
    "Science and Technology Manpower Education and Promotion Division (STMERPD): (02)",
    119,
    287
  );

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text(
    "8710-7462; Finance and Administrative Division (FAD):(02) 8775-9043; OD - Planning Unit: (02) 8542-",
    107,
    290
  );

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text(
    "4627; FAD - General Service Unit (GSU): (02) 8775-9156; FAD - Records Unit: (02) 8330-8772",
    114,
    293
  );

  // Save or open the PDF
  // doc.save("Termination_Notice.pdf");

  const blob = doc.output("blob");
  const pdfUrl = URL.createObjectURL(blob);
  window.open(pdfUrl, "_blank");
};

const sendMailNow = () => {
  var formData = new FormData();
  showMail.value = false;

  formData.append("scholar_email", sendEmails.value);
  formData.append("attachFile", attachFile.value);

  axios.post("/create.php?sendMailScholar", formData).then(function (response) {
    if (response.data == true) {
      $q.notify({
        message: "E-MAIL SENT SUCCESSFULLY",
        icon: "mark_email_read",
        color: "green",
        position: "top-right",
      });
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to send the e-mail",
      });
    }
  });
};

generateBarcode();
</script>
