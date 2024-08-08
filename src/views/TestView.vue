<template>
  <ScInfo />
  <div class="q-pa-lg">
    <q-card flat class="my-card surface-container rounded-borders-20">
      <div class="q-pa-md text-center text-bold primary-text text-h4">
        Scholarship Informations
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
              ><q-td key="spas_id" :props="props">
                {{ props.row.spas_id }}
              </q-td>
              <q-td key="yr_awarded" :props="props">
                {{ props.row.yr_awarded }}
              </q-td>
              <q-td key="program" :props="props">
                {{ props.row.program }}
              </q-td>
              <q-td key="sub_program" :props="props">
                {{ props.row.sub_program }}
              </q-td>
              <q-td key="category" :props="props">
                {{ props.row.category }}
              </q-td>
              <q-td key="duration" :props="props">
                {{ props.row.duration }}
              </q-td>
              <q-td key="remarks" :props="props">
                {{ props.row.remarks }}
              </q-td>
              <q-td key="reply_slip" :props="props">
                <template v-if="props.row.reply_slip === 'AVAILING'">
                  <q-badge
                    color="light-green-4"
                    :label="props.value"
                    @click="showReply(props)"
                    class="pointer-class"
                  >
                    {{ props.row.reply_slip }}
                  </q-badge>
                </template>
                <template v-else-if="props.row.reply_slip === 'DID NOT AVAIL'">
                  <q-badge
                    color="orange-4"
                    :label="props.value"
                    @click="showReply(props)"
                    class="pointer-class"
                  >
                    {{ props.row.reply_slip }}
                  </q-badge>
                </template>
                <template
                  v-else-if="
                    props.row.reply_slip === 'DEFERRED' ||
                    props.row.reply_slip === 'DEFERRRED'
                  "
                >
                  <q-badge
                    color="blue-4"
                    :label="props.value"
                    @click="showReply(props)"
                    class="pointer-class"
                  >
                    {{ props.row.reply_slip }}
                  </q-badge>
                </template>
                <template
                  v-else-if="props.row.reply_slip === 'QUALIFIER NO REPORT'"
                >
                  <q-badge
                    color="teal-4"
                    :label="props.value"
                    @click="showReply(props)"
                    class="pointer-class"
                  >
                    {{ props.row.reply_slip }}
                  </q-badge>
                </template>
                <template v-else-if="props.row.reply_slip === 'DISQUALIFIED'">
                  <q-badge
                    color="pink-4"
                    :label="props.value"
                    @click="showReply(props)"
                    class="pointer-class"
                  >
                    {{ props.row.reply_slip }}
                  </q-badge>
                </template>
                <template v-else>
                  <q-badge
                    @click="addReply(props)"
                    color="red-4"
                    :label="props.value"
                    class="pointer-class"
                  >
                    N/A
                  </q-badge>
                </template>
              </q-td>
              <q-td key="contract_status" :props="props">
                <template v-if="props.row.contract_status === 'DID NOT AVAIL'">
                  <q-badge
                    color="orange-4"
                    :label="props.value"
                    @click="shownotAvail(props)"
                    class="pointer-class"
                  >
                    {{ props.row.contract_status }}
                  </q-badge>
                </template>
                <template v-else-if="props.row.contract_status === 'AVAILING'">
                  <q-badge
                    color="light-green-4"
                    :label="props.value"
                    @click="showContractStats(props)"
                    class="pointer-class"
                  >
                    {{ props.row.contract_status }}
                  </q-badge>
                </template>
                <template v-else-if="props.row.contract_status === 'DEFERRED'">
                  <q-badge
                    color="blue-4"
                    :label="props.value"
                    @click="showDefer(props)"
                    class="pointer-class"
                  >
                    {{ props.row.contract_status }}
                  </q-badge>
                </template>
                <template v-else>
                  <q-badge color="red-4" :label="props.value"> N/A </q-badge>
                </template>
              </q-td>
              <q-td key="sy_insured" :props="props">
                {{ props.row.sy_insured }}
              </q-td>
              <q-td key="batch_insured" :props="props">
                {{ props.row.batch_insured }}
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </div>
    </q-card>
  </div>

  <!-- Scholar Contract Details  -->

  <q-dialog v-model="showContractDetails" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconScript :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">VIEW</span> CONTRACT
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <q-scroll-area style="height: 650px; max-width: 800px">
          <div class="q-mb-sm text-h5 primary-text text-bold">
            Contract Details
          </div>

          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">Contract Status</td>
                <td class="on-surface-text text-bold">
                  {{ contractStats }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Availed Award:</td>
                <td class="on-surface-text text-bold">
                  {{ avail }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Other Scholarship:</td>
                <td class="on-surface-text text-bold">
                  {{ otherScholarship }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Duration:</td>
                <td class="on-surface-text text-bold">
                  {{ duration }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">ETG Month:</td>
                <td class="on-surface-text text-bold">
                  {{ etgMonth }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">ETG:</td>
                <td class="on-surface-text text-bold">
                  {{ etg }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Scholar Deferred Before:</td>
                <td class="on-surface-text text-bold" v-if="scdefbef === 1">
                  YES
                </td>
                <td class="on-surface-text text-bold" v-else>NO</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">School:</td>
                <td class="on-surface-text text-bold">
                  {{ school }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Course:</td>
                <td class="on-surface-text text-bold">
                  {{ course }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">School Year Availed:</td>
                <td class="on-surface-text text-bold">
                  {{ scYearAvail }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term Type Availed:</td>
                <td class="on-surface-text text-bold">
                  {{ termType }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Term Availed:</td>
                <td class="on-surface-text text-bold">{{ termAvail }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td class="on-surface-text text-bold">{{ created }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td class="on-surface-text text-bold">{{ update }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td class="on-surface-text text-bold">{{ verified }}</td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-scroll-area>
      </q-card-section>

      <q-card-actions align="center">
        <q-btn
          outline
          style="color: goldenrod"
          label="Update"
          @click="UpdateContract"
        />
        <q-btn outline style="color: goldenrod" label="Disallow" />
        <q-btn outline style="color: goldenrod" label="Delete" />
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- DID NOT AVAIL -->

  <q-dialog v-model="showDidNotAvailContracts" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconScript :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">VIEW</span> CONTRACT
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <div class="q-mb-sm text-h5 primary-text text-bold">
          Contract Details
        </div>

        <q-markup-table separator="cell" flat bordered>
          <tbody>
            <tr>
              <td class="primary-text text-bold">Contract Status</td>
              <td class="on-surface-text text-bold">
                {{ contractStats }}
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Scholar Deferred Before:</td>
              <td class="on-surface-text text-bold" v-if="scdefbef === 1">
                YES
              </td>
              <td class="on-surface-text text-bold" v-else>NO</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Reason</td>
              <td class="on-surface-text text-bold">
                {{ reason }}
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created By:</td>
              <td class="on-surface-text text-bold">{{ created }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated By:</td>
              <td class="on-surface-text text-bold">{{ update }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Verified By:</td>
              <td class="on-surface-text text-bold">{{ verified }}</td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
    </q-card>
  </q-dialog>

  <!-- DEFERRED -->

  <q-dialog v-model="showDeferred" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconScript :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">VIEW</span> CONTRACT
        </q-toolbar-title>

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section
        ><div class="q-mb-sm text-h5 primary-text text-bold">
          Contract Details
        </div>

        <q-markup-table separator="cell" flat bordered>
          <tbody>
            <tr>
              <td class="primary-text text-bold">Contract Status</td>
              <td class="on-surface-text text-bold">
                {{ contractStats }}
              </td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Created By:</td>
              <td class="on-surface-text text-bold">{{ created }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Updated By:</td>
              <td class="on-surface-text text-bold">{{ update }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Verified By:</td>
              <td class="on-surface-text text-bold">{{ verified }}</td>
            </tr>
          </tbody>
        </q-markup-table>

        <div class="q-mb-sm text-h5 primary-text text-bold">
          Deferment Details
        </div>

        <q-markup-table separator="cell" flat bordered>
          <tbody>
            <tr>
              <td class="primary-text text-bold">With deferment form?</td>
              <td class="on-surface-text text-bold" v-if="defform === true">
                YES
              </td>
              <td class="on-surface-text text-bold" v-else>NO</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Reason:</td>
              <td class="on-surface-text text-bold">{{ defreason }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">School Year Deferred:</td>
              <td class="on-surface-text text-bold">{{ sydef }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Term Type Deferred:</td>
              <td class="on-surface-text text-bold">{{ termTypeDef }}</td>
            </tr>
            <tr>
              <td class="primary-text text-bold">Term Deferred:</td>
              <td class="on-surface-text text-bold">{{ termDef }}</td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
    </q-card>
  </q-dialog>

  <!-- Reply SLIP -->

  <q-dialog v-model="showReplies" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="DForm" @submit.prevent.stop="Removereply">
        <q-toolbar>
          <IconScript :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">VIEW</span> REPLY
            SLIP
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <q-markup-table separator="cell" flat bordered>
            <tbody>
              <tr>
                <td class="primary-text text-bold">Reply Slip</td>
                <td class="on-surface-text text-bold">
                  {{ replySlip }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Date of Reply</td>
                <td class="on-surface-text text-bold">
                  {{ datereply }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Reason</td>
                <td class="on-surface-text text-bold">
                  {{ reply_reason }}
                </td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Created By:</td>
                <td class="on-surface-text text-bold">{{ reply_created }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Updated By:</td>
                <td class="on-surface-text text-bold">{{ reply_updated }}</td>
              </tr>
              <tr>
                <td class="primary-text text-bold">Verified By:</td>
                <td class="on-surface-text text-bold">{{ reply_verified }}</td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>

        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn outline style="color: goldenrod" label="Disallow" />
            <q-btn
              outline
              style="color: goldenrod"
              label="Update"
              @click="Updatereply"
            />

            <q-btn
              outline
              style="color: goldenrod"
              label="Delete"
              type="submit"
            />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <!-- Add Reply slip -->

  <q-dialog v-model="addReplies" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="ReplyForm" @submit.prevent.stop="CreateReply">
        <q-toolbar>
          <IconMessageReply :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">ADD</span> REPLY
            SLIP
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">Reply Slip</span>
            <q-select
              ref="refreply"
              outlined
              dense
              hide-bottom-space
              behavior="menu"
              emit-value
              map-options
              input-debounce="0"
              v-model="state.reply"
              name="reply"
              :options="replyoptions"
              :rules="[myRule]"
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Date of Reply</span>
            <q-input
              ref="refdaterep"
              outlined
              dense
              type="date"
              hide-bottom-space
              v-model="state.daterep"
              name="daterep"
              :rules="inputRules"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Reason</span>
            <q-input
              v-model="state.reply_reason"
              name="reply_reason"
              filled
              autogrow
              outlined
              dense
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
            <q-btn
              outline
              style="color: goldenrod"
              label="Reset"
              @click="resetBtnrep"
            />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <!-- Update Reply Slip -->

  <q-dialog v-model="updateReplies" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="UpReplyForm" @submit.prevent.stop="UpdateReplyNow">
        <q-toolbar>
          <IconMessageReply :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">Update</span> REPLY
            SLIP
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">Reply Slip</span>
            <q-select
              ref="refupreply"
              outlined
              dense
              hide-bottom-space
              behavior="menu"
              emit-value
              map-options
              input-debounce="0"
              v-model="state.upreply"
              name="upreply"
              :options="replyoptions"
              :rules="[myRule]"
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Date of Reply</span>
            <q-input
              ref="refupdaterep"
              outlined
              dense
              type="date"
              hide-bottom-space
              v-model="state.updaterep"
              name="updaterep"
              :rules="inputRules"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Reason</span>
            <q-input
              v-model="state.upreply_reason"
              name="upreply_reason"
              filled
              autogrow
              outlined
              dense
            />
          </div>
        </q-card-section>
        <q-card-actions align="center">
          <div class="q-pa-md q-gutter-sm">
            <q-btn
              outline
              style="color: goldenrod"
              label="update"
              type="submit"
            />
            <q-btn
              outline
              style="color: goldenrod"
              label="Reset"
              @click="resetBtn"
            />
          </div>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>

  <q-dialog v-model="upContract" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="ContractForm" @submit.prevent.stop="UpdateContract">
        <q-toolbar>
          <IconScript :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">Update</span>
            Contract
          </q-toolbar-title>

          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>

        <q-card-section>
          <div class="q-px-sm">
            <span class="text-bold">Contract Status</span>
            <q-select
              ref="refcontractStats"
              outlined
              dense
              hide-bottom-space
              behavior="menu"
              emit-value
              map-options
              input-debounce="0"
              v-model="state.cntrctStatus"
              name="cntrctStatus"
              :options="cntrctStatusoptions"
              :rules="[myRule]"
            >
            </q-select></div
        ></q-card-section>

        <q-separator inset />

        <q-card-section v-if="state.cntrctStatus === 'AVAILING'">
          <div class="q-px-sm">
            <span class="text-bold">Availed Award </span>
            <q-select
              ref="refavail"
              :options="awardOptions"
              v-model="state.availAward"
              emit-value
              name="availAward"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Other Scholarship</span>
            <q-input
              ref="refotherScholarship"
              outlined
              dense
              hide-bottom-space
              v-model="state.otherScholarship"
              name="otherScholarship"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Contract Location</span>

            <q-select
              ref="refclocations"
              outlined
              dense
              hide-bottom-space
              behavior="menu"
              emit-value
              map-options
              use-input
              input-debounce="0"
              v-model="state.clocations"
              name="clocations"
              :options="regoptions"
              @filter="filterregion"
              :rules="[myRule]"
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Duration</span>
            <q-input
              ref="refduration"
              outlined
              dense
              hide-bottom-space
              v-model="state.duration"
              name="duration"
              type="number"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">ETG Month </span>
            <q-select
              ref="refetgMonth"
              :options="etgOptions"
              v-model="state.etgMonth"
              emit-value
              name="etgMonth"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">ETG</span>
            <q-input
              ref="refetg"
              outlined
              dense
              hide-bottom-space
              v-model="state.etg"
              name="etg"
              type="number"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Scholar deferred before?</span>
            <q-toggle
              :label="scholarDefer"
              v-model="scholarDefer"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="scholarDefer"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">School And Course Record</span>
            <q-select
              ref="refschoolCourse"
              :options="scOptions"
              v-model="state.schoolCourse"
              emit-value
              name="schoolCourse"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">SY and Term Started</span>
            <q-select
              ref="refSyTerm"
              :options="syOptions"
              v-model="state.SyTerm"
              emit-value
              name="SyTerm"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>

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
        </q-card-section>

        <q-card-section v-else-if="state.cntrctStatus === 'DID NOT AVAIL'">
          <div class="q-px-sm text-bold">
            <span class="text-bold">Scholar deferred before?</span>
            <q-toggle
              :label="didNotscholarDefer"
              v-model="didNotscholarDefer"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="didNotscholarDefer"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Reason</span>
            <q-input
              v-model="state.didNotreason"
              filled
              autogrow
              outlined
              dense
            />
          </div>

          <q-card-actions align="center">
            <div class="q-pa-md q-gutter-sm">
              <q-btn outline style="color: goldenrod" label="Save" />
              <q-btn outline style="color: goldenrod" label="Reset" />
            </div>
          </q-card-actions>
        </q-card-section>

        <q-card-section v-else-if="state.cntrctStatus === 'DEFERRED'">
          <div class="q-px-sm text-bold">
            <span class="text-bold">Scholar deferred before?</span>
            <q-toggle
              :label="defscholarDefer"
              v-model="defscholarDefer"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="defscholarDefer"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Reason</span>
            <q-input v-model="state.defreason" filled autogrow outlined dense />
          </div>

          <div class="q-px-sm">
            <span class="text-bold">School Year Deferred</span>
            <q-select
              ref="refschoolCourse"
              :options="scOptions"
              v-model="state.schoolCourse"
              emit-value
              name="schoolCourse"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term Type</span>
            <q-select
              ref="reftermType"
              :options="termtypeOptions"
              v-model="state.termType"
              emit-value
              name="termType"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Term Deferred</span>
            <q-select
              ref="reftermType"
              :options="termtypeOptions"
              v-model="state.termType"
              emit-value
              name="termType"
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Status is Latest?</span>
            <q-toggle
              :label="statsLatest"
              v-model="statsLatest"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="statsLatest"
            />
          </div>
          <div class="q-px-sm text-bold">
            <span class="text-bold">Record is Active?</span>
            <q-toggle
              :label="recActive"
              v-model="recActive"
              checked-icon="check"
              color="green"
              unchecked-icon="clear"
              false-value="NO"
              true-value="YES"
              name="recActive"
            />
          </div>

          <q-card-actions align="center">
            <div class="q-pa-md q-gutter-sm">
              <q-btn outline style="color: goldenrod" label="Save" />
              <q-btn outline style="color: goldenrod" label="Reset" />
            </div>
          </q-card-actions>
        </q-card-section>

        <q-card-section v-else>
          <q-banner
            inline-actions
            rounded
            class="tertiary-container rounded-borders-10"
          >
            <template v-slot:avatar>
              <q-icon name="error" color="primary" />
            </template>

            Please Select Contract Status
          </q-banner>
        </q-card-section>
      </form>
    </q-card>
  </q-dialog>
</template>
<script setup>
import ScInfo from "../components/ScInfo.vue";
import { ref, onMounted, reactive, inject, computed } from "vue";
import router from "../router";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
import {
  IconScript,
  IconMessageReply,
  IconAlertOctagon,
} from "@tabler/icons-vue";

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
const showContractDetails = ref(false);
const showDidNotAvailContracts = ref(false);
const showDeferred = ref(false);
const updateReplies = ref(false);

const showReplies = ref(false);
const addReplies = ref(false);
const upContract = ref(false);
const scholarDefer = ref("NO");
const didNotscholarDefer = ref("NO");
const defscholarDefer = ref("NO");
const statsLatest = ref("NO");
const recActive = ref("NO");

const contractStats = ref();
const avail = ref();
const otherScholarship = ref();
const duration = ref();
const etgMonth = ref();
const etg = ref();
const scdefbef = ref();
const school = ref();
const course = ref();
const scYearAvail = ref();
const termType = ref();
const termAvail = ref();
const reason = ref();
const created = ref();
const update = ref();
const verified = ref();

const defform = ref();
const defreason = ref();
const sydef = ref();
const termTypeDef = ref();
const termDef = ref();

const replySlip = ref();
const datereply = ref();
const reply_reason = ref();
const reply_created = ref();
const reply_updated = ref();
const reply_verified = ref();

const refreply = ref(null);
const refdaterep = ref(null);
const refupreply = ref(null);
const refupdaterep = ref(null);

// Validations

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

// Rules & Validations
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
];

// Sweet Alerts

const showalertReply = () => {
  let timerInterval;
  Swal.fire({
    title: "Submitting Reply Slip!",
    html: "I will close in <b></b> milliseconds.",
    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
      const timer = Swal.getPopup().querySelector("b");
      timerInterval = setInterval(() => {
        timer.textContent = `${Swal.getTimerLeft()}`;
      }, 100);
    },
    willClose: () => {
      clearInterval(timerInterval);
    },
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log("I was closed by the timer");
      Swal.fire("Saved!", "", "success");
    }
  });
};

// Sweet Alerts

const updateAlertReply = () => {
  let timerInterval;
  Swal.fire({
    title: "Updating Reply Slip!",
    html: "I will close in <b></b> milliseconds.",
    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
      const timer = Swal.getPopup().querySelector("b");
      timerInterval = setInterval(() => {
        timer.textContent = `${Swal.getTimerLeft()}`;
      }, 100);
    },
    willClose: () => {
      clearInterval(timerInterval);
    },
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log("I was closed by the timer");
      Swal.fire("Saved!", "", "success");
    }
  });
};

const state = reactive({
  reply: "",
  daterep: "",
  reply_reason: "",

  upreply: "",
  updaterep: "",
  upreply_reason: "",

  cntrctStatus: "",
  availAward: "",
  otherScholarship: "",
  etgMonth: "",
  etg: "",
  didNotreason: "",
  defreason: "",
});

const columns = [
  {
    name: "spas_id",
    required: true,
    label: "SPAS ID",
    align: "left",
    field: "spas_id",
    sortable: true,
  },

  {
    name: "yr_awarded",
    required: true,
    label: "Year Awarded",
    align: "left",
    field: "yr_awarded",
    sortable: true,
  },
  {
    name: "program",
    align: "left",
    label: "Program",
    field: "program",
    sortable: true,
  },
  {
    name: "sub_program",
    align: "left",
    label: "Sub Program",
    field: "sub_program",
    sortable: true,
  },
  {
    name: "category",
    align: "left",
    label: "Category",
    field: "category",
    sortable: true,
  },
  {
    name: "duration",
    align: "left",
    label: "Duration",
    field: "duration",
    sortable: true,
  },
  {
    name: "remarks",
    align: "left",
    label: "Remarks",
    field: "remarks",
    sortable: true,
  },
  {
    name: "reply_slip",
    align: "left",
    label: "Reply Slip",
    field: "reply_slip",
    sortable: true,
  },
  {
    name: "contract_status",
    align: "left",
    label: "Contract",
    field: "contract_status",
    sortable: true,
  },
  {
    name: "sy_insured",
    align: "left",
    label: "SY Insured",
    field: "sy_insured",
    sortable: true,
  },
  {
    name: "batch_insured",
    align: "left",
    label: "Batch insured",
    field: "batch_insured",
    sortable: true,
  },
];

// SELECT Reply

const replyoptions = ref();
onMounted(() => {
  populatereply();
});

const populatereply = () => {
  axios.get("/read.php?reply").then((response) => {
    replyoptions.value = response.data;
  });
};

// SELECT COntract Status

const cntrctStatusoptions = ref();
onMounted(() => {
  populateStatus();
});

const populateStatus = () => {
  axios.get("/read.php?contractStatus").then((response) => {
    cntrctStatusoptions.value = response.data;
  });
};

// SELECT ETG Month
const etgOptions = ref();
onMounted(() => {
  populateETG();
});

const populateETG = () => {
  axios.get("/read.php?etgMonth").then((response) => {
    etgOptions.value = response.data;
  });
};

// Availed Award
const awardOptions = [
  { label: "BS", value: "BS", color: "primary" },
  { label: "TN", value: "TN", color: "primary" },
  { label: "TL", value: "TL", color: "primary" },
];

// Select Regions
var regoptions2 = [];
const regoptions = ref(regoptions2);

onMounted(() => {
  populatereg();
});

const populatereg = () => {
  axios.get("/read.php?region").then((response) => {
    regoptions2 = response.data;
  });
};

const filterregion = (val, update) => {
  if (val === "") {
    update(() => {
      regoptions.value = regoptions2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    regoptions.value = regoptions2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Read Scholars
const id = ref();

onMounted(() => {
  readscholarinfo();
});

const readscholarinfo = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);
  axios.post("/read.php?readScholarInfoID", formData).then((response) => {
    rows.value = response.data;
  });
};

// Availing

const spasid = ref();

const showContractStats = (props) => {
  showContractDetails.value = true;

  spasid.value = props.row.spas_id;
  var formData = new FormData();
  formData.append("id", spasid.value);

  axios.post("/read.php?readSCID", formData).then((response) => {
    contractStats.value = response.data.contract_status;
    avail.value = response.data.avail_award;
    otherScholarship.value = response.data.other_schp;
    duration.value = response.data.duration;

    etgMonth.value = response.data.etg_month;
    etg.value = response.data.etg;
    school.value = response.data.schools;
    course.value = response.data.course;
    scdefbef.value = response.data.deferment_status;
    scYearAvail.value = response.data.sy;
    termType.value = response.data.term_type;
    termAvail.value = response.data.term;
    created.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;
  });
};

// DID NOT AVAIL

const spasidNotAvail = ref();

const shownotAvail = (props) => {
  showDidNotAvailContracts.value = true;
  spasidNotAvail.value = props.row.spas_id;

  var formData = new FormData();
  formData.append("id", spasidNotAvail.value);

  axios.post("/read.php?readSCID", formData).then((response) => {
    contractStats.value = response.data.contract_status;

    scdefbef.value = response.data.deferment_status;
    reason.value = response.data.reason;

    created.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;
  });
};

// DEFerred

const spasidDefer = ref();

const showDefer = (props) => {
  showDeferred.value = true;
  spasidDefer.value = props.row.spas_id;

  var formData = new FormData();
  formData.append("id", spasidDefer.value);

  axios.post("/read.php?readSCID", formData).then((response) => {
    contractStats.value = response.data.contract_status;

    created.value = response.data.created_by;
    update.value = response.data.updated_by;
    verified.value = response.data.verified_by;

    defform.value = response.data.with_deferment_form;
    defreason.value = response.data.defer_reason;
    sydef.value = response.data.sy_deferred;
    termTypeDef.value = response.data.defer_type;
    termDef.value = response.data.term_deferred;
  });
};

// Reply Slip

// const spasReply = ref();

const showReply = (props) => {
  showReplies.value = true;

  showReply.value = props.row.spas_id;
  state.upreply = props.row.reply_slip;

  var formData = new FormData();
  formData.append("id", showReply.value);

  axios.post("/read.php?readReplyId", formData).then((response) => {
    replySlip.value = response.data.reply_slip;
    datereply.value = response.data.date_reply;
    reply_reason.value = response.data.reason;
    reply_created.value = response.data.created_by;
    reply_updated.value = response.data.updated_by;
    reply_verified.value = response.data.verified_by;
    state.updaterep = response.data.date_reply;
    state.upreply_reason = response.data.reason;
  });
};

// Add New Reply

const spasreplyid = ref();

const addReply = (props) => {
  addReplies.value = true;
  spasreplyid.value = props.row.spas_id;
};

const CreateReply = () => {
  refreply.value.validate();
  refdaterep.value.validate();
  console.log(user.username);
  console.log(spasreplyid.value);

  if (refreply.value.hasError || refdaterep.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    var formData = new FormData(document.getElementById("ReplyForm"));

    formData.append("spasid", spasreplyid.value);
    formData.append("user", user.username);

    axios
      .post("/create.php?createReplySlip", formData)
      .then(function (response) {
        if (response.data == true) {
          state.reply = "";
          state.daterep = "";
          state.reply_reason = "";
          showalertReply();
          addReplies.value = false;
          readscholarinfo();
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "Failed to create new reply Slip",
          });
        }
      });
  }
};

// Update Reply

const Updatereply = () => {
  console.log(showReply.value);
  console.log(user.username);
  showReplies.value = false;
  updateReplies.value = true;
};

const UpdateReplyNow = () => {
  refupreply.value.validate();
  refupdaterep.value.validate();

  if (refupreply.value.hasError || refupdaterep.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    var formData = new FormData(document.getElementById("UpReplyForm"));

    formData.append("upspasid", showReply.value);
    formData.append("user", user.username);

    axios
      .post("/update.php?updateReplySlip", formData)
      .then(function (response) {
        if (response.data == true) {
          updateAlertReply();
          updateReplies.value = false;
          readscholarinfo();
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "Failed to update reply Slip",
          });
        }
      });
  }
};

// Remove Reply

const Removereply = () => {
  console.log(showReply.value);

  showReplies.value = false;
  var formData = new FormData(document.getElementById("DForm"));
  formData.append("delSpasid", showReply.value);

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
        .post("/delete.php?delReplySlip", formData)
        .then(function (response) {
          if (response.data == true) {
            readscholarinfo();
            Swal.fire({
              title: "Deleted!",
              text: "The reply slip has been removed.",
              icon: "success",
            });
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "reply slip not removed",
            });
          }
        });
    }
  });
};

const resetBtn = () => {
  refupreply.value.resetValidation();
  refupdaterep.value.resetValidation();
  state.upreply = null;
  state.updaterep = null;
  state.upreply_reason = null;
};

const resetBtnrep = () => {
  state.reply = null;
  state.daterep = null;
  state.reply_reason = null;
  refreply.value.resetValidation();
  refdaterep.value.resetValidation();
};

// Update the contract

const UpdateContract = (props) => {
  showContractDetails.value = false;
  upContract.value = true;
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
.
