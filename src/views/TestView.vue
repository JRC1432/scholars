<template>
  <q-page class="q-pa-md">
    <q-table :rows="rows" :columns="columns" row-key="id">
      <template v-slot:body-cell="props">
        <!-- Custom rendering for the category column -->
        <q-td
          v-if="props.col.name === 'category'"
          :props="props"
          :rowspan="getRowSpan(props.row.id)"
        >
          {{ props.row.category }}
        </q-td>
        <!-- Default rendering for other columns -->
        <q-td v-else :props="props">
          {{ props.row[props.col.name] }}
        </q-td>
      </template>
    </q-table>
  </q-page>
</template>

<script setup>
import { ref } from "vue";

const rows = ref([
  { id: 1, category: "Fruit", name: "Apple", quantity: 10 },
  { id: 2, category: "Fruit", name: "Orange", quantity: 20 },
  { id: 3, category: "Fruit", name: "Banana", quantity: 30 },
  { id: 4, category: "Vegetable", name: "Carrot", quantity: 15 },
  { id: 5, category: "Vegetable", name: "Broccoli", quantity: 25 },
]);

const columns = [
  {
    name: "category",
    required: true,
    label: "Category",
    align: "left",
    field: "category",
    sortable: true,
  },
  { name: "name", label: "Name", align: "left", field: "name", sortable: true },
  {
    name: "quantity",
    label: "Quantity",
    align: "right",
    field: "quantity",
    sortable: true,
  },
];

const rowSpans = ref({});

function calculateRowSpans() {
  const spans = {};
  let lastCategory = "";
  let spanCount = 0;

  rows.value.forEach((row, index) => {
    if (row.category === lastCategory) {
      spanCount++;
    } else {
      spanCount = 1;
      lastCategory = row.category;
    }
    spans[row.id] = spanCount;
  });

  rowSpans.value = spans;
}

calculateRowSpans();

function getRowSpan(rowId) {
  return rowSpans.value[rowId];
}
</script>
