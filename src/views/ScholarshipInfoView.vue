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
                    @click="showContractStats(props)"
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
                    @click="showContractStats(props)"
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

  <q-dialog
    v-model="showContractDetails"
    persistent
    v-if="contract_Status === 'AVAILING'"
  >
    <q-card style="min-width: 500px; width: 600px" class="rounded-borders-20">
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
                <td class="primary-text text-bold">Contract Location:</td>
                <td class="on-surface-text text-bold">
                  {{ contractLoc }}
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
        <q-btn
          v-if="vflag === 1"
          outline
          style="color: goldenrod"
          label="Disallow"
          @click="disAvailing"
        />
        <q-btn
          v-else
          outline
          style="color: goldenrod"
          label="Allow"
          @click="allowAvailing"
        />
        <q-btn
          outline
          style="color: goldenrod"
          label="Delete"
          @click="delContract"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- DEFERRED -->

  <q-dialog
    v-model="showContractDetails"
    persistent
    v-else-if="contract_Status === 'DEFERRED'"
  >
    <q-card style="min-width: 500px; width: 600px" class="rounded-borders-20">
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
              <td
                class="on-surface-text text-bold"
                v-else-if="defform === false"
              >
                NO
              </td>
              <td class="on-surface-text text-bold" v-else>N/A</td>
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
      <q-card-actions align="center">
        <q-btn
          outline
          style="color: goldenrod"
          label="Update"
          @click="UpDeferContract"
        />
        <q-btn
          v-if="vflag === 1"
          outline
          style="color: goldenrod"
          label="Disallow"
          @click="disAvailing"
        />
        <q-btn
          v-else
          outline
          style="color: goldenrod"
          label="Allow"
          @click="allowAvailing"
        />
        <q-btn outline style="color: goldenrod" label="Delete" />
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- DID NOT AVAIL -->

  <q-dialog v-model="showContractDetails" persistent v-else>
    <q-card style="min-width: 500px; width: 600px" class="rounded-borders-20">
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
      <q-card-actions align="center">
        <q-btn
          outline
          style="color: goldenrod"
          label="Update"
          @click="UpDidnotContract"
        />
        <q-btn
          v-if="vflag === 1"
          outline
          style="color: goldenrod"
          label="Disallow"
          @click="disAvailing"
        />
        <q-btn
          v-else
          outline
          style="color: goldenrod"
          label="Allow"
          @click="allowAvailing"
        />
        <q-btn
          outline
          style="color: goldenrod"
          label="Delete"
          @click="delContract"
        />
      </q-card-actions>
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
            <q-btn
              v-if="reply_verified_flag === true"
              outline
              style="color: goldenrod"
              label="Disallow"
              @click="disReply"
            />
            <q-btn
              v-else
              outline
              style="color: goldenrod"
              label="Allow"
              @click="allowReply"
            />
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

  <!-- Avaliling Update Contract  -->

  <q-dialog v-model="upContract" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <form id="SubmitContractForm" @submit.prevent.stop="SubmitContract">
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
              ref="refcntrctStatus"
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
              ref="refavailAward"
              :options="awardOptions"
              v-model="state.availAward"
              name="availAward"
              emit-value
              outlined
              dense
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Other Scholarship</span>
            <q-input
              outlined
              dense
              hide-bottom-space
              v-model="state.upotherScholarship"
              name="upotherScholarship"
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
              clearable
            >
            </q-select>
          </div>
          <div class="q-px-sm">
            <span class="text-bold">Duration</span>
            <q-input
              ref="refupduration"
              outlined
              dense
              hide-bottom-space
              v-model="state.upduration"
              name="upduration"
              type="number"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">ETG Month </span>
            <q-select
              ref="refupetgMonth"
              :options="etgOptions"
              v-model="state.upetgMonth"
              name="upetgMonth"
              emit-value
              outlined
              dense
              use-input
              map-options
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">ETG</span>
            <q-input
              ref="refupetg"
              outlined
              dense
              hide-bottom-space
              v-model="state.upetg"
              name="upetg"
              type="number"
              :rules="[myRule]"
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
              ref="refscid"
              :options="scrTermoptions"
              v-model="state.upscrTerm"
              name="upscrTerm"
              emit-value
              outlined
              dense
              use-input
              map-options
              hide-bottom-space
              :rules="[myRule]"
            />
          </div>
          <div class="q-px-sm">
            <span class="text-bold">SY and Term Started</span>
            <q-select
              ref="refsyid"
              :options="termRecOptions"
              v-model="state.uptermRec"
              name="uptermRec"
              emit-value
              outlined
              dense
              use-input
              map-options
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

        <!-- DID NOT AVAIL UPDATE -->

        <q-card-section v-else-if="state.cntrctStatus === 'DID NOT AVAIL'">
          <form
            id="SubmitDidNotForm"
            @submit.prevent.stop="SubmitDidNotContract"
          >
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
                name="didNotreason"
                filled
                autogrow
                outlined
                dense
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
          </form>
        </q-card-section>

        <!-- Update Deffered -->

        <q-card-section v-else-if="state.cntrctStatus === 'DEFERRED'">
          <form id="SubmitDefForm" @submit.prevent.stop="SubmitDefContract">
            <div class="q-px-sm text-bold">
              <span class="text-bold">With deferment form?</span>
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
              <q-input
                name="updefreason"
                v-model="state.updefreason"
                filled
                autogrow
                outlined
                dense
              />
            </div>

            <div class="q-px-sm">
              <span class="text-bold">School Year Deferred</span>
              <q-select
                ref="refupSyDef"
                outlined
                dense
                hide-bottom-space
                behavior="menu"
                emit-value
                map-options
                use-input
                input-debounce="0"
                v-model="state.upSyDef"
                name="upSyDef"
                :options="syOptions"
                @filter="filtersy"
                :rules="[myRule]"
                mask="#### - ####"
                clearable
              />
            </div>
            <div class="q-px-sm">
              <span class="text-bold">Term Type</span>
              <q-select
                ref="refuptermtype"
                :options="termTypeOptions"
                v-model="state.uptermtype"
                name="uptermtype"
                outlined
                dense
                hide-bottom-space
                emit-value
                use-input
                map-options
                :rules="[myRule]"
              />
            </div>
            <div class="q-px-sm">
              <span class="text-bold">Term Deferred</span>
              <q-select
                ref="refuptermDef"
                :options="computedTermOptions"
                v-model="state.uptermDef"
                name="uptermDef"
                emit-value
                outlined
                dense
                use-input
                map-options
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

// Variable Lists

const showContractDetails = ref(false);

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
const contractLoc = ref();
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
const vflag = ref();

const defVerifiedFlag = ref();
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
const reply_verified_flag = ref();

const refreply = ref(null);
const refdaterep = ref(null);
const refupreply = ref(null);
const refupdaterep = ref(null);

const refcntrctStatus = ref(null);
const refavailAward = ref(null);

const refclocations = ref(null);
const refupduration = ref(null);
const refupetgMonth = ref(null);
const refupetg = ref(null);

const refupSyDef = ref(null);
const refuptermtype = ref(null);
const refuptermDef = ref(null);
const refscid = ref(null);
const refsyid = ref(null);

const state = reactive({
  reply: "",
  daterep: "",
  reply_reason: "",

  upreply: "",
  updaterep: "",
  upreply_reason: "",

  cntrctStatus: "",
  availAward: "",
  upotherScholarship: "",
  clocations: "",
  etgMonth: "",
  etg: "",
  didNotreason: "",
  defreason: "",

  upduration: "",
  upetgMonth: "",
  upetg: "",
  upscrTerm: "",
  uptermRec: "",

  updefreason: "",
  upSyDef: "",
  uptermtype: "",
  uptermDef: "",
});

const columns = [
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
const cntrctStatusoptions = ref();
const etgOptions = ref();
var regoptions2 = [];
const regoptions = ref(regoptions2);
const scrTermoptions = ref("");
const termRecOptions = ref();
var syOptions2 = [];
const syOptions = ref(syOptions2);

const id = ref();

onMounted(() => {
  populateAll();
});

const populateAll = () => {
  id.value = route.params.id;
  var formData = new FormData();
  formData.append("id", id.value);

  // Read Scholars

  axios.post("/read.php?readScholarInfoID", formData).then((response) => {
    rows.value = response.data;
  });

  // Select Replies
  axios.get("/read.php?reply").then((response) => {
    replyoptions.value = response.data;
  });

  // SELECT COntract Status

  axios.get("/read.php?contractStatus").then((response) => {
    cntrctStatusoptions.value = response.data;
  });

  // SELECT ETG Month

  axios.get("/read.php?etgMonth").then((response) => {
    etgOptions.value = response.data;
  });

  // Select Regions

  axios.get("/read.php?region").then((response) => {
    regoptions2 = response.data;
  });

  axios.post("/read.php?readAddSC", formData).then((response) => {
    scrTermoptions.value = response.data;
  });

  axios.post("/read.php?readTermRec", formData).then((response) => {
    termRecOptions.value = response.data;
  });

  axios.get("/read.php?school_years").then((response) => {
    syOptions2 = response.data;
  });
};

// Availed Award
const awardOptions = [
  { label: "BS", value: "BS", color: "primary" },
  { label: "TN", value: "TN", color: "primary" },
  { label: "TL", value: "TL", color: "primary" },
];

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
  return termOptions[state.uptermtype] || [];
});

// Filter Regions
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

// Reply Slip

// const spasReply = ref();

const reply_scholar_id = ref();

const showReply = (props) => {
  showReplies.value = true;

  reply_scholar_id.value = props.row.scholar_id;

  state.upreply = props.row.reply_slip;
  showReply.value = props.row.scholar_id;

  var formData = new FormData();
  formData.append("id", reply_scholar_id.value);

  axios.post("/read.php?readReplyId", formData).then((response) => {
    replySlip.value = response.data.reply_slip;
    datereply.value = response.data.date_reply;
    reply_reason.value = response.data.reason;
    reply_created.value = response.data.created_by;
    reply_updated.value = response.data.updated_by;
    reply_verified.value = response.data.verified_by;
    reply_verified_flag.value = response.data.verified_flag;

    state.updaterep = response.data.date_reply;
    state.upreply_reason = response.data.reason;
  });
};

// Add New Reply

const add_reply_scholarid = ref();

const addReply = (props) => {
  addReplies.value = true;
  add_reply_scholarid.value = props.row.scholar_id;
};

const CreateReply = () => {
  refreply.value.validate();
  refdaterep.value.validate();
  console.log(add_reply_scholarid.value);

  if (refreply.value.hasError || refdaterep.value.hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    var formData = new FormData(document.getElementById("ReplyForm"));

    formData.append("scholarid", add_reply_scholarid.value);
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
          populateAll();
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

    formData.append("upscholarid", showReply.value);
    formData.append("user", user.username);

    axios
      .post("/update.php?updateReplySlip", formData)
      .then(function (response) {
        if (response.data == true) {
          updateAlertReply();
          updateReplies.value = false;
          populateAll();
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
  showReplies.value = false;
  var formData = new FormData(document.getElementById("DForm"));
  formData.append("delScholarid", showReply.value);

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
            populateAll();
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

// Disallow Reply

const disReply = () => {
  showReplies.value = false;

  var formData = new FormData();

  formData.append("scholarid", showReply.value);
  formData.append("user", user.username);

  axios.post("/update.php?disReplySlip", formData).then(function (response) {
    if (response.data == true) {
      Swal.fire({
        icon: "error",
        title: "Disallowed",
      });
      populateAll();
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to disallow reply Slip",
      });
    }
  });
};

// Allow Reply

const allowReply = () => {
  showReplies.value = false;

  var formData = new FormData();

  formData.append("scholarid", showReply.value);
  formData.append("user", user.username);

  axios.post("/update.php?allowReplySlip", formData).then(function (response) {
    if (response.data == true) {
      Swal.fire({
        title: "Success!",
        text: "Reply Slip Updated.",
        icon: "success",
      });
      populateAll();
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to allow reply Slip",
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

// Contract Codes Here

// Availing

const contract_Status = ref();
const contract_scholarid = ref();

const showContractStats = (props) => {
  showContractDetails.value = true;
  contract_scholarid.value = props.row.scholar_id;

  contract_Status.value = props.row.contract_status;

  var formData = new FormData();
  formData.append("scholarid", contract_scholarid.value);
  //
  axios.post("/read.php?readSCID", formData).then((response) => {
    // Availing Status
    contractStats.value = response.data.contract_status;
    avail.value = response.data.avail_award;
    otherScholarship.value = response.data.other_schp;
    contractLoc.value = response.data.contract_loc;
    duration.value = response.data.duration;
    vflag.value = response.data.v_flag;

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
    reason.value = response.data.reason;
    defform.value = response.data.with_deferment_form;
    defreason.value = response.data.defer_reason;
    sydef.value = response.data.sy_deferred;
    termTypeDef.value = response.data.defer_type;
    termDef.value = response.data.term_deferred;
    defVerifiedFlag.value = response.data.verified_flag;
  });
};

// Update the contract

const UpdateContract = () => {
  console.log(contract_scholarid.value);
  showContractDetails.value = false;
  upContract.value = true;
  state.cntrctStatus = contractStats.value;
  state.availAward = avail.value;
  state.upotherScholarship = otherScholarship.value;
  state.clocations = contractLoc.value;
  state.upduration = duration.value;
  state.upetgMonth = etgMonth.value;
  state.upetg = etg.value;
  scholarDefer.value = scdefbef.value === 1 ? "YES" : "NO";
  // state.upscrTerm =
  //   school.value + ", " + course.value + " (Start " + scYearAvail.value + ")";
};

const SubmitContract = () => {
  console.log(contract_scholarid.value);
  refcntrctStatus.value.validate();
  refavailAward.value.validate();
  refclocations.value.validate();
  refupduration.value.validate();
  refupetgMonth.value.validate();
  refupetg.value.validate();
  refscid.value.validate();
  refsyid.value.validate();

  if (
    refcntrctStatus.value.hasError ||
    refavailAward.value.hasError ||
    refclocations.value.hasError ||
    refupduration.value.hasError ||
    refupetgMonth.value.hasError ||
    refupetg.value.hasError ||
    refscid.value.hasError ||
    refsyid.value.hasError
  ) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    upContract.value = false;
    var formData = new FormData(document.getElementById("SubmitContractForm"));

    formData.append("user", user.username);
    formData.append("scholarid", contract_scholarid.value);
    formData.append("scholarDefer", scholarDefer.value);

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
          .post("/update.php?updateContract", formData)
          .then(function (response) {
            if (response.data == true) {
              populateAll();
              Swal.fire("Saved!", "", "success");
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to update Contract",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

const UpDeferContract = () => {
  console.log(contract_scholarid.value);
  upContract.value = true;
  showContractDetails.value = false;
  state.cntrctStatus = contractStats.value;
  // Deferment
  defscholarDefer.value = defform.value === true ? "YES" : "NO";
  state.updefreason = defreason.value;
  state.upSyDef = sydef.value;
  state.uptermtype = termTypeDef.value;
  state.uptermDef = termDef.value;
  statsLatest.value = defVerifiedFlag.value === true ? "YES" : "NO";
};

const SubmitDefContract = () => {
  refupSyDef.value.validate();
  refuptermtype.value.validate();
  refuptermDef.value.validate();

  if (
    refupSyDef.value.hasError ||
    refuptermtype.value.hasError ||
    refuptermDef.value.hasError
  ) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all the required fields.",
    });
  } else {
    upContract.value = false;
    var formData = new FormData(document.getElementById("SubmitContractForm"));

    formData.append("user", user.username);
    formData.append("scholarid", contract_scholarid.value);
    formData.append("defscholarDefer", defscholarDefer.value);
    formData.append("statsLatest", statsLatest.value);
    formData.append("recActive", recActive.value);

    formData.append("updefreason", state.updefreason);
    formData.append("upSyDef", state.upSyDef);
    formData.append("uptermtype", state.uptermtype);
    formData.append("uptermDef", state.uptermDef);

    Swal.fire({
      title: "Do you want to save the changes?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Save",
      denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios.post("/update.php?updateDef", formData).then(function (response) {
          if (response.data == true) {
            populateAll();
            Swal.fire("Saved!", "", "success");
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to update Contract",
            });
          }
        });
        axios
          .post("/update.php?updateDefContract", formData)
          .then(function (response) {
            if (response.data == true) {
              populateAll();
              Swal.fire("Saved!", "", "success");
            } else {
              $q.notify({
                color: "red",
                textColor: "white",
                message: "Failed to update Contract",
              });
            }
          });
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }
};

const UpDidnotContract = () => {
  upContract.value = true;
  showContractDetails.value = false;
  state.cntrctStatus = contractStats.value;
  didNotscholarDefer.value = scdefbef.value === 1 ? "YES" : "NO";
  state.didNotreason = reason.value;
};

const SubmitDidNotContract = () => {
  upContract.value = false;

  var formData = new FormData(document.getElementById("SubmitDidNotForm"));

  formData.append("user", user.username);
  formData.append("scholarid", contract_scholarid.value);
  formData.append("didNotscholarDefer", didNotscholarDefer.value);
  formData.append("cntrctStatus", state.cntrctStatus);

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
        .post("/update.php?updateDidNotAvail", formData)
        .then(function (response) {
          if (response.data == true) {
            populateAll();
            Swal.fire("Saved!", "", "success");
          } else {
            $q.notify({
              color: "red",
              textColor: "white",
              message: "Failed to update Contract",
            });
          }
        });
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
};

// Delete Contract

const delContract = () => {
  // console.log(spasid.value);
  showContractDetails.value = false;
  var formData = new FormData();
  formData.append("delScholarid", contract_scholarid.value);

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
      axios.post("/delete.php?delContract", formData).then(function (response) {
        if (response.data == true) {
          populateAll();
          Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "Failed to update Contract",
          });
        }
      });
    }
  });
};

// Disallow Availing

const disAvailing = () => {
  showContractDetails.value = false;

  var formData = new FormData();

  formData.append("user", user.username);
  formData.append("scholarid", contract_scholarid.value);

  axios
    .post("/update.php?disallowAvailing", formData)
    .then(function (response) {
      if (response.data == true) {
        populateAll();
        Swal.fire({
          icon: "error",
          title: "Disallowed",
        });
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to update Contract",
        });
      }
    });
};

// Allow Availing

const allowAvailing = () => {
  showContractDetails.value = false;

  var formData = new FormData();

  formData.append("user", user.username);
  formData.append("scholarid", contract_scholarid.value);

  axios.post("/update.php?allowAvailing", formData).then(function (response) {
    if (response.data == true) {
      Swal.fire({
        title: "Success!",
        text: "Allowed Contract Status Updated.",
        icon: "success",
      });
      populateAll();
    } else {
      $q.notify({
        color: "red",
        textColor: "white",
        message: "Failed to allow reply Slip",
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
.
