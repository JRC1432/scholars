<template>
  <q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
    <q-toolbar>
      <IconCoins :size="30" stroke-width="2" />

      <q-toolbar-title
        ><span class="text-weight-bold" color="primary">CONTINUED</span>
        W/ PARTIAL ALLOWANCE
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

            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="q-px-sm">
                <span class="text-bold">Deficiencies:</span>
                <q-option-group
                  :options="options"
                  type="checkbox"
                  v-model="group"
                />
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="q-px-sm">
                <!-- <span class="text-bold"></span> -->
                <q-option-group
                  :options="options2"
                  type="checkbox"
                  v-model="group2"
                />
              </div>
            </div>
            <div class="col-xs-12">
              <div class="q-px-sm">
                <span class="text-bold">Reconsidered:</span>
                <q-option-group
                  :options="options3"
                  type="checkbox"
                  v-model="group3"
                />
                <div
                  v-if="
                    group3.includes(
                      'Scholarship status is lifted effective start of the'
                    ) && group3.includes('Continued with Partial Allowance')
                  "
                  class="row row_width q-col-gutter-xs"
                >
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
                    <span class="text-bold">Semester:</span>
                    <q-input outlined dense hide-bottom-space v-model="sem1" />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">School Year:</span>
                    <q-input
                      outlined
                      dense
                      hide-bottom-space
                      v-model="sy1"
                      mask="####-####"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">Semester:</span>
                    <q-input outlined dense hide-bottom-space v-model="sem2" />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">School Year:</span>
                    <q-input
                      outlined
                      dense
                      hide-bottom-space
                      v-model="sy2"
                      mask="####-####"
                    />
                  </div>
                </div>

                <div
                  v-else-if="
                    group3.includes('Continued with Partial Allowance')
                  "
                  class="row row_width q-col-gutter-xs"
                >
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
                </div>

                <div
                  v-else-if="
                    group3.includes(
                      'Scholarship status is lifted effective start of the'
                    )
                  "
                  class="row row_width q-col-gutter-xs"
                >
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">Semester:</span>
                    <q-input outlined dense hide-bottom-space v-model="sem1" />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">School Year:</span>
                    <q-input
                      outlined
                      dense
                      hide-bottom-space
                      v-model="sy1"
                      mask="####-####"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">Semester:</span>
                    <q-input outlined dense hide-bottom-space v-model="sem2" />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <span class="text-bold">School Year:</span>
                    <q-input
                      outlined
                      dense
                      hide-bottom-space
                      v-model="sy2"
                      mask="####-####"
                    />
                  </div>
                </div>
                <div v-else></div>
              </div>
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
              ><span class="text-weight-bold" color="primary"
                >Partial Allowance</span
              >
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
        @click="printPartialAllowance"
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
import { IconCoins, IconMailFast } from "@tabler/icons-vue";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const fileRules = (val) => {
  if (val === null) {
    return "Please Select a File!";
  }
  return true;
};

const email = ref("");
const group = ref([]);
const group2 = ref([]);
const group3 = ref([]);
const name = ref("");

const showMail = ref(false);
const attachFile = ref([]);
const sendEmails = ref("");

const cname = ref("");
const position = ref("");
const address = ref("");
const city = ref("");

const subject = ref("S&T SCHOLARSHIP STATUS CONTINUED WITH PARTIAL ALLOWANCE");
const sem = ref("");
const sy = ref("");
const sem1 = ref("");
const sy1 = ref("");
const sem2 = ref("");
const sy2 = ref("");

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
    label: "Currently enrolled in an underload",
    value: "Currently enrolled in an underload",
  },
  {
    label: "Dropped more than 3 units in a semester/term",
    value: "Dropped more than 3 units in a semester/term",
  },
  {
    label: "General Weighted Average (GWA) below requirement",
    value: "General Weighted Average (GWA) below requirement",
  },
  {
    label: "Grades of 4.0/INC",
    value: "Grades of 4.0/INC",
  },
];

const options2 = [
  {
    label: "One (1) grade of 5.0/F",
    value: "One (1) grade of 5.0/F",
  },
  {
    label: "Second grade of 5.0/F",
    value: "Second grade of 5.0/F",
  },
  {
    label: "Grade of 4.0/INC and 1 grade of 5.0/F",
    value: "Grade of 4.0/INC and 1 grade of 5.0/F",
  },
  {
    label:
      "Third Grade of 5.0/F, but passed the two (2) grades incurred in two (2) previous semesters",
    value:
      "Third Grade of 5.0/F, but passed the two (2) grades incurred in two (2) previous semesters",
  },
];

const options3 = [
  {
    label: "Continued with Partial Allowance.",
    value: "Continued with Partial Allowance",
  },
  {
    label: "Scholarship status is lifted.",
    value: "Scholarship status is lifted effective start of the",
  },
];

const printPartialAllowance = async () => {
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

  const paragraph = `Per evaluation of your academic performance, it is noted that you have incurred the following deficiency/ies;`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Deficiencies Part 1
  0;
  // Wrap text inside a defined area
  doc.text(paragraph, 34, 110, { maxWidth: 150, align: "justify" });

  // Add checkboxes and selected reasons
  const checkboxX = 36;
  let checkboxY = 118;

  options.forEach((option) => {
    // Draw a checkbox
    doc.setLineWidth(0.5);
    doc.rect(checkboxX, checkboxY, 3, 3);

    // Check if this option is selected
    if (group.value.includes(option.value)) {
      // Draw a checkmark inside the checkbox
      doc.text("X", checkboxX + 0.5, checkboxY + 2.5);
    }

    // Render the label next to the checkbox
    doc.text(option.label, checkboxX + 8, checkboxY + 2, { maxWidth: 70 });

    // Move to the next line
    checkboxY += 8;
  });

  // Deficiencies Part 2

  // Add checkboxes and selected reasons
  const checkboxXx = 120;
  let checkboxYy = 118;

  options2.forEach((option2) => {
    doc.setLineWidth(0.5);
    // Draw a checkbox
    doc.rect(checkboxXx, checkboxYy, 3, 3);

    // Check if this option is selected
    if (group2.value.includes(option2.value)) {
      // Draw a checkmark inside the checkbox
      doc.text("X", checkboxXx + 0.5, checkboxYy + 2.5);
    }

    // Render the label next to the checkbox
    doc.text(option2.label, checkboxXx + 8, checkboxYy + 2, { maxWidth: 60 });

    // Move to the next line
    checkboxYy += 6;
  });

  const paragraph2 = `Considering the merits of your appeal, your scholarship is hereby reconsidered with status:`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph2, 45, 156, { maxWidth: 150, align: "justify" });

  // Reconsidered

  // Add checkboxes and selected reasons
  const checkboxXxx = 45;
  let checkboxYyy = 160;

  options3.forEach((option3) => {
    doc.setLineWidth(0.5);
    // Draw a checkbox
    doc.rect(checkboxXxx, checkboxYyy, 3, 3);

    // Check if this option is selected
    if (group3.value.includes(option3.value)) {
      // Draw a checkmark inside the checkbox
      doc.text("X", checkboxXxx + 0.5, checkboxYyy + 2.5);
    }

    // Render the label next to the checkbox
    doc.text(option3.value, checkboxXxx + 8, checkboxYyy + 2, {
      maxWidth: 135,
    });

    // Move to the next line
    checkboxYyy += 8;
  });

  const sentence = `Effective start of ${sem.value} Semester/Term of SY ${sy.value}.`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(sentence, 53, 166, { maxWidth: 130, align: "justify" });

  const sentence1 = `${sem1.value} Semester/Term of SY ${sy1.value}`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(sentence1, 127, 170, { maxWidth: 130, align: "justify" });

  const sentence2 = `and continued with partial allowance effective start of the ${sem2.value} Semester/Term of SY ${sy2.value}`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(sentence2, 53, 174, { maxWidth: 130, align: "justify" });

  const paragraph3 = `           You are still eligible for 100% of the tuition and other school fees subsidy, but only 50% of your monthly stipend and learning materials and/or connectivity allowance.`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph3, 34, 185, { maxWidth: 150, align: "justify" });

  const paragraph4 = `           Please note that obtaining academic deficiency/ies in the next semester(s)/term(s), may lead again to the partial release of your financial assistance or the termination of your scholarship grant. In connection to this, you are advised to prioritize your studies to improve your academic standing and maintain the required weighted average/QPI/QPA. Once relieved from the incurred academic deficiency/ies, the partial financial assistance that was put on hold will be released.`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph4, 34, 195, { maxWidth: 150, align: "justify" });

  const paragraph5 = `    Henceforth, please observe all the scholarship policies. Kindly submit your requirements, including your registration form at the beginning of every semester and the official copy of your grades at the end of each semester for evaluation and continuation of your scholarship.`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph5, 34, 222, { maxWidth: 150, align: "justify" });

  const paragraph6 = `For strict compliance.`;
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph6, 34, 240, { maxWidth: 140, align: "justify" });

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
  const text = "SCHOLSTATForm2";
  doc.text(text, inputX + 2, inputY + 5); // Adjusted to fit inside the box

  doc.setFont("helvetica", "bold"); // Set font and style
  doc.setFontSize(12); // Set font size
  doc.text(`${signatory.value}`, 128, 255); // Add the date to position (10, 10)
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("DIRECTOR IV", 148, 259);

  // BarCode

  if (showBarcode.value && canvas) {
    const barcodeDataUrl = canvas.toDataURL("image/png");
    // Add the barcode to the PDF
    doc.addImage(barcodeDataUrl, "PNG", 34, 255, 70, 20);
  } else {
    // Add only the input code as text
    doc.text(inputCode.value, 34, 265);
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

  axios.post("/create.php?sendMailPartial", formData).then(function (response) {
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
