<template>
  <div>
    <label>
      <input type="checkbox" v-model="showBarcode" />
      Show Barcode
    </label>
    <br />
    <input
      type="text"
      v-model="inputCode"
      placeholder="Enter Code"
      @input="generateBarcode"
    />
    <br />
    <div class="barcode-wrapper" v-show="showBarcode">
      <span class="barcode-label">{{ inputCode }}</span>
      <canvas ref="barcodeCanvas"></canvas>
    </div>
    <br />
    <q-btn label="Generate PDF" @click="generatePDF" color="primary" />
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { jsPDF } from "jspdf";
import JsBarcode from "jsbarcode";

// Reactive variables
const showBarcode = ref(true);
const inputCode = ref("123456");
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

// Function to generate PDF
const generatePDF = () => {
  const pdf = new jsPDF();
  const canvas = barcodeCanvas.value;

  if (showBarcode.value && canvas) {
    const barcodeDataUrl = canvas.toDataURL("image/png");
    // Add the barcode to the PDF
    pdf.addImage(barcodeDataUrl, "PNG", 10, 20, 100, 20);
    pdf.text(inputCode.value, 10, 15); // Position text above the barcode in the PDF
  } else {
    // Add only the input code as text
    pdf.text(inputCode.value, 10, 20);
  }

  // Save the PDF
  pdf.save("output.pdf");
};

// Initial barcode generation
generateBarcode();
</script>
