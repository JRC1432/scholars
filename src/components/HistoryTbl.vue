<template>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 q-pa-sm">
      <q-card
        flat
        bordered
        class="my-card text-black rounded-borders-20 q-mr-sm"
      >
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

          <!-- <template v-slot:top-left>
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
          </template> -->

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
                  color="purple"
                  :label="props.row.schoolcourse"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }}</span>
                </q-badge>
              </q-td>

              <q-td key="pstart" :props="props">
                <q-badge
                  v-if="
                    props.row.pstart === null ||
                    props.row.pstart === '' ||
                    props.row.actflag1 === false
                  "
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>
                <q-badge
                  v-else-if="props.row.verify1 === false"
                  color="orange-4"
                  :label="props.row.pstart + '  (Unverified)'"
                  @click="openpstart(props)"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }} </span>
                </q-badge>

                <q-badge
                  v-else
                  @click="openpstart(props)"
                  color="purple"
                  :label="props.row.pstart"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }}</span>
                </q-badge>
              </q-td>

              <q-td key="sstanding" :props="props">
                <q-badge
                  v-if="
                    props.row.sstanding === null ||
                    props.row.sstanding === '' ||
                    props.row.actflag3 === false
                  "
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>

                <q-badge
                  v-else-if="props.row.verify3 === false"
                  color="orange-4"
                  :label="props.row.sstanding + '  (Unverified)'"
                  @click="opensstanding(props)"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }} </span>
                </q-badge>

                <q-badge
                  v-else
                  @click="opensstanding(props)"
                  color="purple"
                  :label="props.row.sstanding"
                  class="pointer-class"
                >
                  <!-- Display props.row.sstanding only -->
                  <span style="display: none">{{ props.row.term_id }}</span>
                </q-badge>
              </q-td>

              <q-td key="pend" :props="props">
                <q-badge
                  v-if="
                    props.row.pend === null ||
                    props.row.pend === '' ||
                    props.row.actflag2 === false
                  "
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>

                <q-badge
                  v-else-if="props.row.verify2 === false"
                  color="orange-4"
                  :label="props.row.pend + '  (Unverified)'"
                  @click="openpend(props)"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }} </span>
                </q-badge>

                <q-badge
                  v-else
                  @click="openpend(props)"
                  color="purple"
                  :label="props.row.pend"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }}</span>
                </q-badge>
              </q-td>
              <q-td key="send" :props="props">
                <q-badge
                  v-if="
                    props.row.send === null ||
                    props.row.send === '' ||
                    props.row.actflag4 === false
                  "
                  color="red-4"
                  :label="props.value"
                >
                  N/A
                </q-badge>

                <q-badge
                  v-else-if="props.row.verify4 === false"
                  color="orange-4"
                  :label="props.row.send + '  (Unverified)'"
                  @click="opensend(props)"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }} </span>
                </q-badge>

                <q-badge
                  v-else
                  @click="opensend(props)"
                  color="purple"
                  :label="props.row.send"
                  class="pointer-class"
                >
                  <span style="display: none">{{ props.row.term_id }}</span>
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
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{ sy }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold" v-if="term === 1"
                    >1st Term</text
                  >
                  <text class="on-surface-text text-bold" v-else-if="term === 2"
                    >2nd Term</text
                  >
                  <text class="on-surface-text text-bold" v-else-if="term === 3"
                    >3rd Term</text
                  >
                  <text class="on-surface-text text-bold" v-else-if="term === 4"
                    >4th Term</text
                  >
                  <text class="on-surface-text text-bold" v-else>5th Term</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">School:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{ school }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Course:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{ course }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{ create }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{ update }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{ verified }}</text>
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created At:</td>
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{
                    created_at
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
                    updated_at
                  }}</text>
                </td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <!-- <q-btn
              v-if="verif_flag === 1"
              outline
              style="color: goldenrod"
              label="Disallow"
              @click="disCourse"
            />
            <q-btn
              v-else
              outline
              style="color: goldenrod"
              label="Allow"
              @click="allowCourse"
            />

            <q-btn
              outline
              style="color: goldenrod"
              label="Update"
              @click="editCourse"
            /> -->
            <q-btn
              outline
              style="color: goldenrod"
              label="View On Monitoring Sheet"
              :to="`/editgrades/${sc_termid}`"
            />
          </div>
        </q-card-actions>
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
                  <text
                    class="on-surface-text text-bold"
                    v-if="pstartTerm === 1"
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
            <!-- <q-btn
              v-if="pstartVerified_flag === false"
              outline
              style="color: goldenrod"
              label="Verify"
              @click="verifyPStart"
            />
            <q-btn
              v-else
              outline
              style="color: goldenrod"
              label="Disallow"
              @click="disPStart"
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
            /> -->

            <q-btn
              outline
              style="color: goldenrod"
              label="View On Monitoring Sheet"
              :to="`/editgrades/${ps_termid}`"
            />
          </div>
        </q-card-actions>
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
                <td v-if="loading">
                  <q-skeleton animation="blink" type="text" width="300px" />
                </td>
                <td v-else>
                  <text class="on-surface-text text-bold">{{
                    startTermsy
                  }}</text>
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
            <!-- <q-btn
              v-if="startTermVerified_flag === false"
              outline
              style="color: goldenrod"
              label="Verify"
              @click="verifyStartTerm"
            />
            <q-btn
              v-else
              outline
              style="color: goldenrod"
              label="Disallow"
              @click="disStartTerm"
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
            /> -->
            <q-btn
              outline
              style="color: goldenrod"
              label="View On Monitoring Sheet"
              :to="`/editgrades/${sTerm_termid}`"
            />
          </div>
        </q-card-actions>
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
                  <text class="on-surface-text text-bold">{{
                    pendCreate
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
                    pendUpdate
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
            <!-- <q-btn
              v-if="pendVerified_flag === false"
              outline
              style="color: goldenrod"
              label="Verify"
              @click="verifyPSEnd"
            />
            <q-btn
              v-else
              outline
              style="color: goldenrod"
              label="Disallow"
              @click="disPSEnd"
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
            /> -->
            <q-btn
              outline
              style="color: goldenrod"
              label="View On Monitoring Sheet"
              :to="`/editgrades/${psEnd_termid}`"
            />
          </div>
        </q-card-actions>
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
                  <text
                    class="on-surface-text text-bold"
                    v-if="endTermterm === 1"
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
                  <text class="on-surface-text text-bold" v-else>
                    5th Term
                  </text>
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
            <!-- <q-btn
              v-if="endTermVerified_flag === false"
              outline
              style="color: goldenrod"
              label="Verify"
              @click="verifyEndTerm"
            />

            <q-btn
              v-else
              outline
              style="color: goldenrod"
              label="Disallow"
              @click="disEndTerm"
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
            /> -->

            <q-btn
              outline
              style="color: goldenrod"
              label="View On Monitoring Sheet"
              :to="`/editgrades/${endTerm_termid}`"
            />
          </div>
        </q-card-actions>
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
            :options="termTypeOptions"
            v-model="state.StatTermType"
            emit-value
            name="StatTermType"
            outlined
            dense
            use-input
            map-options
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
        <div class="q-px-sm" v-if="state.termRec === 'Add New Term Record'">
          <span class="text-bold">Term</span>
          <q-select
            ref="refStatTerm"
            :options="computedTermOptions"
            v-model="state.StatTerm"
            emit-value
            name="StatTerm"
            outlined
            dense
            use-input
            map-options
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
            ref="refaddStats"
            outlined
            dense
            hide-bottom-space
            emit-value
            map-options
            use-input
            input-debounce="0"
            :options="stat1options"
            @filter="filterstat1"
            v-model="state.addStats"
            name="addStats"
            clearable
          />
        </div>
        <div class="q-px-sm text-bold">
          <span class="text-bold">Monitoring Status</span>
          <q-select
            ref="refmonitorStats"
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
            :options="termTypeOptions"
            v-model="state.csStatTermType"
            emit-value
            map-options
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
            :options="computedTermOption"
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

  <!-- Edit Course -->

  <q-dialog v-model="editModalCourse" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">EDIT</span>
          Course & School
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <div class="q-px-sm text-bold">
          <span class="text-bold">School Year</span>
          <q-input outlined dense v-model="state.cssy" name="cssy" readonly />
        </div>
        <div class="q-px-sm text-bold">
          <span class="text-bold">Term</span>
          <q-input
            outlined
            dense
            v-model="state.csterm"
            name="csterm"
            readonly
          />
        </div>
        <div class="q-px-sm text-bold">
          <span class="text-bold">Course & School</span>
          <q-select
            ref="refcsCourseSchool"
            :options="scrTermoptions"
            v-model="state.csCourseSchool"
            name="csCourseSchool"
            emit-value
            outlined
            dense
            hide-bottom-space
            :rules="[myRule]"
          />
        </div>
      </q-card-section>

      <q-card-actions align="center">
        <div class="q-pa-md q-gutter-sm">
          <q-btn outline style="color: goldenrod" label="Save" />
          <q-btn outline style="color: goldenrod" label="Reset" />
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
          <div class="q-px-sm text-bold">
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
              v-model="state.endTermSY"
              name="endTermSY"
              readonly
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Term</span>
            <q-input
              outlined
              dense
              v-model="state.endTermterm"
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
          <div class="q-px-sm text-bold">
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
  IconEdit,
  IconRefresh,
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
  rowsPerPage: 8,
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
  monitorStats: "",

  statSy: "",
  StatTermType: "",
  StatTerm: "",
  monitorStats: "",

  csTermRec: "",
  csstatSy: "",
  csStatTermType: "",
  csStatTerm: "",
  scrTerm: "",
  cssy: "",
  csterm: "",
  csCourseSchool: "",

  psSY: "",
  psTerm: "",
  psStartEnd: "",
  psProgressStats: "",

  peSY: "",
  peTerm: "",
  peStartEnd: "",
  peProgressStats: "",

  startUPTermSY: "",
  startUPTerm: "",
  startUPStartEnd: "",
  startTermStatLatest: "",
  startTermProgressStat: "",
  startTermMonitorStats: "",

  endTermSY: "",
  endTermterm: "",
  endTermStartEnd: "",
  endTermProgressStat: "",
  endTermMonitorStats: "",
});

// View history

const seTerm = ref("1");
const statLatest = ref("NO");
const PSstatLatest = ref("NO");
const PEstatLatest = ref("NO");
const startTermStatLatest = ref("NO");
const endTermStatLatest = ref("NO");

// Reference
const reftermRec = ref(null);
const refstatSy = ref(null);
const refStatTermType = ref(null);
const refStatTerm = ref(null);
const refmonitorStats = ref(null);

const refcsTermRec = ref(null);
const refcsstatSy = ref(null);
const refcsStatTermType = ref(null);
const refcsStatTerm = ref(null);
const refscrTerm = ref(null);
const refcsCourseSchool = ref(null);

const refpsProgressStats = ref(null);
const refpeProgressStats = ref(null);
const refstartTermProgressStat = ref(null);

const refendTermProgressStat = ref(null);
const refendTermMonitor = ref(null);

// Cards trigger
const viewcourse = ref(false);
const pstart = ref(false);
const standstart = ref(false);
const pend = ref(false);
const standend = ref(false);
const openStatus = ref(false);
const openAddSC = ref(false);
const editModalCourse = ref(false);
const editModalPSStart = ref(false);
const editModalPSEnd = ref(false);
const editModalStartTerm = ref(false);
const editModalEndTerm = ref(false);

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
const verif_flag = ref();
const sc_termid = ref();

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
const ps_termid = ref();

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
const psEnd_termid = ref();

// View Start Term Standing

const startTermsy = ref();
const startTermterm = ref();
const startTermStrEnd = ref();
const startTermStand = ref();
const startTermLatest = ref();
const startTermMonitor = ref();
const startTermCreated = ref();
const startTermUpdate = ref();
const startTermVerified_by = ref();
const startTermCreated_at = ref();
const startTermUpdated_at = ref();
const startTermVerified_flag = ref();
const sTerm_termid = ref();

// View End Term Standing

const endTermsy = ref();
const endTermterm = ref();
const endTermStrEnd = ref();
const endTermStand = ref();
const endTermLatest = ref();
const endTermMonitor = ref();
const endTermCreated = ref();
const endTermUpdate = ref();
const endTermVerified_by = ref();
const endTermCreated_at = ref();
const endTermUpdated_at = ref();
const endTermVerified_flag = ref();
const endTerm_termid = ref();

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

// Loading Simulation

const loading = ref(false);

const simulateLoad = () => {
  loading.value = true;
  // Simulating an API call delay
  setTimeout(() => {
    loading.value = false;
  }, 2000); // Delay of 3 seconds
};

const globalSPAS = route.params.id;

// Select Statements

const termRecOptions = ref();
const scrTermoptions = ref("Select");
const preTermRec = "Add New Term Record";
const endTermProgressStatOptions = ref();

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
  formData.append("id", globalSPAS);

  axios.post("/read.php?historyRecID", formData).then((response) => {
    rows.value = response.data;
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

  axios.post("/read.php?standing", formData).then((response) => {
    endTermProgressStatOptions.value = response.data;
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

// TermType
const termTypeOptions = [
  { label: "Semestral", value: "2", color: "primary" },
  { label: "Trimestral", value: "3", color: "primary" },
  { label: "Quarterly", value: "4", color: "primary" },
];

const termOptions = {
  2: [
    { label: "1st", value: "1", color: "primary" },
    { label: "2nd", value: "2", color: "primary" },
    { label: "Summer", value: "3", color: "primary" },
    { label: "Midyear", value: "4", color: "primary" },
  ],
  3: [
    { label: "1st", value: "1", color: "primary" },
    { label: "2nd", value: "2", color: "primary" },
    { label: "3rd", value: "3", color: "primary" },
    { label: "Summer", value: "4", color: "primary" },
  ],
  4: [
    { label: "1st", value: "1", color: "primary" },
    { label: "2nd", value: "2", color: "primary" },
    { label: "3rd", value: "3", color: "primary" },
    { label: "4th", value: "4", color: "primary" },
    { label: "Summer", value: "5", color: "primary" },
  ],
};
const computedTermOptions = computed(() => {
  return termOptions[state.StatTermType] || [];
});

const computedTermOption = computed(() => {
  return termOptions[state.csStatTermType] || [];
});

// Read School/Course

const openSC = async (props) => {
  simulateLoad();
  try {
    console.log(props?.row?.term_id);

    if (!props || !props.row) {
      console.error("Props or props.row is missing");
      return;
    }

    viewcourse.value = !viewcourse.value;
    pstart.value = false;
    standstart.value = false;
    pend.value = false;
    standend.value = false;

    const formData = new FormData();
    formData.append("termid", props.row.term_id);

    console.log(props.row.term_id);

    const response = await axios.post("/read.php?viewCourseID", formData);

    sy.value = response.data.sy;
    term.value = response.data.term;
    school.value = response.data.school;
    course.value = response.data.course;
    create.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;
    created_at.value = response.data.created_at;
    updated_at.value = response.data.updated_at;
    verif_flag.value = response.data.verified_flag;
    sc_termid.value = response.data.term_id;
  } catch (error) {
    console.error("Error occurred while fetching course data:", error);
  }
};

// Prgress Status Start

const termid_PStart = ref();

const openpstart = async (props) => {
  simulateLoad();
  if (!props || !props.row) {
    console.error("Props or props.row is missing");
    return;
  }

  // router.push({
  //   path:
  //     "/historyrec/" +
  //     globalSPAS +
  //     "/" +
  //     props.row.term_id +
  //     "/" +
  //     "1" +
  //     "/" +
  //     "progress",
  // });

  pstart.value = !pstart.value;
  viewcourse.value = false;
  standstart.value = false;
  pend.value = false;
  standend.value = false;

  const formData = new FormData();
  formData.append("id", globalSPAS);
  formData.append("termstanding", props.row.term);
  formData.append("progress", props.row.pstart);
  formData.append("termid", props.row.term_id);

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
    ps_termid.value = response.data.term_id;

    termid_PStart.value = response.data.term_id;
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// Start of Term Standing

const startTermid = ref();

const opensstanding = async (props) => {
  simulateLoad();
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
  formData.append("termid", props.row.term_id);

  try {
    const response = await axios.post("/read.php?viewSTRTStandID", formData);

    startTermid.value = response.data.term_id;
    startTermsy.value = response.data.sy;
    startTermterm.value = response.data.term;
    startTermStrEnd.value = response.data.start_end;
    startTermStand.value = response.data.standing;
    startTermLatest.value = response.data.latest_flag;
    startTermMonitor.value = response.data.list_name;
    startTermCreated.value = response.data.created_by;
    startTermUpdate.value = response.data.updated_by;
    startTermVerified_by.value = response.data.verified_by;
    startTermCreated_at.value = response.data.created_at;
    startTermUpdated_at.value = response.data.updated_at;
    startTermVerified_flag.value = response.data.verified_flag;
    sTerm_termid.value = response.data.term_id;

    console.log(startTermVerified_flag.value);
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// Progress Status End

const termid_Pend = ref();

const openpend = async (props) => {
  simulateLoad();
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
  formData.append("termid", props.row.term_id);
  console.log(props.row.term_id);

  try {
    const response = await axios.post("/read.php?viewEndID", formData);

    termid_Pend.value = response.data.term_id;
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
    psEnd_termid.value = response.data.term_id;
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

// End Of Term Standing

const termid_endTerm = ref();

const opensend = async (props) => {
  simulateLoad();
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
  formData.append("termid", props.row.term_id);

  try {
    const response = await axios.post("/read.php?viewENDStandID", formData);

    termid_endTerm.value = response.data.term_id;
    endTermsy.value = response.data.sy;
    endTermterm.value = response.data.term;
    endTermStrEnd.value = response.data.start_end;
    endTermStand.value = response.data.standing;
    endTermLatest.value = response.data.latest_flag;
    endTermMonitor.value = response.data.list_name;
    endTermCreated.value = response.data.created_by;
    endTermUpdate.value = response.data.updated_by;
    endTermVerified_by.value = response.data.verified_by;
    endTermCreated_at.value = response.data.created_at;
    endTermUpdated_at.value = response.data.updated_at;
    endTermVerified_flag.value = response.data.verified_flag;
    endTerm_termid.value = response.data.term_id;
  } catch (error) {
    console.error("Error during axios request:", error);
  }
};

const addStatus = () => {
  openStatus.value = true;
};

const addSC = () => {
  openAddSC.value = true;
};

const editCourse = () => {
  editModalCourse.value = true;
  state.cssy = sy.value;
  state.csterm = term.value;
};

// Edit Progress Status (Start)

const term_id_Pstart = ref();
const editPSsart = () => {
  editModalPSStart.value = true;
  state.psSY = pstartSy.value;
  state.psTerm = pstartTerm.value;
  state.psStartEnd = pstartSE.value;
  PSstatLatest.value = pstartLatest.value === true ? "YES" : "NO";
  state.psProgressStats = pstartProgress.value;
  term_id_Pstart.value = termid_PStart.value;
};

const updatePSstart = () => {
  refpsProgressStats.value.validate();
  var formData = new FormData(document.getElementById("updatePSstartForm"));
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);
  formData.append("status", PSstatLatest.value);
  formData.append("termid", term_id_Pstart.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to save changes?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      if (refpsProgressStats.value.hasError) {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Please complete all the required fields.",
        });
      } else {
        const dialog = $q.dialog({
          message: "Updating... 0%",
          progress: true, // we enable default settings
          persistent: true, // we want the user to not be able to close it
          ok: false, // we want the user to not be able to close it
        });

        // we simulate some progress here...
        let percentage = 0;
        const interval = setInterval(() => {
          percentage = Math.min(
            100,
            percentage + Math.floor(Math.random() * 22)
          );

          // we update the dialog
          dialog.update({
            message: `${percentage}%`,
          });

          // if we are done....
          if (percentage === 100) {
            axios
              .post("/update.php?upProgressStart", formData)
              .then(function (response) {
                if (response.data == true) {
                  editModalPSStart.value = false;
                  readHistoryRec();

                  pstart.value = false;
                  clearInterval(interval);

                  dialog.update({
                    title: "Done!",
                    message: "Updated Successfully",
                    progress: false,
                    ok: true,
                  });
                } else {
                  $q.notify({
                    color: "red",
                    textColor: "white",
                    message: "Failed to update edit Progress Status(Start)",
                  });
                }
              });
          }
        }, 100);
      }
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Verify Progress Status (Start)

const verif_termid_PS_start = ref();
const verifyPStart = () => {
  verif_termid_PS_start.value = termid_PStart.value;

  var formData = new FormData();
  formData.append("termid", verif_termid_PS_start.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyProgressStart", formData)
    .then(function (response) {
      if (response.data == true) {
        readHistoryRec();
        pstart.value = false;

        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
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

// Delete & Disallow Progress Status (Start)

const dis_termid_PS_start = ref();
const disPStart = () => {
  dis_termid_PS_start.value = termid_PStart.value;
  var formData = new FormData();
  formData.append("termid", dis_termid_PS_start.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);
  console.log(dis_termid_PS_start.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to disallow?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Updating... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/update.php?disProgressStart", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                pstart.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Disallowed Successfully",
                  progress: false,
                  ok: true,
                });
              } else {
                $q.notify({
                  color: "red",
                  textColor: "white",
                  message: "Failed to disallow Progress Status(Start)",
                });
              }
            });
        }
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};
const del_termid_PS_start = ref();
const delPStart = () => {
  del_termid_PS_start.value = termid_PStart.value;
  var formData = new FormData();
  formData.append("spasid", globalSPAS);
  formData.append("deltermid", del_termid_PS_start.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to remove Progress Status (Start)?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Removing... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/delete.php?delProgressStart", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                pstart.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Removed Successfully",
                  progress: false,
                  ok: true,
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
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Edit Progress Status (End)

const term_ID_Pend = ref();

const editPSEnd = () => {
  editModalPSEnd.value = true;
  state.peSY = pendSy.value;
  state.peTerm = pendTerm.value;
  state.peStartEnd = pendSE.value;
  PEstatLatest.value = pendLatest.value === true ? "YES" : "NO";
  state.peProgressStats = pendProgress.value;
  term_ID_Pend.value = termid_Pend.value;
};

const updatePSend = () => {
  refpeProgressStats.value.validate();
  var formData = new FormData(document.getElementById("updatePSendForm"));
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);
  formData.append("status", PEstatLatest.value);
  formData.append("term_ID_Pend", term_ID_Pend.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to save changes?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      if (refpeProgressStats.value.hasError) {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Please complete all the required fields.",
        });
      } else {
        const dialog = $q.dialog({
          message: "Updating... 0%",
          progress: true, // we enable default settings
          persistent: true, // we want the user to not be able to close it
          ok: false, // we want the user to not be able to close it
        });

        // we simulate some progress here...
        let percentage = 0;
        const interval = setInterval(() => {
          percentage = Math.min(
            100,
            percentage + Math.floor(Math.random() * 22)
          );

          // we update the dialog
          dialog.update({
            message: `${percentage}%`,
          });

          // if we are done...
          if (percentage === 100) {
            axios
              .post("/update.php?upProgressEnd", formData)
              .then(function (response) {
                if (response.data == true) {
                  editModalPSEnd.value = false;
                  pend.value = false;
                  readHistoryRec();
                  clearInterval(interval);
                  dialog.update({
                    title: "Done!",
                    message: "Updated Successfully",
                    progress: false,
                    ok: true,
                  });
                } else {
                  $q.notify({
                    color: "red",
                    textColor: "white",
                    message: "Failed to update Progress Status End",
                  });
                }
              });
          }
        }, 100);
      }
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Verify Progress Status (End)

const verif_termid_PS_end = ref();
const verifyPSEnd = () => {
  verif_termid_PS_end.value = termid_Pend.value;

  var formData = new FormData();
  formData.append("termid", verif_termid_PS_end.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyProgressEnd", formData)
    .then(function (response) {
      if (response.data == true) {
        readHistoryRec();
        pend.value = false;

        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
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

// Delete & Disallow Progress Status (End)

const dis_termid_PS_end = ref();
const disPSEnd = () => {
  dis_termid_PS_end.value = termid_Pend.value;
  console.log(dis_termid_PS_end.value);

  var formData = new FormData();
  formData.ap("termid", dis_termid_PS_end.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to disallow?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Updating... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/update.php?disProgressEnd", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                pend.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Disallowed Successfully",
                  progress: false,
                  ok: true,
                });
              } else {
                $q.notify({
                  color: "red",
                  textColor: "white",
                  message: "Failed to disallow Progress Status(End)",
                });
              }
            });
        }
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

const del_termid_PS_end = ref();
const delPSEnd = () => {
  del_termid_PS_end.value = termid_Pend.value;
  console.log(del_termid_PS_end.value);

  var formData = new FormData();
  formData.append("spasid", globalSPAS);
  formData.append("deltermid", del_termid_PS_end.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to remove Progress Status (End)?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Removing... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/delete.php?delProgressEnd", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                pend.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Removed Successfully",
                  progress: false,
                  ok: true,
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
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Edit Start Term Stnding

const start_Term_Id = ref();

const editStartTerm = () => {
  editModalStartTerm.value = true;
  state.startUPTermSY = startTermsy.value;
  state.startUPTerm = startTermterm.value;
  state.startUPStartEnd = startTermStrEnd.value;
  startTermStatLatest.value = startTermLatest.value === true ? "YES" : "NO";
  state.startTermProgressStat = startTermStand.value;
  state.startTermMonitorStats = startTermMonitor.value;
  start_Term_Id.value = startTermid.value;
};

const updateStartTerm = () => {
  refstartTermProgressStat.value.validate();
  var formData = new FormData(document.getElementById("updateStartTermForm"));
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);
  formData.append("status", startTermStatLatest.value);
  formData.append("start_Term_Id", start_Term_Id.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to save changes?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      if (refstartTermProgressStat.value.hasError) {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Please complete all the required fields.",
        });
      } else {
        const dialog = $q.dialog({
          message: "Updating... 0%",
          progress: true, // we enable default settings
          persistent: true, // we want the user to not be able to close it
          ok: false, // we want the user to not be able to close it
        });

        // we simulate some progress here...
        let percentage = 0;
        const interval = setInterval(() => {
          percentage = Math.min(
            100,
            percentage + Math.floor(Math.random() * 22)
          );

          // we update the dialog
          dialog.update({
            message: `${percentage}%`,
          });

          // if we are done...
          if (percentage === 100) {
            axios
              .post("/update.php?upStartTermStanding", formData)
              .then(function (response) {
                if (response.data == true) {
                  editModalStartTerm.value = false;
                  standstart.value = false;
                  readHistoryRec();
                  clearInterval(interval);
                  dialog.update({
                    title: "Done!",
                    message: "Updated Successfully",
                    progress: false,
                    ok: true,
                  });
                } else {
                  $q.notify({
                    color: "red",
                    textColor: "white",
                    message: "Failed to update Start of Term Standing",
                  });
                }
              });
          }
        }, 100);
      }
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Verify Start of Term Standing

const verif_termid_StartTerm = ref();
const verifyStartTerm = () => {
  verif_termid_StartTerm.value = startTermid.value;

  var formData = new FormData();
  formData.append("termid", verif_termid_StartTerm.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyStartTermStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        readHistoryRec();
        standstart.value = false;

        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
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

// Delete & Disallow Start of Term Standing

const dis_termid_StartTerm = ref();
const disStartTerm = () => {
  dis_termid_StartTerm.value = startTermid.value;

  var formData = new FormData();
  formData.append("termid", dis_termid_StartTerm.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to disallow?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Updating... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/update.php?disStartTermStanding", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                pstart.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Disallowed Successfully",
                  progress: false,
                  ok: true,
                });
              } else {
                $q.notify({
                  color: "red",
                  textColor: "white",
                  message: "Failed to disallow Start of Term Standing",
                });
              }
            });
        }
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

const del_termid_StartTerm = ref();
const delStartTerm = () => {
  del_termid_StartTerm.value = startTermid.value;

  var formData = new FormData();
  formData.append("spasid", globalSPAS);
  formData.append("deltermid", del_termid_StartTerm.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to remove Start of Term Standing?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Removing... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/delete.php?delStartTerm", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                pstart.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Removed Successfully",
                  progress: false,
                  ok: true,
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
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Edit End Term Stnding

const term_ID_endTerm = ref();
const editEndTerm = () => {
  editModalEndTerm.value = true;
  state.endTermSY = endTermsy.value;
  state.endTermterm = endTermterm.value;
  state.endTermStartEnd = endTermStrEnd.value;
  endTermStatLatest.value = endTermLatest.value === true ? "YES" : "NO";
  state.endTermProgressStat = endTermStand.value;
  state.endTermMonitorStats = endTermMonitor.value;
  term_ID_endTerm.value = termid_endTerm.value;
};

const updateEndTerm = () => {
  refendTermProgressStat.value.validate();
  var formData = new FormData(document.getElementById("updateEndTermForm"));
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);
  formData.append("status", endTermStatLatest.value);
  formData.append("term_ID_endTerm", term_ID_endTerm.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to save changes?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      if (refendTermProgressStat.value.hasError) {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Please complete all the required fields.",
        });
      } else {
        const dialog = $q.dialog({
          message: "Updating... 0%",
          progress: true, // we enable default settings
          persistent: true, // we want the user to not be able to close it
          ok: false, // we want the user to not be able to close it
        });

        // we simulate some progress here...
        let percentage = 0;
        const interval = setInterval(() => {
          percentage = Math.min(
            100,
            percentage + Math.floor(Math.random() * 22)
          );

          // we update the dialog
          dialog.update({
            message: `${percentage}%`,
          });

          // if we are done...
          if (percentage === 100) {
            axios
              .post("/update.php?upEndTermStanding", formData)
              .then(function (response) {
                if (response.data == true) {
                  editModalEndTerm.value = false;
                  standend.value = false;
                  readHistoryRec();
                  clearInterval(interval);
                  dialog.update({
                    title: "Done!",
                    message: "Updated Successfully",
                    progress: false,
                    ok: true,
                  });
                } else {
                  $q.notify({
                    color: "red",
                    textColor: "white",
                    message: "Failed to update End of Term Standing",
                  });
                }
              });
          }
        }, 100);
      }
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

// Verify End Of Term Standing

const verif_termid_EndTerm = ref();
const verifyEndTerm = () => {
  verif_termid_EndTerm.value = termid_endTerm.value;

  var formData = new FormData();
  formData.append("termid", verif_termid_EndTerm.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  axios
    .post("/update.php?verifyEndTermStanding", formData)
    .then(function (response) {
      if (response.data == true) {
        readHistoryRec();
        standend.value = false;

        Swal.fire({
          icon: "success",
          title: "Verified Successfully",
          showConfirmButton: false,
          timer: 1500,
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

// Delete & Disallow End of Term Standing

const dis_termid_EndTerm = ref();
const disEndTerm = () => {
  dis_termid_EndTerm.value = termid_endTerm.value;
  console.log(dis_termid_EndTerm.value);

  var formData = new FormData();
  formData.append("termid", dis_termid_EndTerm.value);
  formData.append("spasid", globalSPAS);
  formData.append("user", user.username);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to disallow?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Updating... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/update.php?disEndTermStanding", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                standend.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Disallowed Successfully",
                  progress: false,
                  ok: true,
                });
              } else {
                $q.notify({
                  color: "red",
                  textColor: "white",
                  message: "Failed to disallow End of Term Standing",
                });
              }
            });
        }
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

const del_termid_EndTerm = ref();
const delEndTerm = () => {
  del_termid_EndTerm.value = termid_endTerm.value;

  console.log(del_termid_EndTerm.value);

  var formData = new FormData();
  formData.append("spasid", globalSPAS);
  formData.append("deltermid", del_termid_EndTerm.value);

  $q.dialog({
    title: "Confirm",
    message: "Do you want to remove End of Term Standing?",
    ok: {
      push: true,
    },
    cancel: {
      push: true,
      color: "negative",
    },
    persistent: true,
  })
    .onOk(() => {
      const dialog = $q.dialog({
        message: "Removing... 0%",
        progress: true, // we enable default settings
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done....
        if (percentage === 100) {
          axios
            .post("/delete.php?delEndTerm", formData)
            .then(function (response) {
              if (response.data == true) {
                readHistoryRec();
                standend.value = false;
                clearInterval(interval);
                dialog.update({
                  title: "Done!",
                  message: "Removed Successfully",
                  progress: false,
                  ok: true,
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
      }, 100);
    })
    .onCancel(() => {
      // console.log('>>>> Cancel')
    })
    .onDismiss(() => {
      // console.log('I am triggered on both OK and Cancel')
    });
};

const allowCourse = () => {
  console.log(sc_termid.value);
  var formData = new FormData();

  formData.append("user", user.username);
  formData.append("sc_termid", sc_termid.value);

  axios.post("/update.php?allowCourse", formData).then(function (response) {
    if (response.data == true) {
      readHistoryRec();
      viewcourse.value = false;
      Swal.fire({
        title: "SAVED!",
        text: "Allow Successfully",
        icon: "success",
      });
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to verify School & Course",
      });
    }
  });
};

const disCourse = () => {
  console.log(sc_termid.value);
  var formData = new FormData();

  formData.append("user", user.username);
  formData.append("sc_termid", sc_termid.value);

  axios.post("/update.php?disallowCourse", formData).then(function (response) {
    if (response.data == true) {
      readHistoryRec();
      viewcourse.value = false;
      Swal.fire({
        icon: "error",
        title: "Disallowed...",
        text: "Disallowed Successfully",
      });
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to verify School & Course",
      });
    }
  });
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
