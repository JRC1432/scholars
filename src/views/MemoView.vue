<template>
  <div>
    <div class="text-h6 q-pb-xl q-pa-md text-bold">Memorandum Templates</div>

    <!-- Search Bar -->
    <div class="q-pa-md">
      <q-input
        v-model="searchQuery"
        outlined
        debounce="300"
        placeholder="SEARCH TEMPLATES..."
        clearable
      />
    </div>

    <!-- Memo Templates -->
    <div class="q-pa-md row items-start q-gutter-md justify-center">
      <q-card
        v-for="(template, index) in filteredTemplates"
        :key="index"
        class="my-card rounded-borders-10 hover-card"
        bordered
        hoverable
      >
        <q-img :src="template.image" />

        <q-card-section>
          <q-btn
            fab
            :color="template.color"
            :icon="template.icon"
            class="absolute"
            style="top: 0; right: 12px; transform: translateY(-50%)"
          />
          <div class="row no-wrap items-center">
            <div class="col text-h6 ellipsis">{{ template.title }}</div>
            <div
              class="col-auto text-grey text-caption q-pt-md row no-wrap items-center"
            >
              <!-- <q-icon name="place" />
              {{ template.distance }} -->
            </div>
          </div>
          <!-- <q-rating v-model="template.stars" :max="5" size="32px" /> -->
        </q-card-section>

        <q-card-section class="q-pt-none">
          <div class="text-subtitle1">{{ template.subtitle }}</div>
          <div class="text-caption text-grey">
            {{ template.description }}
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions class="row justify-center">
          <q-btn flat color="primary" @click="callFunction(template.btn)">
            Use this template
          </q-btn>
        </q-card-actions>
      </q-card>

      <q-dialog v-model="terminate" persistent>
        <q-card
          class="rounded-borders-20"
          style="width: 700px; max-width: 80vw"
        >
          <q-toolbar>
            <IconUserCancel :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">TERMINATE</span>
              SCHOLAR
            </q-toolbar-title>

            <q-btn flat round dense icon="close" v-close-popup />
          </q-toolbar>

          <q-card-section>
            <q-scroll-area style="height: 600px; max-width: 800px">
              <div class="q-pa-sm">
                <div class="row row_width q-col-gutter-xs">
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Scholar E-mail</span>
                      <q-input
                        outlined
                        dense
                        hide-bottom-space
                        v-model="email"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Full Name:</span>
                      <q-input
                        outlined
                        dense
                        hide-bottom-space
                        v-model="name"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Coordinator Name:</span>
                      <q-input
                        outlined
                        dense
                        hide-bottom-space
                        v-model="cname"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Position:</span>
                      <q-input
                        outlined
                        dense
                        hide-bottom-space
                        v-model="position"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Address:</span>
                      <q-input
                        outlined
                        dense
                        hide-bottom-space
                        v-model="address"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">City:</span>
                      <q-input
                        outlined
                        dense
                        hide-bottom-space
                        v-model="city"
                      />
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
                </div>
              </div>
            </q-scroll-area>
          </q-card-section>

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
              style="width: 80%"
              class="q-my-sm q-mx-sm inverse-primary"
              >Send e-mail to scholar</q-btn
            >
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

import { IconUserCancel } from "@tabler/icons-vue";
import jsPDF from "jspdf";
import "jspdf-autotable";

const searchQuery = ref("");
const terminate = ref(false);

const email = ref("");
const group = ref([]);
const name = ref("");

const cname = ref("");
const position = ref("");
const address = ref("");
const city = ref("");

const subject = ref(
  "S&T SCHOLARSHIP STATUS - TERMINATED WITH SERVICE OBLIGATION"
);
const sem = ref("");
const sy = ref("");
const year = ref("");
const months = ref("");
const signatory = ref("JAYEEL S. CORNELIO, PhD");

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

// Sample template data
const memoTemplates = ref([
  {
    title: "Scholarium",
    image: "https://cdn.quasar.dev/img/chicken-salad.jpg",
    distance: "250 ft",
    stars: 4,
    subtitle: "Scholars",
    description: "This memo is used to congratulate the scholars.",
    icon: "school",
    color: "green-4",
  },
  {
    title: "Terminator",
    image: "https://cdn.quasar.dev/img/chicken-salad.jpg",
    distance: "250 ft",
    stars: 5,
    subtitle: "Terminate Scholars",
    description: "This memo is used to terminate the scholars.",
    icon: "cancel",
    color: "red-4",
    btn: "openTerminate",
  },
  {
    title: "Passers",
    image: "https://cdn.quasar.dev/img/chicken-salad.jpg",
    distance: "250 ft",
    stars: 5,
    subtitle: "Passer Scholars",
    description: "This memo is used to acknowledge the scholars.",
    icon: "verified",
    color: "orange-4",
  },
  {
    title: "Achievers",
    image: "https://cdn.quasar.dev/img/chicken-salad.jpg",
    distance: "250 ft",
    stars: 5,
    subtitle: "Achiever Scholars",
    description: "This memo is used to acknowledge the scholars.",
    icon: "star",
    color: "purple-4",
  },
  {
    title: "Warned",
    image: "https://cdn.quasar.dev/img/chicken-salad.jpg",
    distance: "250 ft",
    stars: 5,
    subtitle: "Warned Scholars",
    description: "This memo is used to warn the scholars.",
    icon: "report",
    color: "pink-4",
  },

  // Add more templates here...
]);

// Filtered templates based on search query
const filteredTemplates = computed(() =>
  memoTemplates.value.filter((template) =>
    template.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
);

const callFunction = (btn) => {
  if (btn === "openTerminate") {
    terminate.value = true;
  }
};

const printTerminate = () => {
  // Create a new instance of jsPDF
  const doc = new jsPDF();

  const logoUrl = new URL("../assets/seilogopng.png", import.meta.url).href; // Replace with your image URL
  const bpUrl = new URL("../assets/pilipinas.png", import.meta.url).href; // Replace with your image URL
  const tuvUrl = new URL("../assets/tuv.jpg", import.meta.url).href; // Replace with your image URL

  // Get Date
  const today = new Date();
  const formattedDate = today.toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  // Add the image from the URL to the PDF
  doc.addImage(logoUrl, "PNG", 10, 5, 20, 20);

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
  doc.addImage(bpUrl, "PNG", 150, 5, 20, 20);
  doc.addImage(tuvUrl, "PNG", 170, 5, 33, 20);

  doc.setLineWidth(0.5);
  doc.line(10, 27, 203, 27); // x1, y1, x2, y2

  doc.setFontSize(8);
  doc.setFont("helvetica", "italic");
  doc.text("Service. Excellence. Innovation.", 10, 30);

  doc.setFont("helvetica", "normal"); // Set font and style
  doc.setFontSize(12); // Set font size
  doc.text(`${formattedDate}`, 150, 43); // Add the date to position (10, 10)

  doc.setFontSize(13);
  doc.setFont("helvetica", "bold");
  doc.text("MEMORANDUM", 15, 50);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text("FOR:", 15, 60);
  doc.setFontSize(12);
  doc.setFont("helvetica", "bold");
  doc.text((name.value || "N/A").toUpperCase(), 50, 60);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(cname.value || "N/A", 50, 65);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(position.value || "N/A", 50, 70);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(address.value || "N/A", 50, 75);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text(city.value || "N/A", 50, 80);

  // doc.setFontSize(12);
  // doc.setFont("helvetica", "normal");
  // doc.text("FROM:", 15, 80);
  // doc.setFontSize(12);
  // doc.setFont("helvetica", "bold");
  // doc.text((signatory.value || "N/A").toUpperCase(), 50, 80);
  // doc.setFontSize(10);
  // doc.setFont("helvetica", "normal");
  // doc.text("DIRECTOR IV", 50, 85);

  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");
  doc.text("SUBJECT:", 15, 95);
  doc.setFontSize(12);
  doc.setFont("helvetica", "bold");
  doc.text((subject.value || "N/A").toUpperCase(), 50, 95);

  doc.setLineWidth(1.5);
  doc.line(10, 100, 203, 100); // x1, y1, x2, y2

  const paragraph = `        Per evaluation of your academic performace, we regret to inform you that you have incurred the following deficiencies:`;
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph, 15, 110, { maxWidth: 180 });

  // Add checkboxes and selected reasons
  const checkboxX = 25;
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
    doc.text(option.label, checkboxX + 10, checkboxY + 4, { maxWidth: 160 });

    // Move to the next line
    checkboxY += 10;
  });

  // Set line thickness (border width)
  doc.setLineWidth(0.1);

  // Set position for the input box
  const inputX = 160;
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
  doc.text(paragraph2, 15, 170, { maxWidth: 180 });

  const paragraph3 = `        Thank you for your understanding. We wish you the best in your future endeavors.`;
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Wrap text inside a defined area
  doc.text(paragraph3, 15, 200, { maxWidth: 180 });

  doc.setFont("helvetica", "bold"); // Set font and style
  doc.setFontSize(12); // Set font size
  doc.text(`${signatory.value}`, 140, 230); // Add the date to position (10, 10)
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("DIRECTOR IV", 157, 235);

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
</script>

<style scoped>
.my-card {
  max-width: 300px;
  width: 100%;
}

.hover-card {
  transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
  transform: translateY(-6px); /* Lift effect */
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3); /* Stronger shadow effect */
}

/* Add spacing between images */
.marquee-container {
  display: flex; /* Ensure images align properly */
  gap: 16px; /* Space between images */
}

.marquee-image {
  margin: 0 100px; /* Optional: Add spacing around each image */
}
</style>
