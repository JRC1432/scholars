<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Undergraduate Records
      </div>
      <!-- <q-separator class="q-mt-md q-mb-xs" inset /> -->
      <div class="q-pa-lg">
        <q-table
          flat
          bordered
          :rows="rows"
          :columns="columns"
          row-key="name"
          :filter="filter"
          v-model:pagination="pagination"
          class="no-border surface-container"
        >
          <template v-slot:top-right>
            <q-input
              borderless
              dense
              debounce="300"
              v-model="filter"
              placeholder="Search"
            >
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>

          <template v-slot:body="props">
            <q-tr :prop="props"
              ><q-td key="course" :props="props">
                {{ props.row.course }}
              </q-td>
              <q-td key="discipline" :props="props">
                {{ props.row.discipline }}
              </q-td>
              <q-td key="schools" :props="props">
                {{ props.row.schools }}
              </q-td>
              <q-td key="sy_start" :props="props">
                {{ props.row.sy_start }}
              </q-td>
              <q-td key="term_start" :props="props">
                <template v-if="props.row.term_type === 2">
                  <template v-if="props.row.term_start == 1">1st</template>
                  <template v-else-if="props.row.term_start == 2">2nd</template>
                  <template v-else-if="props.row.term_start == 3"
                    >Summer</template
                  >
                  <template v-else>--</template>
                </template>

                <template v-else-if="props.row.term_type === 3">
                  <template v-if="props.row.term_start == 1">1st</template>
                  <template v-else-if="props.row.term_start == 2">2nd</template>
                  <template v-else-if="props.row.term_start == 3">3rd</template>
                  <template v-else-if="props.row.term_start == 4"
                    >Summer</template
                  >
                  <template v-else>--</template>
                </template>
                <template v-else-if="props.row.term_type === 4">
                  <template v-if="props.row.term_start == 1">1st</template>
                  <template v-else-if="props.row.term_start == 2">2nd</template>
                  <template v-else-if="props.row.term_start == 3">3rd</template>
                  <template v-else-if="props.row.term_start == 4">4th</template>
                  <template v-else>--</template>
                </template>
              </q-td>

              <!-- Custom cell for term_type_name -->

              <q-td key="term_type" :props="props">
                <template v-if="props.row.term_type == 2">Semestral</template>
                <template v-else-if="props.row.term_type == 3"
                  >Trimestral</template
                >
                <template v-else-if="props.row.term_type == 4"
                  >Quarterly</template
                >
                <template v-else>--</template>
              </q-td>

              <q-td key="latest_flag" :props="props">
                <template v-if="props.row.latest_flag === 1"> Yes </template>
                <template v-else> No </template>
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </q-card>
  </div>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import { IconScript } from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Items Variable

const rows = ref([]);
const filter = ref("");
const pagination = ref({
  rowsPerPage: 10,
});

const columns = [
  {
    name: "course",
    required: true,
    label: "Course",
    align: "left",
    field: "course",
    sortable: true,
  },

  {
    name: "discipline",
    required: true,
    label: "Discipline",
    align: "left",
    field: "discipline",
    sortable: true,
  },
  {
    name: "schools",
    align: "left",
    label: "School",
    field: "schools",
    sortable: true,
  },
  {
    name: "sy_start",
    align: "left",
    label: "School Year",
    field: "sy_start",
    sortable: true,
  },

  {
    name: "term_start",
    align: "left",
    label: "Term",
    field: "term_start",
    sortable: true,
  },

  {
    name: "term_type",
    align: "left",
    label: "Type",
    field: "term_type",
    sortable: true,
  },

  {
    name: "latest_flag",
    align: "left",
    label: "Current",
    field: "latest_flag",
    sortable: true,
  },
];

// Read UnderGrad
const id = ref();
onMounted(() => {
  readundergradinfo();
});

const readundergradinfo = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readUndergradID", formData).then((response) => {
    rows.value = response.data;
  });
};
</script>
