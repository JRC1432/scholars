<template>
  <div class="q-pa-sm">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <q-banner dense class="rounded-borders-10 glass" v-if="verif === 1">
        <template v-slot:avatar>
          <q-icon name="verified" color="teal" />
        </template>
        <text class="text-h6">Verified Grades</text>
      </q-banner>
      <q-banner dense class="rounded-borders-10 glass2" v-else>
        <template v-slot:avatar>
          <q-icon name="warning" color="orange" />
        </template>
        <text class="text-h6 text-center">Unverified Grades</text>
      </q-banner>
    </q-card>
  </div>

  <q-card flat class="my-card surface-container rounded-borders-20">
    <q-card-section>
      <q-page class="q-pa-md">
        <q-card class="q-pa-md rounded-borders-20 banner-5">
          <q-card-section>
            <div class="col-12">
              <div class="q-col-gutter-md row items-start">
                <div class="col-xs-12 col-sm-3 col-md-6">
                  <div class="text-h6">SY: {{ sy }}, {{ sem }}</div>
                  <div class="text-h6">School: {{ school }}</div>
                  <div class="text-h6">Course: {{ course }}</div>
                  <div>
                    <span class="text-h6">Term Required: </span>

                    <q-btn-toggle
                      v-model="termreq"
                      class="my-custom-toggle"
                      no-caps
                      rounded
                      push
                      toggle-color="primary"
                      color="white"
                      size="sm"
                      text-color="primary"
                      :options="[
                        { label: 'YES', value: 'YES' },
                        { label: 'NO', value: 'NO' },
                      ]"
                      @update:model-value="handleTermChange"
                    />

                    <div class="q-pa-sm q-gutter-sm">
                      <q-btn
                        v-if="verif === 0 || verif === null"
                        color="positive"
                        label="Verify Grades"
                        icon="verified"
                        @click="verifyBtn"
                        rounded
                      />
                      <q-btn
                        v-else
                        color="negative"
                        label="Disallow Grades"
                        icon="cancel"
                        rounded
                        @click="disAllowBtn"
                      />

                      <q-btn
                        color="warning"
                        label="Print"
                        icon="print"
                        rounded
                        @click="printGrades"
                      />
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-6">
                  <div class="float-right">
                    <div>
                      <span class="text-bold primary-text">Latest?</span>
                      <q-toggle
                        v-model="toggle"
                        @update:model-value="handleToggle"
                      />
                    </div>
                  </div>

                  <div class="text-h6">
                    Registration Form Verified by: {{ regVerified }}
                  </div>
                  <div class="text-h6">
                    Grades Verified by: {{ gradeVerified }}
                  </div>
                  <div class="text-h6">
                    Status (Start of Term):

                    <q-btn
                      rounded
                      flat
                      color="blue"
                      @click="startTermStat1"
                      :disable="!pStartBtn"
                    >
                      <template v-if="pStartBtn">
                        {{ pStartBtn }}
                      </template>
                      <template v-else> N/A </template>
                    </q-btn>
                    -
                    <q-btn
                      rounded
                      flat
                      color="blue"
                      @click="startTermStat2"
                      :disable="!sStartBtn"
                    >
                      <template v-if="sStartBtn">
                        {{ sStartBtn }}
                      </template>
                      <template v-else> N/A </template>
                    </q-btn>
                  </div>
                  <div class="text-h6">
                    Status (End of Term):

                    <q-btn
                      rounded
                      flat
                      color="blue"
                      @click="endTermStat1"
                      v-if="pEndtBtn"
                    >
                      {{ pEndtBtn }}
                    </q-btn>
                    <q-btn
                      rounded
                      flat
                      color="red-4"
                      @click="newEndTermStat1"
                      v-else
                    >
                      SELEC STATUS
                    </q-btn>

                    -
                    <q-btn
                      rounded
                      flat
                      color="blue"
                      @click="endTermStat2"
                      v-if="sEndBtn"
                    >
                      {{ sEndBtn }}
                    </q-btn>
                    <q-btn
                      rounded
                      flat
                      color="red-4"
                      @click="newEndTermStat2"
                      v-else
                    >
                      SELECT STATUS
                    </q-btn>
                  </div>
                </div>
              </div>
            </div>
          </q-card-section>

          <q-separator inset />

          <q-card-section>
            <q-form id="addSubject" @submit.prevent="addTodo">
              <div class="col-12">
                <div class="q-col-gutter-md row items-start">
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">SUBJECT CODE:</span>
                    <q-input
                      v-model="scode"
                      name="scode"
                      filled
                      :rules="inputRules"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">ACADEMIC:</span>
                    <q-checkbox
                      v-model="academic"
                      label="Include in computation?"
                      filled
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">UNITS:</span>
                    <q-input
                      v-model="units"
                      name="units"
                      filled
                      :rules="inputRules"
                      mask="##.##"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">GRADE:</span>
                    <q-input
                      v-model="grade"
                      name="grade"
                      filled
                      :rules="inputRules"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">COMPLETION:</span>
                    <q-input
                      v-model="completion"
                      name="completion"
                      filled
                      :rules="inputRules"
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-2">
                    <span class="text-bold primary-text">REMARKS:</span>
                    <q-input
                      v-model="remarks"
                      name="remarks"
                      filled
                      :rules="inputRules"
                    />
                  </div>
                </div>
              </div>
              <q-btn
                type="submit"
                label="Add Subject"
                color="primary"
                class="q-mt-md"
                rounded
              />
            </q-form>
          </q-card-section>

          <q-card-section>
            <q-table
              :rows="todos"
              :columns="columns"
              row-key="id"
              flat
              bordered
              separator="cell"
              class="banner-5"
            >
              <template v-slot:body-cell-scode="props">
                <q-td :props="props">
                  <q-input v-model="props.row.scode" />
                </q-td>
              </template>

              <template v-slot:body-cell-academic="props">
                <q-td :props="props">
                  <q-checkbox v-model="props.row.academic" />
                </q-td>
              </template>

              <template v-slot:body-cell-units="props">
                <q-td :props="props">
                  <q-input v-model="props.row.units" mask="##.##" />
                </q-td>
              </template>

              <template v-slot:body-cell-grade="props">
                <q-td :props="props">
                  <q-input v-model="props.row.grade" />
                </q-td>
              </template>

              <template v-slot:body-cell-completion="props">
                <q-td :props="props">
                  <q-input v-model="props.row.completion" />
                </q-td>
              </template>

              <template v-slot:body-cell-remarks="props">
                <q-td :props="props">
                  <q-input v-model="props.row.remarks" />
                </q-td>
              </template>

              <template v-slot:body-cell-action="props">
                <q-td :props="props">
                  <q-btn
                    flat
                    icon="delete"
                    color="negative"
                    @click="removeTodo(props.row.id, props.row.subject_id)"
                  />
                </q-td>
              </template>
            </q-table>

            <div class="q-pa-md">
              <div class="col-12">
                <div class="q-col-gutter-md row items-start">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <q-input
                      filled
                      v-model="computedTotalUnits"
                      label="Total Units:"
                      readonly
                    />
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <q-input
                      filled
                      v-model="computedGwa"
                      label="General Weighted Average:"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
          </q-card-section>
          <q-card-actions align="around">
            <q-btn rounded style="width: 40%" color="primary" @click="saveBtn"
              >SAVE</q-btn
            >
            <q-btn
              rounded
              style="width: 40%"
              color="warning"
              @click="resetTodos"
            >
              RESET
            </q-btn>
          </q-card-actions>
        </q-card>
      </q-page>
    </q-card-section>
  </q-card>

  <!-- Progress Status Start Dialogs -->

  <q-dialog v-model="pstart">
    <q-card class="my-q-card rounded-borders-20" flat bordered>
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
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{ pstartSy }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Term:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold" v-if="pstartTerm === 1"
                  >1st Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="pstartTerm === 2"
                  >2nd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="pstartTerm === 3"
                  >3rd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="pstartTerm === 4"
                  >4th Term</text
                >
                <text class="on-surface-text text-bold" v-else>5th Term</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Start/End:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>

              <td v-else>
                <text v-if="pstartSE === 1" class="on-surface-text text-bold"
                  >START</text
                >

                <text v-else class="on-surface-text text-bold">END</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Progress Status:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  class="on-surface-text text-bold"
                  v-if="pstartLatest === true"
                  >{{ pstartProgress }}
                  <q-badge align="top">Latest</q-badge>
                </text>
                <text class="on-surface-text text-bold" v-else
                  >{{ pstartProgress }}
                  <q-badge align="top"></q-badge>
                </text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pstartCreate
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pstartUpdate
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Verified By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pstartVerified
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pstartCreated_at
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pstartUpdated_at
                }}</text>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
      <q-card-actions align="center">
        <div class="q-pa-md q-gutter-sm">
          <q-btn
            v-if="pstartVerified_flag === true"
            outline
            style="color: goldenrod"
            label="Disallow"
            @click="disPStart"
          />
          <q-btn
            v-else
            outline
            style="color: goldenrod"
            label="Verify"
            @click="verifyPStart"
          />

          <q-btn
            outline
            style="color: goldenrod"
            label="Update"
            @click="editPSsart"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Delete"
            @click="delPStart"
          />
        </div>
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- Edit Progress Status (Start) -->

  <q-dialog v-model="editModalPSStart" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">EDIT</span>
          Progress Status (START)
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>
      <form id="updatePSstartForm" @submit.prevent.stop="updatePSstart">
        <q-card-section>
          <div class="q-px-sm text-bold">
            <span class="text-bold">School Year</span>
            <q-input outlined dense v-model="state.psSY" name="psSY" readonly />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.psTerm"
              name="psTerm"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Start/End</span>
            <q-input
              outlined
              dense
              v-model="state.psStartEnd"
              name="psStartEnd"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is latest?</span>
            <q-toggle
              :label="PSstatLatest"
              v-model="PSstatLatest"
              name="PSstatLatest"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Progress Status</span>

            <q-select
              ref="refpsProgressStats"
              outlined
              dense
              hide-bottom-space
              emit-value
              map-options
              use-input
              input-debounce="0"
              :options="stat1options"
              @filter="filterstat1"
              v-model="state.psProgressStats"
              name="psProgressStats"
              clearable
              :rules="[myRule]"
            />
          </div>
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <q-dialog v-model="standstart">
    <q-card class="my-q-card rounded-borders-20" flat bordered>
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
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{ startTermsy }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Term:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  class="on-surface-text text-bold"
                  v-if="startTermterm === 1"
                  >1st Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="startTermterm === 2"
                  >2nd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="startTermterm === 3"
                  >3rd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="startTermterm === 4"
                  >4th Term</text
                >
                <text class="on-surface-text text-bold" v-else>5th Term</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Start/End:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  v-if="startTermStrEnd === 1"
                  class="on-surface-text text-bold"
                  >START</text
                >
                <text v-else class="on-surface-text text-bold">END</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Standing:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  class="on-surface-text text-bold"
                  v-if="startTermLatest === true"
                  >{{ startTermStand }}
                  <q-badge align="top">Latest</q-badge>
                </text>
                <text class="on-surface-text text-bold" v-else
                  >{{ startTermStand }} <q-badge align="top"></q-badge
                ></text>
              </td>
            </tr>
            <!-- <tr>
              <td class="primary-text text-bold">Monitoring Status:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  startTermMonitor
                }}</text>
              </td>
            </tr> -->
            <tr>
              <td class="primary-text text-bold">Created By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  startTermCreated
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  startTermUpdate
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Verified By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  startTermVerified_by
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  startTermCreated_at
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  startTermUpdated_at
                }}</text>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
      <q-card-actions align="center">
        <div class="q-pa-md q-gutter-sm">
          <q-btn
            v-if="startTermVerified_flag === true"
            outline
            style="color: goldenrod"
            label="Disallow"
            @click="disStartTerm"
          />
          <q-btn
            v-else
            outline
            style="color: goldenrod"
            label="Verify"
            @click="verifyStartTerm"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Update"
            @click="editStartTerm"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Delete"
            @click="delStartTerm"
          />
        </div>
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- Edit Start of Term Standing  -->

  <q-dialog v-model="editModalStartTerm" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">EDIT</span>
          Start of Term Standing
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>
      <form id="updateStartTermForm" @submit.prevent.stop="updateStartTerm">
        <q-card-section>
          <div class="q-px-sm text-bold">
            <span class="text-bold">School Year</span>
            <q-input
              outlined
              dense
              v-model="state.startUPTermSY"
              name="startUPTermSY"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.startUPTerm"
              name="startUPTerm"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Start/End</span>
            <q-input
              outlined
              dense
              v-model="state.startUPStartEnd"
              name="startUPStartEnd"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is latest?</span>
            <q-toggle
              :label="startTermStatLatest"
              v-model="startTermStatLatest"
              name="startTermStatLatest"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Standing</span>
            <q-select
              ref="refstartTermProgressStat"
              :options="endTermProgressStatOptions"
              v-model="state.startTermProgressStat"
              name="startTermProgressStat"
              emit-value
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <!-- <div class="q-px-sm text-bold">
            <span class="text-bold">Monitoring Status</span>

            <q-select
              ref="refendTermMonitor"
              v-model="state.startTermMonitorStats"
              name="startTermMonitorStats"
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
          </div> -->
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <q-dialog v-model="editPSend">
    <q-card class="my-q-card rounded-borders-20" flat bordered>
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
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{ pendSy }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Term:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold" v-if="pendTerm === 1"
                  >1st Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="pendTerm === 2"
                  >2nd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="pendTerm === 3"
                  >3rd term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="pendTerm === 4"
                  >4th Term</text
                >
                <text class="on-surface-text text-bold" v-else>5th Term</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Start/End:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text v-if="pendSE === 2" class="on-surface-text text-bold"
                  >END</text
                >
                <text v-else class="on-surface-text text-bold">START</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Progress Status:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  class="on-surface-text text-bold"
                  v-if="pendLatest === true"
                  >{{ pendProgress }}
                  <q-badge align="top">Latest</q-badge></text
                >
                <text class="on-surface-text text-bold" v-else
                  >{{ pendProgress }} <q-badge align="top"></q-badge
                ></text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{ pendCreate }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{ pendUpdate }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Verified By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pendVerified
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pendCreated_at
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  pendUpdated_at
                }}</text>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
      <q-card-actions align="center">
        <div class="q-pa-md q-gutter-sm">
          <q-btn
            v-if="pendVerified_flag === true"
            outline
            style="color: goldenrod"
            label="Disallow"
            @click="disPSEnd"
          />
          <q-btn
            v-else
            outline
            style="color: goldenrod"
            label="Verify"
            @click="verifyPSEnd"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Update"
            @click="editPSEnd"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Delete"
            @click="delPSEnd"
          />
        </div>
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- Edit Progress Status (End) -->

  <q-dialog v-model="editModalPSEnd" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">EDIT</span>
          Progress Status (END)
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <form id="updatePSendForm" @submit.prevent.stop="updatePSend">
        <q-card-section>
          <div class="q-px-sm text-bold">
            <span class="text-bold">School Year</span>
            <q-input outlined dense v-model="state.peSY" name="peSY" readonly />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.peTerm"
              name="peTerm"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Start/End</span>
            <q-input
              outlined
              dense
              v-model="state.peStartEnd"
              name="peStartEnd"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is latest?</span>
            <q-toggle
              :label="PEstatLatest"
              v-model="PEstatLatest"
              name="PEstatLatest"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Progress Status</span>

            <q-select
              ref="refpeProgressStats"
              outlined
              dense
              hide-bottom-space
              emit-value
              map-options
              use-input
              input-debounce="0"
              :options="stat1options"
              @filter="filterstat1"
              v-model="state.peProgressStats"
              name="peProgressStats"
              clearable
              :rules="[myRule]"
            />
          </div>
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card> </q-dialog
  >.

  <!-- End of Term Standing -->

  <q-dialog v-model="editModalEndTermStanding">
    <q-card class="my-q-card rounded-borders-20" flat bordered>
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

              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{ endTermsy }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Term:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold" v-if="endTermterm === 1"
                  >1st Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="endTermterm === 2"
                  >2nd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="endTermterm === 3"
                  >3rd Term</text
                >
                <text
                  class="on-surface-text text-bold"
                  v-else-if="endTermterm === 4"
                  >4th Term</text
                >
                <text class="on-surface-text text-bold" v-else> 5th Term </text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Start/End:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  v-if="endTermStrEnd === 2"
                  class="on-surface-text text-bold"
                  >END</text
                >
                <text v-else class="on-surface-text text-bold">START</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Standing:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text
                  class="on-surface-text text-bold"
                  v-if="endTermLatest === true"
                  >{{ endTermStand }}
                  <q-badge align="top">Latest</q-badge></text
                >
                <text class="on-surface-text text-bold" v-else
                  >{{ endTermStand }} <q-badge align="top"></q-badge
                ></text>
              </td>
            </tr>
            <!-- <tr>
              <td class="primary-text text-bold">Monitoring Status:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  endTermMonitor
                }}</text>
              </td>
            </tr> -->
            <tr>
              <td class="primary-text text-bold">Created By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  endTermCreated
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  endTermUpdate
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Verified By:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  endTermVerified_by
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  endTermCreated_at
                }}</text>
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated At:</td>
              <td v-if="loading">
                <q-skeleton animation="blink" type="text" width="300px" />
              </td>
              <td v-else>
                <text class="on-surface-text text-bold">{{
                  endTermUpdated_at
                }}</text>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
      <q-card-actions align="center">
        <div class="q-pa-md q-gutter-sm">
          <q-btn
            v-if="endTermVerified_flag === true"
            outline
            style="color: goldenrod"
            label="Disallow"
            @click="disEndTerm"
          />
          <q-btn
            v-else
            outline
            style="color: goldenrod"
            label="Verify"
            @click="verifyEndTerm"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Update"
            @click="editEndTerm"
          />
          <q-btn
            outline
            style="color: goldenrod"
            label="Delete"
            @click="delEndTerm"
          />
        </div>
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- Edit End of Term Standing  -->

  <q-dialog v-model="editModalEndTerm" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">EDIT</span>
          End of Term Standing
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>
      <form id="updateEndTermForm" @submit.prevent.stop="updateEndTerm">
        <q-card-section>
          <div class="q-px-sm text-bold">
            <span class="text-bold">School Year</span>
            <q-input
              outlined
              dense
              v-model="state.endTermSYear"
              name="endTermSY"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.endTermterms"
              name="endTermterm"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Start/End</span>
            <q-input
              outlined
              dense
              v-model="state.endTermStartEnd"
              name="endTermStartEnd"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is latest?</span>
            <q-toggle
              :label="endTermStatLatest"
              v-model="endTermStatLatest"
              name="endTermStatLatest"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Standing</span>
            <q-select
              ref="refendTermProgressStat"
              :options="endTermProgressStatOptions"
              v-model="state.endTermProgressStat"
              name="endTermProgressStat"
              emit-value
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <!-- <div class="q-px-sm text-bold">
            <span class="text-bold">Monitoring Status</span>

            <q-select
              ref="refendTermMonitor"
              v-model="state.endTermMonitorStats"
              name="endTermMonitorStats"
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
          </div> -->
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <!-- Select Status 1 -->

  <q-dialog v-model="endTermStatus1">
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconProgress :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">END</span>
          Progress Status
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>
      <form id="createProgressEndForm" @submit.prevent.stop="createProgressEnd">
        <q-card-section>
          <div class="q-px-sm text-bold">
            <span class="text-bold">School Year</span>
            <q-input
              outlined
              dense
              v-model="state.endPSsy"
              name="endPSsy"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.endPSterm"
              name="endPSterm"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Start/End</span>
            <q-input
              outlined
              dense
              v-model="state.endPStartEnd"
              name="endPStartEnd"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is latest?</span>
            <q-toggle
              :label="endPSstatLatest"
              v-model="endPSstatLatest"
              name="endPSstatLatest"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Progress Status</span>

            <q-select
              ref="refendProgressStats"
              outlined
              dense
              hide-bottom-space
              emit-value
              map-options
              use-input
              input-debounce="0"
              :options="stat1options"
              @filter="filterstat1"
              v-model="state.endProgressStats"
              name="endProgressStats"
              clearable
              :rules="[myRule]"
            />
          </div>
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <!-- Select Status 2 -->

  <q-dialog v-model="endTermStatus2">
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconProgress :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">END</span>
          Term Standing
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>
      <form id="createEndTermForm" @submit.prevent.stop="createEndTerm">
        <q-card-section>
          <div class="q-px-sm text-bold">
            <span class="text-bold">School Year</span>
            <q-input
              outlined
              dense
              v-model="state.endTermScholyear"
              name="endTermScholyear"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.endTermstate"
              name="endTermstate"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Start/End</span>
            <q-input
              outlined
              dense
              v-model="state.endStartEnd"
              name="endStartEnd"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is latest?</span>
            <q-toggle
              :label="endTermStatLatestToggle"
              v-model="endTermStatLatestToggle"
              name="endTermStatLatestToggle"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Standing</span>
            <q-select
              ref="refendTermStandingSelect"
              :options="endTermProgressStatOptions"
              v-model="state.endTermStandingSelect"
              name="endTermStandingSelect"
              emit-value
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <!-- <div class="q-px-sm text-bold">
            <span class="text-bold">Monitoring Status</span>

            <q-select
              ref="refendTermMonitor"
              v-model="state.startTermMonitorStats"
              name="startTermMonitorStats"
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
          </div> -->
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="Save"
              type="submit"
            />
            <q-btn outline style="color: goldenrod" label="Reset" />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>
</template>

<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, reactive, computed, onMounted, inject, watchEffect } from "vue";
import router from "../router";
import { uid } from "quasar";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import {
  IconCertificate,
  IconProgress,
  IconCircleDashedCheck,
  IconChecks,
  IconBackpack,
  IconEdit,
  IconRefresh,
  IconTrendingUp,
} from "@tabler/icons-vue";

import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");
const route = useRoute();

// Rules & Validations
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
];

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

// Dialog Teriggers

const pstart = ref(false);
const standstart = ref(false);
const editModalPSStart = ref(false);
const editModalStartTerm = ref(false);
const editModalPSEnd = ref(false);
const editModalEndTermStanding = ref(false);
const editPSend = ref(false);
const editModalEndTerm = ref(false);
const endTermStatus1 = ref(false);
const endTermStatus2 = ref(false);
const PSstatLatest = ref("NO");
const startTermStatLatest = ref("NO");
const PEstatLatest = ref("NO");
const endTermStatLatest = ref("NO");
const endPSstatLatest = ref("NO");
const endTermStatLatestToggle = ref("NO");

// Variables

// View progress Status

const pstartSy = ref();
const pstartTerm = ref();
const pstartSE = ref();
const pstartProgress = ref();
const pstartLatest = ref();
const pstartCreate = ref();
const pstartUpdate = ref();
const pstartVerified = ref();
const pstartCreated_at = ref();
const pstartUpdated_at = ref();
const pstartVerified_flag = ref();
const pStartBtn = ref();

// View Start of Term Standing

// View Start Term Standing

const startTermsy = ref();
const startTermterm = ref();
const startTermStrEnd = ref();
const startTermStand = ref();
const startTermLatest = ref();
const startTermCreated = ref();
const startTermUpdate = ref();
const startTermVerified_by = ref();
const startTermCreated_at = ref();
const startTermUpdated_at = ref();
const startTermVerified_flag = ref();
const sStartBtn = ref();

const endTermProgressStatOptions = ref();

// View progress End

const pendSy = ref();
const pendTerm = ref();
const pendSE = ref();
const pendProgress = ref();
const pendLatest = ref();
const pendCreate = ref();
const pendUpdate = ref();
const pendVerified = ref();
const pendCreated_at = ref();
const pendUpdated_at = ref();
const pendVerified_flag = ref();
const pEndtBtn = ref();

// View End of Term Standing

const endTermsy = ref();
const endTermterm = ref();
const endTermStrEnd = ref();
const endTermStand = ref();
const endTermLatest = ref();
const endTermCreated = ref();
const endTermUpdate = ref();
const endTermVerified_by = ref();
const endTermCreated_at = ref();
const endTermUpdated_at = ref();
const endTermVerified_flag = ref();

const sEndBtn = ref();

// Reference

const refpsProgressStats = ref(null);
const refstartTermProgressStat = ref(null);
const refpeProgressStats = ref(null);
const refendTermProgressStat = ref(null);
const refendTermStandingSelect = ref(null);

// Other Variables

const global_Termid = route.params.id;
const sy = ref("");
const sem = ref("");
const school = ref("");
const course = ref("");
const termreq = ref("");
const regVerified = ref("");
const gradeVerified = ref("");
const statStart = ref("");
const statEnd = ref("");
const verif = ref();
const toggle = ref();
const course_id = ref();

const scode = ref("");
const academic = ref(false);
const units = ref("");
const grade = ref("");
const completion = ref("");
const remarks = ref("");

const state = reactive({
  term: "",
  stat1: "",
  stat2: "",

  psSY: "",
  psTerm: "",
  psStartEnd: "",
  psProgressStats: "",

  startUPTermSY: "",
  startUPTerm: "",
  startUPStartEnd: "",
  startTermStatLatest: "",
  startTermProgressStat: "",

  peSY: "",
  peTerm: "",
  peStartEnd: "",
  peProgressStats: "",

  endTermSYear: "",
  endTermterms: "",
  endTermStartEnd: "",
  endTermProgressStat: "",

  endPSsy: "",
  endPSterm: "",
  endPStartEnd: "2",
  endProgressStats: "",

  endTermScholyear: "",
  endTermstate: "",
  endStartEnd: "2",
  endTermStandingSelect: "",
});

const todos = ref([
  {
    id: uid(),
    subject_id: "",
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
  {
    id: uid(),
    subject_id: "",
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
  {
    id: uid(),
    subject_id: "",
    scode: "",
    academic: false,
    units: "",
    grade: "",
    completion: "",
    remarks: "",
  },
]);

const addTodo = () => {
  if (
    scode.value &&
    units.value &&
    grade.value &&
    completion.value &&
    remarks.value
  ) {
    todos.value.push({
      id: uid(),
      scode: scode.value,
      academic: academic.value,
      units: parseFloat(units.value),
      grade: grade.value,
      completion: completion.value,
      remarks: remarks.value,
    });

    var formData = new FormData(document.getElementById("addSubject"));

    formData.append("termid", global_Termid);
    formData.append("user", user.username);
    formData.append("academic", academic.value);

    axios.post("/create.php?createSubject", formData).then(function (response) {
      if (response.data == true) {
        populateEditGrades();
        scode.value = "";
        academic.value = false;
        units.value = "";
        grade.value = "";
        completion.value = "";
        remarks.value = "";
        $q.notify({
          type: "positive",
          message: "Grade Added Successfully",
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to add subject",
        });
      }
    });
  }
};

const removeTodo = (id, subject_id) => {
  var formData = new FormData();
  formData.append("subjectid", subject_id);
  const index = todos.value.findIndex((todo) => todo.id === id);

  if (index !== -1) {
    console.log(subject_id); // Log subject_id
    todos.value.splice(index, 1);

    axios.post("/delete.php?delGrades", formData).then(function (response) {
      if (response.data == true) {
        populateEditGrades();
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Subject Deleted",
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to removed Grade",
        });
      }
    });
  }
};

const resetTodos = () => {
  todos.value = [
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
    {
      id: uid(),
      scode: "",
      academic: false,
      units: "",
      grade: "",
      completion: "",
      remarks: "",
    },
  ];
};

const columns = [
  { name: "scode", label: "Subject Code", field: "scode", align: "left" },
  { name: "academic", label: "Academic", field: "academic", align: "center" },
  { name: "units", label: "Units", field: "units", align: "left" },
  { name: "grade", label: "Grade", field: "grade", align: "left" },
  {
    name: "completion",
    label: "Completion",
    field: "completion",
    align: "left",
  },
  { name: "remarks", label: "Remarks", field: "remarks", align: "left" },
  { name: "action", label: "Action", field: "action", align: "center" },
];

// Total Grades Computation

const computedTotalUnits = computed(() => {
  // Calculate total units for subjects where academic is checked and grades are valid
  return todos.value
    .filter((todo) => todo.academic && !isNaN(parseFloat(todo.grade))) // Only count academic subjects with valid grades
    .reduce((total, todo) => total + parseFloat(todo.units), 0);
});

const computedGwa = computed(() => {
  const validSubjects = todos.value.filter(
    (todo) => todo.academic && !isNaN(parseFloat(todo.grade)) // Only count academic subjects with valid grades
  );

  const totalUnits = validSubjects.reduce(
    (total, todo) => total + parseFloat(todo.units),
    0
  );

  const totalWeightedGrades = validSubjects.reduce((total, todo) => {
    return total + parseFloat(todo.grade) * parseFloat(todo.units);
  }, 0);

  return totalUnits > 0 ? (totalWeightedGrades / totalUnits).toFixed(2) : 0;
});

// Grades Info

var stat2options2 = [];
const stat2options = ref(stat2options2);
var stat1options2 = [];
const stat1options = ref(stat1options2);

const data = ref();
const id = ref();
onMounted(() => {
  populateEditGrades();
});

const populateEditGrades = () => {
  var formData = new FormData();
  formData.append("id", global_Termid);
  formData.append("spasid", spasids.value);

  axios.post("/read.php?readEditGrades", formData).then((response) => {
    sy.value = response.data.sy;
    sem.value = response.data.sem;
    school.value = response.data.school;
    course.value = response.data.course;
    termreq.value = response.data.term_required === 1 ? "YES" : "NO";
    regVerified.value = response.data.reg_verified_by;
    gradeVerified.value = response.data.grades_verified_by;
    statStart.value = response.data.pstart;
    statEnd.value = response.data.sstanding;
    toggle.value = response.data.latest_flag == 1 ? true : false;
    verif.value = response.data.grades_verified_flag;
    course_id.value = response.data.id;
  });

  // Progress Status Start

  axios.post("/read.php?viewProgressStat1", formData).then((response) => {
    pStartBtn.value = response.data.progress_status;
  });

  // Start of Term Standing

  axios.post("/read.php?viewStartStat1", formData).then((response) => {
    sStartBtn.value = response.data.standing;
  });

  // Progress Status End

  axios.post("/read.php?viewProgressStat2", formData).then((response) => {
    pEndtBtn.value = response.data.progress_status;
  });

  // End of Term Standing

  axios.post("/read.php?viewStartStat2", formData).then((response) => {
    sEndBtn.value = response.data.standing;
  });

  // Start Term Standing Options

  axios.post("/read.php?standing", formData).then((response) => {
    endTermProgressStatOptions.value = response.data;
  });

  // Reading Gades
  axios.post("/read.php?readGrades", formData).then((response) => {
    data.value = response.data;

    todos.value = data.value.map((grade) => ({
      id: uid(), // Generate a unique id
      subject_id: grade.subj_id || "",
      scode: grade.subj_code || "", // Subject code from response
      academic: grade.academic_type, // Convert "Yes"/"No" to boolean
      units: grade.unit || "", // Units from response
      grade: grade.grade || "", // Grade from response
      completion: grade.completion || "", // Completion from response
      remarks: grade.remarks || "", // Remarks from response
    }));
  });

  axios.get("/read.php?readstat1").then((response) => {
    stat1options2 = response.data;
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

// Export PDF Grades

const printGrades = () => {
  alert("Please click OK to print PDF");

  var formData = new FormData();

  formData.append("id", global_Termid);
  formData.append("grades", JSON.stringify(todos.value));
  formData.append("sy", sy.value);
  formData.append("sem", sem.value);
  formData.append("school", school.value);
  formData.append("course", course.value);
  formData.append("termreq", termreq.value);
  formData.append("regVerified", regVerified.value);
  formData.append("gradeVerified", gradeVerified.value);
  formData.append("statStart", pStartBtn.value);
  formData.append("statEnd", sStartBtn.value);
  formData.append("stat1", pEndtBtn.value);
  formData.append("stat2", sEndBtn.value);

  formData.append("computedTotalUnits", computedTotalUnits.value);
  formData.append("computedGwa", computedGwa.value);

  axios
    .post("/create.php?printGradesPDF", formData, { responseType: "blob" })
    .then(function (response) {
      var file = new Blob([response.data], { type: "application/pdf" });
      var fileURL = URL.createObjectURL(file);
      window.open(fileURL);
    });
};

const verifyBtn = () => {
  var formData = new FormData();

  formData.append("termid", global_Termid);
  formData.append("user", user.username);

  axios.post("/update.php?verifGrades", formData).then(function (response) {
    if (response.data == true) {
      populateEditGrades();
      Swal.fire({
        icon: "success",
        title: "Verified",
        showConfirmButton: false,
        timer: 1500,
      });
      populateEditGrades();
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "No Changes Made",
      });
    }
  });
};

const disAllowBtn = () => {
  var formData = new FormData();

  formData.append("termid", global_Termid);
  formData.append("user", user.username);

  axios.post("/update.php?disGrades", formData).then(function (response) {
    if (response.data == true) {
      populateEditGrades();
      Swal.fire({
        icon: "error",
        title: "Disalllowed Successfully",
        showConfirmButton: false,
        timer: 1500,
      });
      populateEditGrades();
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "No Changes Made",
      });
    }
  });
};

// Session Storage
const spasids = ref();

const spasItem = sessionStorage.getItem("spasid");

if (spasItem) {
  spasids.value = JSON.parse(spasItem);
}

const saveBtn = () => {
  var formData = new FormData();

  formData.append("termid", global_Termid);
  formData.append("user", user.username);
  formData.append("computedGwa", computedGwa.value);

  todos.value.forEach((todo, index) => {
    formData.append(`todos[${index}][subj_id]`, todo.subject_id);
    formData.append(`todos[${index}][scode]`, todo.scode);
    formData.append(`todos[${index}][academic]`, todo.academic ? 1 : 0);
    formData.append(`todos[${index}][units]`, todo.units);
    formData.append(`todos[${index}][grade]`, todo.grade);
    formData.append(`todos[${index}][completion]`, todo.completion);
    formData.append(`todos[${index}][remarks]`, todo.remarks);
  });

  Swal.fire({
    title: "Do you want to save the changes?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Save",
    denyButtonText: `Don't save`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      axios
        .post("/update.php?updateGrades", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire("Saved!", "", "success");
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Grades not Updated",
            });
          }
        });
      axios
        .post("/update.php?updateGWAGrades", formData)
        .then(function (response) {
          if (response.data == true) {
            $q.notify({
              type: "positive",
              message: "Grades and Term Record has been updated.",
              position: "top-right",
            });
            populateEditGrades();
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "No Changes Made",
            });
          }
        });
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
};
const handleToggle = () => {
  var formData = new FormData();

  formData.append("termid", global_Termid);
  formData.append("user", user.username);

  if (toggle.value === true) {
    axios.post("/update.php?latestGrades", formData).then(function (response) {
      if (response.data == true) {
        $q.notify({
          color: "green",
          textColor: "white",
          message: "Latest grades has been set",
        });
        populateEditGrades();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Error handling the toggle",
        });
      }
    });
  } else {
    axios
      .post("/update.php?falseLatestGrades", formData)
      .then(function (response) {
        if (response.data == true) {
          $q.notify({
            color: "orange",
            textColor: "white",
            message: "Changes has been made",
          });
          populateEditGrades();
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "Error handling the toggle",
          });
        }
      });
  }
};

const handleTermChange = (value) => {
  var formData = new FormData();

  formData.append("termid", global_Termid);
  formData.append("user", user.username);

  if (value === "YES") {
    axios.post("/update.php?termReqYes", formData).then(function (response) {
      if (response.data == true) {
        $q.notify({
          color: "green",
          message: "Term required has been set to YES",
        });
        populateEditGrades();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Term Required handling not work on YES",
        });
      }
    });
  } else if (value === "NO") {
    axios.post("/update.php?termReqNo", formData).then(function (response) {
      if (response.data == true) {
        $q.notify({
          color: "orange",
          message: "Term required has been set to NO",
        });
        populateEditGrades();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Term Required handling not work on NO",
        });
      }
    });
  }
};

// Statuses Trigger buttons

// Progress Status Start

const startTermStat1 = async () => {
  pstart.value = true;

  const formData = new FormData();
  formData.append("id", spasids.value);
  formData.append("termid", global_Termid);

  try {
    const response = await axios.post("/read.php?viewStartStatID", formData);

    pstartSy.value = response.data.sy;
    pstartTerm.value = response.data.term;
    pstartSE.value = response.data.start_end;
    pstartProgress.value = response.data.progress_status;
    pstartLatest.value = response.data.latest_flag;
    pstartCreate.value = response.data.created_by;
    pstartUpdate.value = response.data.updated_by;
    pstartVerified.value = response.data.verified_by;
    pstartCreated_at.value = response.data.created_at;
    pstartUpdated_at.value = response.data.updated_at;
    pstartVerified_flag.value = response.data.verified_flag;

    termid_PStart.value = response.data.term_id;
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// Disallow Progress Status (Start)

const disPStart = () => {
  pstart.value = false;
  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?disProgressStart", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "error",
          title: "Disallowed",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          startTermStat1();
          pstart.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to disallow Progress Status(Start)",
        });
      }
    });
};

// Verify Progress Status (Start)

const verifyPStart = () => {
  pstart.value = false;

  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyProgressStart", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          startTermStat1();
          pstart.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to verify Progress Status(Start)",
        });
      }
    });
};

// Delete Progress Status (Start)

const delPStart = () => {
  pstart.value = false;

  var formData = new FormData();
  formData.append("spasid", spasids.value);
  formData.append("deltermid", global_Termid);

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/delete.php?delProgressStart", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire({
              title: "Deleted!",
              text: "Status has been deleted.",
              icon: "success",
            }).then(() => {
              populateEditGrades();
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to removed Progress Status(Start)",
            });
          }
        });
    }
  });
};

// Edit Progress Status (Start)

const editPSsart = () => {
  pstart.value = false;
  editModalPSStart.value = true;
  state.psSY = pstartSy.value;
  state.psTerm = pstartTerm.value;
  state.psStartEnd = pstartSE.value;
  PSstatLatest.value = pstartLatest.value === true ? "YES" : "NO";
  state.psProgressStats = pstartProgress.value;
};

const updatePSstart = () => {
  refpsProgressStats.value.validate();

  var formData = new FormData(document.getElementById("updatePSstartForm"));
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);
  formData.append("status", PSstatLatest.value);
  formData.append("termid", global_Termid);

  if (refpsProgressStats.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    editModalPSStart.value = false;
    Swal.fire({
      title: "Do you want to save the changes?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Save",
      denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post("/update.php?upProgressStart", formData)
          .then(function (response) {
            if (response.data == true) {
              Swal.fire("Saved!", "", "success").then(() => {
                populateEditGrades();
              });
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to update edit Progress Status(Start)",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

// Start Term Standing

const startTermStat2 = async () => {
  standstart.value = true;

  const formData = new FormData();
  formData.append("id", spasids.value);
  formData.append("termid", global_Termid);

  try {
    const response = await axios.post("/read.php?viewSTRTStandID", formData);

    startTermsy.value = response.data.sy;
    startTermterm.value = response.data.term;
    startTermStrEnd.value = response.data.start_end;
    startTermStand.value = response.data.standing;
    startTermLatest.value = response.data.latest_flag;

    startTermCreated.value = response.data.created_by;
    startTermUpdate.value = response.data.updated_by;
    startTermVerified_by.value = response.data.verified_by;
    startTermCreated_at.value = response.data.created_at;
    startTermUpdated_at.value = response.data.updated_at;
    startTermVerified_flag.value = response.data.verified_flag;

    console.log(startTermVerified_flag.value);
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// Disallow Start Term Standing

const disStartTerm = () => {
  standstart.value = false;
  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?disStartTermStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "error",
          title: "Disallowed",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          startTermStat2();
          standstart.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to disallow Start of Term Standing",
        });
      }
    });
};

// Verify Start of Term Standing

const verifyStartTerm = () => {
  standstart.value = false;
  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyStartTermStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          startTermStat2();
          standstart.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to verify Progress Status(Start)",
        });
      }
    });
};

// Delete Start of Term Standing

const delStartTerm = () => {
  standstart.value = false;
  var formData = new FormData();
  formData.append("spasid", spasids.value);
  formData.append("deltermid", global_Termid);

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/delete.php?delStartTerm", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire({
              title: "Deleted!",
              text: "Status has been deleted.",
              icon: "success",
            }).then(() => {
              populateEditGrades();
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to removed Progress Status(Start)",
            });
          }
        });
    }
  });
};

// Edit Start Term Stnding

const editStartTerm = () => {
  editModalStartTerm.value = true;
  standstart.value = false;
  state.startUPTermSY = startTermsy.value;
  state.startUPTerm = startTermterm.value;
  state.startUPStartEnd = startTermStrEnd.value;
  startTermStatLatest.value = startTermLatest.value === true ? "YES" : "NO";
  state.startTermProgressStat = startTermStand.value;
};

const updateStartTerm = () => {
  refstartTermProgressStat.value.validate();
  var formData = new FormData(document.getElementById("updateStartTermForm"));
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);
  formData.append("status", startTermStatLatest.value);
  formData.append("start_Term_Id", global_Termid);

  if (refstartTermProgressStat.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    editModalStartTerm.value = false;
    Swal.fire({
      title: "Do you want to save the changes?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Save",
      denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post("/update.php?upStartTermStanding", formData)
          .then(function (response) {
            if (response.data == true) {
              Swal.fire("Saved!", "", "success").then(() => {
                populateEditGrades();
              });
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to update Start of Term Standing",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

// Progress Status End

const endTermStat1 = async () => {
  editPSend.value = true;
  const formData = new FormData();
  formData.append("id", spasids.value);

  formData.append("termid", global_Termid);

  try {
    const response = await axios.post("/read.php?viewEndID", formData);

    pendSy.value = response.data.sy;
    pendTerm.value = response.data.term;
    pendSE.value = response.data.start_end;
    pendProgress.value = response.data.progress_status;
    pendLatest.value = response.data.latest_flag;
    pendCreate.value = response.data.created_by;
    pendUpdate.value = response.data.updated_by;
    pendVerified.value = response.data.verified_by;
    pendCreated_at.value = response.data.created_at;
    pendUpdated_at.value = response.data.updated_at;
    pendVerified_flag.value = response.data.verified_flag;
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// Disallow Progress Status End

const disPSEnd = () => {
  editPSend.value = false;
  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios.post("/update.php?disProgressEnd", formData).then(function (response) {
    if (response.data == true) {
      Swal.fire({
        icon: "error",
        title: "Disallowed",
        showConfirmButton: false,
        timer: 1500,
      }).then(() => {
        endTermStat1();
        editPSend.value = true;
      });
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to disallow Progress Status(End)",
      });
    }
  });
};

// Verify Progress Status (End)

const verifyPSEnd = () => {
  editPSend.value = false;

  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyProgressEnd", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          endTermStat1();
          editPSend.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to verify Progress Status(Start)",
        });
      }
    });
};

// Delete Progress Status (End)

const delPSEnd = () => {
  editPSend.value = false;

  var formData = new FormData();
  formData.append("spasid", spasids.value);
  formData.append("deltermid", global_Termid);

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post("/delete.php?delProgressEnd", formData)
        .then(function (response) {
          if (response.data == true) {
            Swal.fire({
              title: "Deleted!",
              text: "Status has been deleted.",
              icon: "success",
            }).then(() => {
              populateEditGrades();
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to removed Progress Status(End)",
            });
          }
        });
    }
  });
};

// Edit Progress Status (End)

const term_ID_Pend = ref();

const editPSEnd = () => {
  editModalPSEnd.value = true;
  editPSend.value = false;
  state.peSY = pendSy.value;
  state.peTerm = pendTerm.value;
  state.peStartEnd = pendSE.value;
  PEstatLatest.value = pendLatest.value === true ? "YES" : "NO";
  state.peProgressStats = pendProgress.value;
};

const updatePSend = () => {
  refpeProgressStats.value.validate();
  var formData = new FormData(document.getElementById("updatePSendForm"));
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);
  formData.append("status", PEstatLatest.value);
  formData.append("term_ID_Pend", global_Termid);

  if (refpeProgressStats.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    editModalPSEnd.value = false;
    Swal.fire({
      title: "Do you want to save the changes?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Save",
      denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post("/update.php?upProgressEnd", formData)
          .then(function (response) {
            if (response.data == true) {
              Swal.fire("Saved!", "", "success").then(() => {
                populateEditGrades();
              });
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to update Progress Status End",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

// End of Term Standing

const endTermStat2 = async () => {
  editModalEndTermStanding.value = true;
  const formData = new FormData();
  formData.append("id", spasids.value);
  formData.append("termid", global_Termid);

  try {
    const response = await axios.post("/read.php?viewENDStandID", formData);

    endTermsy.value = response.data.sy;
    endTermterm.value = response.data.term;
    endTermStrEnd.value = response.data.start_end;
    endTermStand.value = response.data.standing;
    endTermLatest.value = response.data.latest_flag;
    endTermCreated.value = response.data.created_by;
    endTermUpdate.value = response.data.updated_by;
    endTermVerified_by.value = response.data.verified_by;
    endTermCreated_at.value = response.data.created_at;
    endTermUpdated_at.value = response.data.updated_at;
    endTermVerified_flag.value = response.data.verified_flag;
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// Disallow End Term Standing

const disEndTerm = () => {
  editModalEndTermStanding.value = false;
  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?disEndTermStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "error",
          title: "Disallowed",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          endTermStat2();
          editModalEndTermStanding.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to disallow End of Term Standing",
        });
      }
    });
};

// Verify End Of Term Standing

const verifyEndTerm = () => {
  editModalEndTermStanding.value = false;

  var formData = new FormData();
  formData.append("termid", global_Termid);
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyEndTermStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          endTermStat2();
          editModalEndTermStanding.value = true;
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to verify Progress Status(Start)",
        });
      }
    });
};

// Delete End of Term Standing

const delEndTerm = () => {
  editModalEndTermStanding.value = false;
  var formData = new FormData();
  formData.append("spasid", spasids.value);
  formData.append("deltermid", global_Termid);

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.post("/delete.php?delEndTerm", formData).then(function (response) {
        if (response.data == true) {
          Swal.fire({
            title: "Deleted!",
            text: "Status has been deleted.",
            icon: "success",
          }).then(() => {
            populateEditGrades();
          });
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "Failed to removed End of Term Standing",
          });
        }
      });
    }
  });
};

// Edit End Term Stnding

const editEndTerm = () => {
  editModalEndTerm.value = true;
  editModalEndTermStanding.value = false;
  state.endTermSYear = endTermsy.value;
  state.endTermterms = endTermterm.value;
  state.endTermStartEnd = endTermStrEnd.value;
  endTermStatLatest.value = endTermLatest.value === true ? "YES" : "NO";
  state.endTermProgressStat = endTermStand.value;
  // state.endTermMonitorStats = endTermMonitor.value;
};

const updateEndTerm = () => {
  editModalEndTerm.value = false;
  refendTermProgressStat.value.validate();
  var formData = new FormData(document.getElementById("updateEndTermForm"));
  formData.append("spasid", spasids.value);
  formData.append("user", user.username);
  formData.append("status", endTermStatLatest.value);
  formData.append("term_ID_endTerm", global_Termid);

  if (refendTermProgressStat.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    editModalStartTerm.value = false;
    Swal.fire({
      title: "Do you want to save the changes?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Save",
      denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post("/update.php?upEndTermStanding", formData)
          .then(function (response) {
            if (response.data == true) {
              Swal.fire("Saved!", "", "success").then(() => {
                populateEditGrades();
              });
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to update End of Term Standing",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

// Create Statuses

const newEndTermStat1 = () => {
  endTermStatus1.value = true;
  let termstates = global_Termid[global_Termid.length - 2];
  state.endPSsy = sy.value;
  state.endPSterm = termstates;
};

const createProgressEnd = () => {
  endTermStatus1.value = false;
  let termtypes = global_Termid[global_Termid.length - 1];

  var formData = new FormData(document.getElementById("createProgressEndForm"));

  formData.append("spasid", spasids.value);
  formData.append("termid", global_Termid);
  formData.append("termtypes", termtypes);
  formData.append("courseid", course_id.value);
  formData.append("user", user.username);
  formData.append("latest", endPSstatLatest.value);

  axios
    .post("/create.php?createPStatusEnd", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire("Saved!", "", "success").then(() => {
          populateEditGrades();
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to create Progress Status End",
        });
      }
    });
};

const newEndTermStat2 = () => {
  let termstate = global_Termid[global_Termid.length - 2];
  endTermStatus2.value = true;
  state.endTermScholyear = sy.value;
  state.endTermstate = termstate;
};

const createEndTerm = () => {
  endTermStatus2.value = false;
  let termtypes = global_Termid[global_Termid.length - 1];

  var formData = new FormData(document.getElementById("createEndTermForm"));

  formData.append("spasid", spasids.value);
  formData.append("termid", global_Termid);
  formData.append("termtypes", termtypes);
  formData.append("user", user.username);
  formData.append("latest", endTermStatLatestToggle.value);

  axios
    .post("/create.php?createEndStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        Swal.fire("Saved!", "", "success").then(() => {
          populateEditGrades();
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to create Progress Status End",
        });
      }
    });
};
</script>
<style scoped>
.glass {
  background: rgba(146, 228, 59, 0.1);
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.18);
}

.glass2 {
  background: rgba(248, 231, 28, 0.1);
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(5px);
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.18);
}
</style>
