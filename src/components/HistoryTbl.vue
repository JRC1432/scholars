<template>
  <div class="primary-text">SPAS ID: {{ props.spasid.spas_id }}</div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 q-pa-sm">
      <q-card class="my-card text-black rounded-borders-20 q-mr-sm">
        <q-table
          :rows="rows"
          :columns="columns"
          row-key="name"
          :filter="filter"
          v-model:pagination="pagination"
          class="no-border"
          wrap-cells
          flat
          bordered
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

          <template v-slot:top-left>
            <q-btn rounded outline style="color: goldenrod" icon="add">
              <q-tooltip>
                Add Status, Course and School & Verify All
              </q-tooltip>
              <q-menu transition-show="flip-right" transition-hide="flip-left">
                <q-list style="min-width: 100px">
                  <q-item clickable @click="addStatus">
                    <q-item-section avatar>
                      <IconCircleDashedCheck :size="30" stroke-width="2" />
                    </q-item-section>
                    <q-item-section>Add Status</q-item-section>
                  </q-item>
                  <q-item clickable @click="addSC">
                    <q-item-section avatar>
                      <IconBackpack :size="30" stroke-width="2" />
                    </q-item-section>
                    <q-item-section>Add Course and School</q-item-section>
                  </q-item>
                  <q-item clickable>
                    <q-item-section avatar>
                      <IconChecks :size="30" stroke-width="2" />
                    </q-item-section>
                    <q-item-section>Verify All</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </template>

          <template v-slot:body="props">
            <q-tr :prop="props">
              <q-td key="sy" :props="props">
                {{ props.row.sy }}
              </q-td>

              <q-td key="name" :props="props">
                {{ props.row.name }}
              </q-td>
              <q-td key="schoolcourse" :props="props">
                <q-badge
                  v-if="
                    props.row.schoolcourse === null ||
                    props.row.schoolcourse === ''
                  "
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>
                <q-badge
                  v-else
                  @click="openSC(props)"
                  color="light-green-4"
                  :label="props.value"
                  class="pointer-class"
                >
                  {{ props.row.schoolcourse }}
                </q-badge>
              </q-td>
              <q-td key="pstart" :props="props">
                <q-badge
                  v-if="props.row.pstart === null || props.row.pstart === ''"
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>
                <q-badge
                  v-else
                  @click="openpstart(props)"
                  color="light-green-4"
                  :label="props.value"
                  class="pointer-class"
                >
                  {{ props.row.pstart }}
                </q-badge>
              </q-td>
              <q-td key="sstanding" :props="props">
                <q-badge
                  v-if="
                    props.row.sstanding === null || props.row.sstanding === ''
                  "
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>
                <q-badge
                  v-else
                  @click="opensstanding(props)"
                  color="light-green-4"
                  :label="props.value"
                  class="pointer-class"
                >
                  {{ props.row.sstanding }}
                </q-badge>
              </q-td>

              <q-td key="pend" :props="props">
                <q-badge
                  v-if="props.row.pend === null || props.row.pend === ''"
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>

                <q-badge
                  v-else
                  @click="openpend(props)"
                  color="light-green-4"
                  :label="props.value"
                  class="pointer-class"
                >
                  {{ props.row.pend }}
                </q-badge>
              </q-td>
              <q-td key="send" :props="props">
                <q-badge
                  v-if="props.row.send === null || props.row.send === ''"
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>
                <q-badge
                  v-else
                  @click="opensend(props)"
                  color="light-green-4"
                  :label="props.value"
                  class="pointer-class"
                >
                  {{ props.row.send }}
                </q-badge>
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-4 q-pa-sm">
      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        full-width
        v-if="viewcourse"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              COURSE
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ sy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ term }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">School:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ school }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Course:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ course }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ create }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ update }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ verified }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    created_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    updated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>

      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="pstart"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              Start Status
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ pstartSy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartTerm
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="pstartSE === 1">
                  <text class="on-surface-text text-bold">START</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">END</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Progress Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartProgress
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartCreate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartVerified
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pstartUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>

      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="standstart"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              Start Term
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermsy
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermterm
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="startTermStrEnd === 1">
                  <text class="on-surface-text text-bold">START</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">END</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Standing:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermStand
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Monitoring Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermMonitor
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermCreated
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermVerified_by
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    startTermUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>
      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="pend"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              Status End
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ pendSy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ pendTerm }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="pendSE === 2">
                  <text class="on-surface-text text-bold">END</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">START</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Progress Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendProgress
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendCreate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendVerified
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    pendUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>

      <q-card
        class="my-q-card rounded-borders-20"
        flat
        bordered
        v-else-if="standend"
      >
        <q-card-section
          ><q-toolbar>
            <IconProgress :size="30" stroke-width="2" />

            <q-toolbar-title
              ><span class="text-weight-bold" color="primary">VIEW</span>
              End Term
            </q-toolbar-title>
          </q-toolbar>
        </q-card-section>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">School Year:</td>
                <td>
                  <text class="on-surface-text text-bold">{{ endTermsy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermterm
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Start/End:</td>
                <td v-if="endTermStrEnd === 2">
                  <text class="on-surface-text text-bold">END</text>
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">START</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Standing:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermStand
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Monitoring Status:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermMonitor
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermCreated
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermUpdate
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermVerified_by
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermCreated_at
                  }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated At:</td>
                <td>
                  <text class="on-surface-text text-bold">{{
                    endTermUpdated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>
      <q-card class="my-q-card rounded-borders-20" flat bordered v-else>
        <Vue3Lottie
          animationLink="https://lottie.host/3a3a54dc-d976-46fd-9610-70caf9191c05/QMrukbOnfT.json"
          style="height: calc(30vh)"
          :height="500"
          :width="500"
        />
      </q-card>
    </div>
  </div>

  <!-- Status Modal -->

  <q-dialog v-model="openStatus" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconCircleDashedCheck :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">ADD</span>
          STATUS
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <div class="q-px-sm">
          <span class="text-bold">Term Record</span>
          <q-select
            ref="reftermRec"
            :options="termRecOptions"
            v-model="state.termRec"
            emit-value
            name="termRec"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
        <div class="q-px-sm" v-if="state.termRec === 'Add New Term Record'">
          <span class="text-bold">School Year</span>
          <q-select
            ref="refstatSy"
            outlined
            dense
            hide-bottom-space
            behavior="menu"
            emit-value
            map-options
            use-input
            input-debounce="0"
            v-model="state.statSy"
            name="statSy"
            :options="syOptions"
            @filter="filtersy"
            :rules="[myRule]"
            mask="#### - ####"
            clearable
          />
        </div>
        <div class="q-px-sm" v-if="state.termRec === 'Add New Term Record'">
          <span class="text-bold">Term Type</span>
          <q-select
            ref="refStatTermType"
            :options="termtypeptions"
            v-model="state.StatTermType"
            emit-value
            name="StatTermType"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
        <div class="q-px-sm" v-if="state.termRec === 'Add New Term Record'">
          <span class="text-bold">Term</span>
          <q-select
            ref="refStatTerm"
            :options="termOptions"
            v-model="state.StatTerm"
            emit-value
            name="StatTerm"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
        <div class="q-px-sm text-bold">
          <span class="text-bold">Start/End of Term?</span>
          <q-radio
            v-model="seTerm"
            checked-icon="task_alt"
            unchecked-icon="panorama_fish_eye"
            val="1"
            label="START"
          />
          <q-radio
            v-model="seTerm"
            checked-icon="task_alt"
            unchecked-icon="panorama_fish_eye"
            val="0"
            label="END"
          />
        </div>

        <div class="q-px-sm text-bold">
          <span class="text-bold">Status is latest?</span>
          <q-toggle
            :label="statLatest"
            v-model="statLatest"
            checked-icon="check"
            color="green"
            unchecked-icon="clear"
            false-value="NO"
            true-value="YES"
            name="statLatest"
          />
        </div>
        <div class="q-px-sm text-bold">
          <span class="text-bold">Status</span>
          <q-select
            outlined
            dense
            hide-bottom-space
            emit-value
            map-options
            use-input
            input-debounce="0"
            :options="stat1options"
            @filter="filterstat1"
            v-model="state.statTerm"
            name="statTerm"
            clearable
          />
        </div>
        <div class="q-px-sm text-bold">
          <span class="text-bold">Monitoring Status</span>
          <q-select
            v-model="state.monitorStats"
            name="monitorStats"
            outlined
            dense
            hide-bottom-space
            emit-value
            map-options
            use-input
            input-debounce="0"
            :options="stat2options"
            @filter="filterstat2"
            clearable
          />
        </div>
        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn outline style="color: goldenrod" label="Save" />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </q-card-section>
    </q-card>
  </q-dialog>

  <!-- COurse and School -->

  <q-dialog v-model="openAddSC" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconCircleDashedCheck :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">ADD</span>
          Course & School
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <div class="q-px-sm">
          <span class="text-bold">Term Record</span>
          <q-select
            ref="refcsTermRec"
            :options="termRecOptions"
            v-model="state.csTermRec"
            emit-value
            name="csTermRec"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
            hint="Add New Term Record"
          />
        </div>
        <div class="q-px-sm" v-if="state.csTermRec === 'Add New Term Record'">
          <span class="text-bold">School Year</span>
          <q-select
            ref="refcsstatSy"
            outlined
            dense
            hide-bottom-space
            behavior="menu"
            emit-value
            map-options
            use-input
            input-debounce="0"
            mask="#### - ####"
            clearable
            :options="syOptions"
            @filter="filtersy"
            v-model="state.csstatSy"
            name="csstatSy"
            :rules="[myRule]"
          />
        </div>
        <div class="q-px-sm" v-if="state.csTermRec === 'Add New Term Record'">
          <span class="text-bold">Term Type</span>
          <q-select
            ref="refcsStatTermType"
            :options="termtypeptions"
            v-model="state.csStatTermType"
            emit-value
            name="csStatTermType"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
        <div class="q-px-sm" v-if="state.csTermRec === 'Add New Term Record'">
          <span class="text-bold">Term</span>
          <q-select
            ref="refcsStatTerm"
            :options="termOptions"
            v-model="state.csStatTerm"
            emit-value
            name="csStatTerm"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>

        <div class="q-px-sm text-bold">
          <span class="text-bold">School & Course Record</span>
          <q-select
            ref="refscrTerm"
            :options="scrTermoptions"
            v-model="state.scrTerm"
            emit-value
            name="scrTerm"
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn outline style="color: goldenrod" label="Save" />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed, defineProps } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import {
  IconCertificate,
  IconProgress,
  IconCircleDashedCheck,
  IconChecks,
  IconBackpack,
} from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

const rows = ref([]);
const filter = ref("");
const pagination = ref({
  rowsPerPage: 5,
});

const props = defineProps({
  spasid: {
    type: [String, Number],
    default: null, // Use default if the value might be undefined
  },
});

// State

const state = reactive({
  termRec: "Add New Term Record",
  statTerm: "",
  monitorStats: "",
  csTermRec: "",
});

// Cards trigger
const viewcourse = ref(false);
const pstart = ref(false);
const standstart = ref(false);
const pend = ref(false);
const standend = ref(false);
const openStatus = ref(false);
const openAddSC = ref(false);

// View Course Variables

const sy = ref();
const term = ref();
const school = ref();
const course = ref();
const create = ref();
const update = ref();
const verified = ref();
const created_at = ref();
const updated_at = ref();

// View progress Status

const pstartSy = ref();
const pstartTerm = ref();
const pstartSE = ref();
const pstartProgress = ref();
const pstartCreate = ref();
const pstartUpdate = ref();
const pstartVerified = ref();
const pstartCreated_at = ref();
const pstartUpdated_at = ref();

// View progress End

const pendSy = ref();
const pendTerm = ref();
const pendSE = ref();
const pendProgress = ref();
const pendCreate = ref();
const pendUpdate = ref();
const pendVerified = ref();
const pendCreated_at = ref();
const pendUpdated_at = ref();

// View Start Term Standing

const startTermsy = ref();
const startTermterm = ref();
const startTermStrEnd = ref();
const startTermStand = ref();
const startTermMonitor = ref();
const startTermCreated = ref();
const startTermUpdate = ref();
const startTermVerified_by = ref();
const startTermCreated_at = ref();
const startTermUpdated_at = ref();

// View End Term Standing

const endTermsy = ref();
const endTermterm = ref();
const endTermStrEnd = ref();
const endTermStand = ref();
const endTermMonitor = ref();
const endTermCreated = ref();
const endTermUpdate = ref();
const endTermVerified_by = ref();
const endTermCreated_at = ref();
const endTermUpdated_at = ref();

// View history

const seTerm = ref("1");
const statLatest = ref("NO");

// Validataions

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

const columns = [
  {
    name: "sy",
    required: true,
    label: "School Year",
    align: "center",
    field: "sy",
    sortable: true,
  },

  {
    name: "name",
    required: true,
    label: "Term",
    align: "center",
    field: "name",
    sortable: true,
  },
  {
    name: "schoolcourse",
    align: "center",
    label: "School & Course",
    field: "schoolcourse",
    sortable: true,
  },
  {
    name: "pstart",
    align: "left",
    label: "Progress Status (START)",
    field: "pstart",
    sortable: true,
  },

  {
    name: "sstanding",
    align: "left",
    label: "Start of Term Standing",
    field: "sstanding",
    sortable: true,
  },

  {
    name: "pend",
    align: "left",
    label: "Progress Status (END)",
    field: "pend",
    sortable: true,
  },

  {
    name: "send",
    align: "left",
    label: "End of Term Standing",
    field: "send",
    sortable: true,
  },
];

const globalSPAS = props.spasid.spas_id;

// Select Statements

const termRecOptions = ref();
const scrTermoptions = ref("Select");
const preTermRec = "Add New Term Record";

// Read History Records

var stat2options2 = [];
const stat2options = ref(stat2options2);
var stat1options2 = [];
const stat1options = ref(stat1options2);
var syOptions2 = [];
const syOptions = ref(syOptions2);

onMounted(() => {
  readHistoryRec();
});

const readHistoryRec = () => {
  var formData = new FormData();
  formData.append("id", props.spasid.spas_id);

  axios.post("/read.php?historyRecID", formData).then((response) => {
    rows.value = response.data;
  });

  axios.post("/read.php?viewCourseID", formData).then((response) => {
    sy.value = response.data.sy_start;
    term.value = response.data.term_start;
    school.value = response.data.school;
    course.value = response.data.course;
    create.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;
    created_at.value = response.data.created_at;
    updated_at.value = response.data.updated_at;
  });

  axios.post("/read.php?readTermRec", formData).then((response) => {
    termRecOptions.value = response.data;

    if (!termRecOptions.value.includes(preTermRec)) {
      termRecOptions.value.unshift(preTermRec);
    }
  });

  axios.post("/read.php?readAddSC", formData).then((response) => {
    scrTermoptions.value = response.data;
  });

  axios.get("/read.php?readstat2").then((response) => {
    stat2options2 = response.data;
  });

  axios.get("/read.php?readstat1").then((response) => {
    stat1options2 = response.data;
  });

  axios.get("/read.php?school_years").then((response) => {
    syOptions2 = response.data;
  });
};

// Select Status

// Select Monitoring Status

const filterstat2 = (val, update) => {
  if (val === "") {
    update(() => {
      stat2options.value = stat2options2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    stat2options.value = stat2options2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Select Term

const filterstat1 = (val, update) => {
  if (val === "") {
    update(() => {
      stat1options.value = stat1options2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    stat1options.value = stat1options2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// School Year Filters

const filtersy = (val, update) => {
  if (val === "") {
    update(() => {
      syOptions.value = syOptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    syOptions.value = syOptions2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Read School/Course

const openSC = () => {
  viewcourse.value = !viewcourse.value;
  pstart.value = false;
  standstart.value = false;
  pend.value = false;
  standend.value = false;
};

// Prgress Status Start

const openpstart = (props) => {
  if (!props || !props.row) {
    console.error("Props or props.row is missing");
    return;
  }

  pstart.value = !pstart.value;
  viewcourse.value = false;
  standstart.value = false;
  pend.value = false;
  standend.value = false;

  const formData = new FormData();
  formData.append("id", globalSPAS);
  formData.append("termstanding", props.row.term);
  formData.append("progress", props.row.pstart);

  axios
    .post("/read.php?viewStartStatID", formData)
    .then((response) => {
      pstartSy.value = response.data.sy;
      pstartTerm.value = response.data.name;
      pstartSE.value = response.data.start_end;
      pstartProgress.value = response.data.progress_status;
      pstartCreate.value = response.data.created_by;
      pstartUpdate.value = response.data.updated_by;
      pstartVerified.value = response.data.verified_by;
      pstartCreated_at.value = response.data.created_at;
      pstartUpdated_at.value = response.data.updated_at;
    })
    .catch((error) => {
      console.error("Error during axios request:", error);
    });
};

// Start of Term Standing

const opensstanding = (props) => {
  if (!props || !props.row) {
    console.error("Props or props.row is missing");
    return;
  }
  standstart.value = !standstart.value;
  viewcourse.value = false;
  pstart.value = false;
  pend.value = false;
  standend.value = false;

  const formData = new FormData();
  formData.append("id", globalSPAS);
  formData.append("progress", props.row.sstanding);

  axios
    .post("/read.php?viewSTRTStandID", formData)
    .then((response) => {
      console.log(response.data);
      startTermsy.value = response.data.sy;
      startTermterm.value = response.data.name;
      startTermStrEnd.value = response.data.start_end;
      startTermStand.value = response.data.standing;
      startTermMonitor.value = response.data.list_name;
      startTermCreated.value = response.data.created_by;
      startTermUpdate.value = response.data.updated_by;
      startTermVerified_by.value = response.data.verified_by;
      startTermCreated_at.value = response.data.created_at;
      startTermUpdated_at.value = response.data.updated_at;
    })
    .catch((error) => {
      console.error("Error during axios request:", error);
    });
};

const openpend = (props) => {
  if (!props || !props.row) {
    console.error("Props or props.row is missing");
    return;
  }
  pend.value = !pend.value;
  viewcourse.value = false;
  pstart.value = false;
  standstart.value = false;
  standend.value = false;

  const formData = new FormData();
  formData.append("id", globalSPAS);
  formData.append("termstanding", props.row.term);
  formData.append("progress", props.row.pend);

  axios
    .post("/read.php?viewEndID", formData)
    .then((response) => {
      pendSy.value = response.data.sy;
      pendTerm.value = response.data.name;
      pendSE.value = response.data.start_end;
      pendProgress.value = response.data.progress_status;
      pendCreate.value = response.data.created_by;
      pendUpdate.value = response.data.updated_by;
      pendVerified.value = response.data.verified_by;
      pendCreated_at.value = response.data.created_at;
      pendUpdated_at.value = response.data.updated_at;
    })
    .catch((error) => {
      console.error("Error during axios request:", error);
    });
};

const opensend = (props) => {
  if (!props || !props.row) {
    console.error("Props or props.row is missing");
    return;
  }
  standend.value = !standend.value;
  viewcourse.value = false;
  pstart.value = false;
  standstart.value = false;
  pend.value = false;

  const formData = new FormData();
  formData.append("id", globalSPAS);
  formData.append("progress", props.row.send);
  axios
    .post("/read.php?viewENDStandID", formData)
    .then((response) => {
      endTermsy.value = response.data.sy;
      endTermterm.value = response.data.name;
      endTermStrEnd.value = response.data.start_end;
      endTermStand.value = response.data.standing;
      endTermMonitor.value = response.data.list_name;
      endTermCreated.value = response.data.created_by;
      endTermUpdate.value = response.data.updated_by;
      endTermVerified_by.value = response.data.verified_by;
      endTermCreated_at.value = response.data.created_at;
      endTermUpdated_at.value = response.data.updated_at;
    })
    .catch((error) => {
      console.error("Error during axios request:", error);
    });
};

const addStatus = () => {
  openStatus.value = true;
};

const addSC = () => {
  openAddSC.value = true;
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}

.pointer-class {
  cursor: pointer; /* Changes the cursor to a pointer (hand) */
}
</style>
