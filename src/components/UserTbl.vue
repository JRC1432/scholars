<template>
  <q-table
    flat
    bordered
    ref="tableRef"
    title="Treats"
    :rows="rows"
    :columns="columns"
    row-key="id"
    v-model:pagination="pagination"
    :loading="loading"
    :filter="filter"
    binary-state-sort
    @request="onRequest"
    class="rounded-borders-20 no-border custom-table"
  >
    <template v-slot:top-left>
      <q-btn
        color="primary"
        size="10px"
        no-caps
        round
        icon="add"
        @click="newUser = true"
      >
        <q-tooltip class="bg-primary">Add user list</q-tooltip>
      </q-btn>
      <div class="q-ml-sm">
        <q-btn
          color="primary"
          size="10px"
          no-caps
          round
          icon="dynamic_feed"
          @click="batchUpload = true"
        >
          <q-tooltip class="bg-primary">Batch Upload</q-tooltip>
        </q-btn>
      </div>
      <div class="q-ml-sm">
        <q-btn
          color="primary"
          size="10px"
          no-caps
          round
          icon="download"
          tag="a"
          href="http://localhost/scholars/scholars_backend/upload/Staff_Rec.csv"
          target="_blank"
        >
          <q-tooltip class="bg-primary"
            >Download Staff Records Template</q-tooltip
          >
        </q-btn>
      </div>
    </template>
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
      <q-tr :prop="props" @click="showUpdateUser(props)"
        ><q-td key="internal_id" :props="props">
          {{ props.row.internal_id }}
        </q-td>
        <q-td key="username" :props="props">
          <q-badge color="light-green-4" :label="props.value">
            {{ props.row.username }}
          </q-badge>
        </q-td>
        <q-td key="last_name" :props="props">
          {{ props.row.last_name }}
        </q-td>
        <q-td key="first_name" :props="props">
          {{ props.row.first_name }}
        </q-td>
        <q-td key="sex" :props="props">
          {{ props.row.sex }}
        </q-td>
        <q-td key="email" :props="props">
          {{ props.row.email }}
        </q-td>
        <q-td key="contact_no" :props="props">
          {{ props.row.contact_no }}
        </q-td>
        <q-td key="region" :props="props">
          {{ props.row.region }}
        </q-td>
        <q-td key="work_region" :props="props">
          {{ props.row.work_region }}
        </q-td>
      </q-tr>
    </template>
  </q-table>

  <!-- New User -->

  <q-dialog v-model="newUser" persistent>
    <q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
      <q-toolbar>
        <IconUserPlus :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">NEW</span> User
          Profile</q-toolbar-title
        >

        <q-btn flat round dense icon="close" @click="CloseBtn" />
      </q-toolbar>
      <form id="UserForm" @submit.prevent.stop="CreateUser">
        <q-stepper
          class="rounded-borders-20"
          v-model="step"
          ref="stepper"
          alternative-labels
          color="primary"
          flat
          animated
        >
          <!-- Stepper 1 -->
          <q-step
            :name="1"
            title="Personal Informations"
            icon="person"
            :done="step > 1"
          >
            <q-scroll-area style="height: 600px; max-width: 800px">
              <div class="text-h6">Personal Informartions</div>
              <div class="q-pa-md">
                <div class="row row_width q-col-gutter-xs">
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Staff ID</span>
                      <q-input
                        ref="refstaff"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.staffid"
                        name="staffid"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">First Name</span>
                      <q-input
                        ref="reffname"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.fname"
                        name="fname"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Middle Name</span>
                      <q-input
                        ref="refmname"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.mname"
                        name="mname"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Last Name</span>
                      <q-input
                        ref="reflname"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.lname"
                        name="lname"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Suffix Name</span>
                      <q-input
                        ref="refsname"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.sname"
                        name="sname"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">SEX </span>
                      <q-select
                        ref="refsex"
                        :options="sexoptions"
                        v-model="state.gender"
                        emit-value
                        name="gender"
                        outlined
                        dense
                        hide-bottom-space
                        :rules="[myRule]"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Date of Birth</span>
                      <q-input
                        ref="refbirth"
                        outlined
                        dense
                        type="date"
                        hide-bottom-space
                        v-model="state.birth"
                        name="birth"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Place of Birth</span>
                      <q-input
                        ref="refpob"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.pob"
                        name="pob"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Work Region</span>

                      <q-select
                        ref="refwregion"
                        outlined
                        dense
                        hide-bottom-space
                        behavior="menu"
                        emit-value
                        map-options
                        use-input
                        input-debounce="0"
                        v-model="state.wregion"
                        name="wregion"
                        :options="regoptions"
                        @filter="filterregion"
                        :rules="[myRule]"
                        clearable
                      >
                      </q-select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">School Code</span>
                      <q-input
                        ref="refscCode"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.scCode"
                        name="scCode"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-h6">Address</div>

              <div class="q-pa-md">
                <div class="row row_width q-col-gutter-xs">
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Select Province:</span>

                      <q-select
                        ref="rfprovinceZip"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="provinceZip"
                        name="provinceZip"
                        emit-value
                        map-options
                        use-input
                        clearable
                        input-debounce="0"
                        :options="zipOption"
                        @filter="filterZip"
                        behavior="menu"
                        @update:model-value="populateaddress"
                        :rules="[myRule]"
                      >
                        <template v-slot:no-option>
                          <q-item>
                            <q-item-section class="text-grey">
                              No results
                            </q-item-section>
                          </q-item>
                        </template>
                      </q-select>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Street</span>
                      <q-input
                        ref="refstreet"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.street"
                        name="street"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Village</span>
                      <q-input
                        ref="refvillage"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.village"
                        name="village"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Barangay</span>
                      <q-input
                        ref="refBrgy"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.barangay"
                        name="barangay"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Municipality</span>
                      <q-input
                        readonly
                        ref="refmun"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.municipality"
                        name="municipality"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Province</span>
                      <q-input
                        readonly
                        ref="refprov"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.province"
                        name="province"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Region</span>
                      <q-input
                        readonly
                        ref="refreg"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.region"
                        name="region"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">District</span>
                      <q-input
                        readonly
                        ref="refdist"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.district"
                        name="district"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">ZipCode</span>
                      <q-input
                        readonly
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.zipcode"
                        name="zipcode"
                      />
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Email</span>
                      <q-input
                        ref="refmail"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.mail"
                        name="mail"
                        :rules="[emailRule]"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Contact No.</span>
                      <q-input
                        ref="refcontact"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.contact"
                        name="contact"
                        mask="(####) ### - ####"
                        hint="(####) ### - ####"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <q-stepper-navigation>
                <q-btn @click="step1" color="primary" label="Continue" />
              </q-stepper-navigation>
            </q-scroll-area>
          </q-step>

          <!-- Stepper 2 -->
          <q-step
            :name="2"
            title="Account Information Deatils"
            icon="manage_accounts"
            :done="step > 2"
          >
            <div class="q-pa-md">
              <div class="row row_width q-col-gutter-xs">
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Internal ID</span>
                    <q-input
                      ref="refId"
                      outlined
                      dense
                      hide-bottom-space
                      v-model="state.intid"
                      name="intid"
                      :rules="inputRules"
                    />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">UserName</span>
                    <q-input
                      ref="refUsername"
                      outlined
                      dense
                      hide-bottom-space
                      v-model="state.usernames"
                      name="usname"
                      :rules="[checkUsernames, maxLength]"
                      :debounce="1000"
                      no-error-icon
                    />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Password</span>
                    <q-input
                      ref="refPassword"
                      outlined
                      dense
                      hide-bottom-space
                      :type="isPwds ? 'password' : 'text'"
                      v-model="state.password"
                      name="password"
                      :rules="inputpassRules"
                      @input="validatePassword"
                    >
                      <template v-slot:append>
                        <q-icon
                          :name="isPwds ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="isPwds = !isPwds"
                        />
                      </template>
                    </q-input>
                    <PasswordMeter
                      @score="onScore"
                      :password="state.password"
                    />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Confirm Password</span>
                    <q-input
                      ref="refConfPassword"
                      outlined
                      dense
                      hide-bottom-space
                      :type="isPwd ? 'password' : 'text'"
                      v-model="state.confirmpassword"
                      name="confirmpassword"
                      :rules="inputpassRules"
                      :error="confirmpass"
                      color="green"
                    >
                      <template v-slot:append>
                        <q-icon
                          :name="isPwd ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="isPwd = !isPwd"
                        />
                      </template>
                    </q-input>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Account Type</span>
                    <q-select
                      ref="refActType"
                      outlined
                      dense
                      hide-bottom-space
                      behavior="menu"
                      emit-value
                      map-options
                      use-input
                      input-debounce="0"
                      v-model="state.acttype"
                      name="acttype"
                      :options="actoptions"
                      @filter="filteracnt"
                      :rules="[myRule]"
                      clearable
                    >
                    </q-select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Regions</span>
                    <q-select
                      ref="refRegion"
                      outlined
                      dense
                      hide-bottom-space
                      behavior="menu"
                      emit-value
                      map-options
                      use-input
                      input-debounce="0"
                      v-model="state.regions"
                      name="regions"
                      :options="regoptions"
                      @filter="filterregion"
                      :rules="[myRule]"
                      clearable
                    >
                    </q-select>
                  </div>
                </div>
              </div>
            </div>
            <q-stepper-navigation>
              <q-btn color="primary" label="Submit" type="submit" />

              <q-btn
                flat
                @click="step = 1"
                color="primary"
                label="Back"
                class="q-ml-sm"
              />
            </q-stepper-navigation>
          </q-step>
        </q-stepper>
      </form>
    </q-card>
  </q-dialog>

  <!-- Batch Upload -->

  <q-dialog v-model="batchUpload" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconFileTypeCsv :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">CSV</span> Users Batch
          Upload</q-toolbar-title
        >

        <q-btn flat round dense icon="close" v-close-popup />
      </q-toolbar>

      <q-card-section>
        <q-form id="batchuploadForm" @submit.prevent.stop="batchUp">
          <q-card class="my-card rounded-borders-20">
            <q-card-section class="bg-primary text-white">
              <div class="text-h6">Upload Your File Here</div>
              <div class="text-subtitle2">Only CSV Documents are Allowed</div>
            </q-card-section>
            <div class="q-pa-md">
              <q-file
                ref="refBulkUpload"
                filled
                v-model="batchUploadUsers"
                name="batchUploadUsers"
                label="*CSV FILES ONLY"
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
          </q-card>
          <br />
          <div class="row justify-center">
            <q-btn
              rounded
              type="submit"
              label="Upload"
              color="primary"
              style="width: 80%"
            />
          </div>
        </q-form>
      </q-card-section>

      <q-separator />
    </q-card>
  </q-dialog>

  <!-- Update User Profile -->

  <q-dialog v-model="showedit" persistent>
    <q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
      <q-toolbar>
        <IconUserEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">UPDATE</span> Staff
          Profile</q-toolbar-title
        >

        <q-btn flat round dense icon="close" @click="CloseEditBtn" />
      </q-toolbar>
      <q-tabs
        v-model="tab"
        dense
        class="text-grey"
        active-color="primary"
        indicator-color="primary"
        align="left"
        narrow-indicator
      >
        <q-tab name="user" label="User Account informations" />
        <q-tab name="personal" label="Personal Informations" />
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="user">
          <div class="text-h6">User Account Informations</div>
          <form id="updateUserForm" @submit.prevent.stop="UpdateUser">
            <div class="q-pa-md">
              <div class="row row_width q-col-gutter-xs">
                <div class="col-xs-12 col-sm-6 col-md-4">
                  <div class="q-px-sm">
                    <span class="text-bold">Internal ID</span>
                    <q-input
                      ref="refUpId"
                      outlined
                      dense
                      hide-bottom-space
                      v-model="state.upintid"
                      name="intid"
                      :rules="inputRules"
                    />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                  <div class="q-px-sm">
                    <span class="text-bold">Account Type</span>
                    <q-select
                      ref="refUpActType"
                      outlined
                      dense
                      hide-bottom-space
                      behavior="menu"
                      emit-value
                      map-options
                      use-input
                      input-debounce="0"
                      v-model="state.upacttype"
                      name="acttype"
                      :options="actoptions"
                      @filter="filteracnt"
                      :rules="[myRule]"
                    >
                    </q-select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                  <div class="q-px-sm">
                    <span class="text-bold">School Code</span>
                    <q-input
                      readonly
                      outlined
                      dense
                      hide-bottom-space
                      v-model="state.upcode"
                      name="upcode"
                    />
                  </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-12">
                  <div class="q-px-sm">
                    <span class="text-bold">UserName</span>
                    <q-input
                      ref="refUpUsername"
                      outlined
                      dense
                      hide-bottom-space
                      v-model="state.upusernames"
                      name="usname"
                      :rules="[checkUsername, maxLength]"
                      :debounce="1000"
                      no-error-icon
                    />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Password</span>
                    <q-input
                      ref="refUpPassword"
                      outlined
                      dense
                      hide-bottom-space
                      :type="upisPwds ? 'password' : 'text'"
                      v-model="state.uppassword"
                      name="password"
                      :rules="inputpassRules"
                      @input="validatePassword"
                    >
                      <template v-slot:append>
                        <q-icon
                          :name="upisPwds ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="upisPwds = !upisPwds"
                        />
                      </template>
                    </q-input>
                    <PasswordMeter
                      @score="onScore"
                      :password="state.uppassword"
                    />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Confirm Password</span>
                    <q-input
                      ref="refUpConfPassword"
                      outlined
                      dense
                      hide-bottom-space
                      :type="upisPwd ? 'password' : 'text'"
                      v-model="state.upconfirmpassword"
                      name="confirmpassword"
                      :rules="inputpassRules"
                      :error="upconfirmpass"
                      color="green"
                    >
                      <template v-slot:append>
                        <q-icon
                          :name="upisPwd ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="upisPwd = !upisPwd"
                        />
                      </template>
                    </q-input>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">Regions</span>
                    <q-select
                      ref="refUpRegion"
                      outlined
                      dense
                      hide-bottom-space
                      behavior="menu"
                      emit-value
                      map-options
                      use-input
                      input-debounce="0"
                      v-model="state.upregions"
                      name="upregions"
                      :options="regoptions"
                      @filter="filterregion"
                      :rules="[myRule]"
                    >
                    </q-select>
                  </div>
                </div>
              </div>
            </div>
            <q-card-actions>
              <div class="row fit justify-center">
                <q-btn
                  rounded
                  label="UPDATE"
                  color="primary"
                  type="submit"
                  class="q-mb-sm"
                  style="width: 80%"
                />
              </div>
            </q-card-actions>
          </form>
          <form id="DelUserForm" @submit.prevent.stop="DelStaffInfo">
            <q-card-actions class="row fit justify-center q-pt-xs">
              <q-btn
                rounded
                style="width: 80%"
                label="REMOVE THIS USER"
                color="negative"
                type="submit"
                class="q-mb-sm"
              />
            </q-card-actions>
          </form>
        </q-tab-panel>

        <q-tab-panel name="personal">
          <form id="UpdateUserInfoForm" @submit.prevent.stop="UpdateStaffInfo">
            <div class="text-h6">Personal Informartions</div>
            <q-card-section class="q-pt-none">
              <q-scroll-area style="height: 600px; max-width: 800px">
                <div class="q-pa-md">
                  <div class="row row_width q-col-gutter-xs">
                    <div class="col-xs-12">
                      <div class="q-px-sm">
                        <span class="text-bold">Staff ID</span>
                        <q-input
                          ref="refUpstaff"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upstaffid"
                          name="upstaffid"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">First Name</span>
                        <q-input
                          ref="refUpfname"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upfname"
                          name="upfname"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Middle Name</span>
                        <q-input
                          ref="refUpmname"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upmname"
                          name="upmname"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Last Name</span>
                        <q-input
                          ref="refUplname"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.uplname"
                          name="uplname"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Suffix Name</span>
                        <q-input
                          ref="refUpsname"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upsname"
                          name="upsname"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">SEX </span>
                        <q-select
                          emit-value
                          :options="sexoptions"
                          v-model="state.upgender"
                          name="upgender"
                          outlined
                          dense
                          hide-bottom-space
                          :rules="[myRule]"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Date of Birth</span>
                        <q-input
                          ref="refUpbirth"
                          outlined
                          dense
                          type="date"
                          hide-bottom-space
                          v-model="state.upbirth"
                          name="upbirth"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Place of Birth</span>
                        <q-input
                          ref="refUppob"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.uppob"
                          name="uppob"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Work Region</span>

                        <q-select
                          ref="refUpwregion"
                          outlined
                          dense
                          hide-bottom-space
                          behavior="menu"
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          v-model="state.upwregion"
                          name="upwregion"
                          :options="regoptions"
                          @filter="filterregion"
                          :rules="[myRule]"
                        >
                        </q-select>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">School Code</span>
                        <q-input
                          ref="refUpscCode"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upscCode"
                          name="upscCode"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-h6">Address</div>

                <div class="q-pa-md">
                  <div class="row row_width q-col-gutter-xs">
                    <div class="col-xs-12">
                      <div class="q-px-sm">
                        <span class="text-bold">Select Province:</span>

                        <q-select
                          ref="refUpzipcode"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="upzipid"
                          name="upzipid"
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          label="Select Province"
                          :options="zipOption"
                          @filter="filterZip"
                          behavior="menu"
                          @update:model-value="populateUpAddress"
                        >
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Street</span>
                        <q-input
                          ref="refUpstreet"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upstreet"
                          name="upstreet"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Village</span>
                        <q-input
                          ref="refUpvillage"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upvillage"
                          name="upvillage"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Barangay</span>
                        <q-input
                          ref="refUpBrgy"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upbarangay"
                          name="upbarangay"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Municipality</span>
                        <q-input
                          ref="refUpmun"
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upmunicipality"
                          name="upmunicipality"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Province</span>
                        <q-input
                          ref="refUpprov"
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upprovince"
                          name="upprovince"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Region</span>
                        <q-input
                          ref="refUpreg"
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upregion"
                          name="upregion"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">District</span>
                        <q-input
                          ref="refUpdist"
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.updistrict"
                          name="updistrict"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">ZipCode</span>
                        <q-input
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upzipcode"
                          name="upzipcode"
                        />
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Email</span>
                        <q-input
                          ref="refUpmail"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upmail"
                          name="upmail"
                          :rules="[emailRule]"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="q-px-sm">
                        <span class="text-bold">Contact No.</span>
                        <q-input
                          ref="refUpcontact"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upcontact"
                          name="upcontact"
                          mask="(####) ### - ####"
                          hint="(####) ### - ####"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </q-scroll-area>
            </q-card-section>
            <q-card-actions>
              <div class="row fit justify-center">
                <q-btn
                  rounded
                  label="UPDATE"
                  color="primary"
                  type="submit"
                  class="q-mb-sm"
                  style="width: 80%"
                />
              </div>
            </q-card-actions>
          </form>
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-dialog>
</template>
<script setup>
import { ref, onMounted, reactive, inject, computed } from "vue";
import { useQuasar } from "quasar";
import {
  IconUserEdit,
  IconUserCancel,
  IconSquareRoundedX,
  IconUserMinus,
  IconUserPlus,
  IconFileTypeCsv,
  IconNfcOff,
} from "@tabler/icons-vue";
import Swal from "sweetalert2";
import PasswordMeter from "vue-simple-password-meter";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

// Items Variable

const originalRows = ref([]);
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const pagination = ref({
  descending: false,
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 10,
});

const batchUpload = ref(false);
const batchUploadUsers = ref(null);
const newUser = ref(false);
const showedit = ref(false);
const tab = ref("user");
const step = ref(1);
const provinceZip = ref(null);
const upzipid = ref(null);

// Items reference

const refId = ref(null);
const refUsername = ref(null);
const refActType = ref(null);
const refPassword = ref(null);
const refConfPassword = ref(null);
const refRegion = ref(null);

const refBulkUpload = ref(null);

const refUpId = ref(null);
const refUpUsername = ref(null);
const refUpPassword = ref(null);
const refUpConfPassword = ref(null);
const refUpActType = ref(null);
const refUpRegion = ref(null);

const refstaff = ref(null);
const reffname = ref(null);
const refmname = ref(null);
const reflname = ref(null);
const refsname = ref(null);
const refsex = ref(null);
const refbirth = ref(null);
const refpob = ref(null);
const refwregion = ref(null);
const refscCode = ref(null);

const refstreet = ref(null);
const refvillage = ref(null);
const refBrgy = ref(null);
const refmun = ref(null);
const refprov = ref(null);
const refreg = ref(null);
const refdist = ref(null);

const refmail = ref(null);
const refcontact = ref(null);

const refUpstaff = ref(null);
const refUpfname = ref(null);
const refUpmname = ref(null);
const refUplname = ref(null);
const refUpsname = ref(null);
const refUpbirth = ref(null);
const refUppob = ref(null);
const refUpwregion = ref(null);
const refUpscCode = ref(null);

const refUpstreet = ref(null);
const refUpvillage = ref(null);
const refUpBrgy = ref(null);
const refUpmun = ref(null);
const refUpprov = ref(null);
const refUpreg = ref(null);
const refUpdist = ref(null);
const refUpzipcode = ref(null);
const refUpmail = ref(null);
const refUpcontact = ref(null);
const rfprovinceZip = ref(null);

// Match Passwords
const isPwd = ref(true);
const isPwds = ref(true);
const upisPwd = ref(true);
const upisPwds = ref(true);
const confirmpass = computed(() => state.password !== state.confirmpassword);
const upconfirmpass = computed(
  () => state.uppassword !== state.upconfirmpassword
);

// Rules & Validations
const inputRules = [
  (val) => (val && val.length > 0) || "Please type something",
];

const inputNumRules = [
  (val) => (val && val.length > 0) || "Please type numbers only",
];

// Function to validate password

// Validation rules
const errorMessage = ref("");
const inputpassRules = [
  (val) => (val && val.length > 0) || "Please type something",
  (val) => val.length >= 8 || "Password must be at least 8 characters long",
  (val) => score.value > 0 || "Use a better password",
];

const validatePassword = () => {
  for (const rule of inputpassRules) {
    const result = rule(state.password);
    if (result !== true) {
      errorMessage.value = result;
      return;
    }
  }
  errorMessage.value = "";
};

const score = ref(null);

const onScore = (payload) => {
  console.log(payload.score); // from 0 to 4
  console.log(payload.strength); // one of : 'risky', 'guessable', 'weak', 'safe' , 'secure'
  score.value = payload.score;
};

const myRule = (val) => {
  if (val === null || val === undefined || val === "") {
    return "You must make a selection!";
  }
  return true;
};

const fileRules = (val) => {
  if (val === null) {
    return "Please Select a File!";
  }
  return true;
};

function maxLength(val) {
  return val.length >= 6 || "Please use maximum of 6 characters";
}

const emailRule = (val) => {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(val) || "Please enter a valid email address";
};

// Validation for Usernames for Create

const checkUsernames = async (value) => {
  const formData = new FormData(document.getElementById("UserForm"));
  formData.append("usernames", state.usernames);
  try {
    const response = await axios.post("/read.php?checkUser", formData);
    if (response.data === true) {
      // Do something if username is available
    } else {
      return new Promise((resolve) => {
        setTimeout(() => {
          resolve("This username is already been taken!!!");
        }, 1500);
      });
    }
  } catch (error) {
    // Handle any errors
    console.error("Error:", error);
  }
};

const checkUsername = async (value) => {
  const formData = new FormData(document.getElementById("updateUserForm"));
  formData.append("usernames", state.upusernames);
  try {
    const response = await axios.post("/read.php?checkUser", formData);
    if (response.data === true) {
      // Do something if username is available
    } else {
      return new Promise((resolve) => {
        setTimeout(() => {
          resolve("This username is already been taken!!!");
        }, 1500);
      });
    }
  } catch (error) {
    // Handle any errors
    console.error("Error:", error);
  }
};

// @state v-model
const state = reactive({
  id: "",
  intid: "",
  usernames: "",
  password: "",
  confirmpassword: "",
  acttype: "",
  regions: "",

  staffid: "",
  fname: "",
  mname: "",
  lname: "",
  sname: " ",
  gender: "",
  birth: "",
  pob: "",
  wregion: "",
  scCode: "",

  street: "",
  village: "",
  barangay: "",
  municipality: "",
  province: "",
  region: "",
  district: "",
  zipcode: "",
  mail: "",
  contact: "",

  upintid: "",
  upusernames: "",
  uppassword: "",
  upconfirmpassword: "",
  upacttype: "",
  upregions: "",
  upcode: "",

  upstaffid: "",
  upfname: "",
  upmname: "",
  uplname: "",
  upsname: " ",
  upgender: "",
  upbirth: "",
  uppob: "",
  upwregion: "",
  upscCode: "",

  upstreet: "",
  upvillage: "",
  upbarangay: "",
  upmunicipality: "",
  upprovince: "",
  upregion: "",
  updistrict: "",
  upzipcode: "",

  upmail: "",
  upcontact: "",
});

// SELECT OPTIONS
const sexoptions = [
  { label: "Male", value: "M", color: "primary" },
  { label: "Female", value: "F", color: "primary" },
];

const columns = [
  {
    name: "internal_id",
    required: true,
    label: "Internal ID",
    align: "left",
    field: "internal_id",
    sortable: true,
  },
  {
    name: "username",
    required: true,
    label: "UserName",
    align: "left",
    field: "username",
    sortable: true,
  },
  {
    name: "last_name",
    align: "center",
    label: "Last Name",
    field: "last_name",
    sortable: true,
  },
  {
    name: "first_name",
    align: "left",
    label: "First Name",
    field: "first_name",
    sortable: true,
  },
  { name: "sex", align: "left", label: "SEX", field: "sex", sortable: true },
  {
    name: "email",
    align: "left",
    label: "Email",
    field: "email",
    sortable: true,
  },
  {
    name: "contact_no",
    align: "left",
    label: "Contact Number",
    field: "contact_no",
    sortable: true,
  },
  {
    name: "region",
    align: "left",
    label: "Region",
    field: "region",
    sortable: true,
  },
  {
    name: "work_region",
    align: "left",
    label: "Work Region",
    field: "work_region",
    sortable: true,
  },
];

const CloseBtn = () => {
  newUser.value = false;
  state.intid = "";
  state.usernames = "";
  state.password = "";
  state.confirmpassword = "";
  state.acttype = "";
  state.regions = "";
};
const CloseEditBtn = () => {
  showedit.value = false;
};

// Sweet Alerts

const showalert = () => {
  let timerInterval;
  Swal.fire({
    title: "Creating New User!",
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

const batchUplAlert = () => {
  const notif = $q.notify({
    group: false, // required to be updatable
    timeout: 0, // we want to be in control when it gets dismissed
    spinner: true,
    message: "Uploading file...",
    caption: "0%",
  });

  // we simulate some progress here...
  let percentage = 0;
  const interval = setInterval(() => {
    percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

    // we update the dialog
    notif({
      caption: `${percentage}%`,
    });

    // if we are done...
    if (percentage === 100) {
      notif({
        icon: "done", // we add an icon
        spinner: false, // we reset the spinner setting so the icon can be displayed
        message: "Uploading done!",
        timeout: 2500, // we will timeout it in 2.5s
      });
      $q.notify({
        type: "positive",
        message: "The file has been uploaded successfully.",
        position: "top-right",
      });
      readusers();
      clearInterval(interval);
    }
  }, 500);
};

const upUserAlert = () => {
  let timerInterval;
  Swal.fire({
    title: "Updating User Profile!",
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

// Read Users

const fetchFromServer = (startRow, count, filter, sortBy, descending) => {
  let data = originalRows.value;

  if (filter) {
    data = data.filter((row) =>
      row.username.toLowerCase().includes(filter.toLowerCase())
    );
  }

  if (sortBy) {
    const sortField = sortBy;
    data.sort((a, b) => {
      const aValue = a[sortField];
      const bValue = b[sortField];
      if (aValue === bValue) return 0;
      return (aValue > bValue ? 1 : -1) * (descending ? -1 : 1);
    });
  }

  return data.slice(startRow, startRow + count);
};

const getRowsNumberCount = (filter) => {
  if (!filter) return originalRows.value.length;
  return originalRows.value.filter((row) =>
    row.username.toLowerCase().includes(filter.toLowerCase())
  ).length;
};

const onRequest = (props) => {
  const { page, rowsPerPage, sortBy, descending } = props.pagination;
  const filter = props.filter;

  loading.value = true;

  setTimeout(() => {
    pagination.value.rowsNumber = getRowsNumberCount(filter);

    const fetchCount =
      rowsPerPage === 0 ? pagination.value.rowsNumber : rowsPerPage;
    const startRow = (page - 1) * rowsPerPage;
    const returnedData = fetchFromServer(
      startRow,
      fetchCount,
      filter,
      sortBy,
      descending
    );

    rows.value.splice(0, rows.value.length, ...returnedData);

    pagination.value.page = page;
    pagination.value.rowsPerPage = rowsPerPage;
    pagination.value.sortBy = sortBy;
    pagination.value.descending = descending;

    loading.value = false;
  }, 1500);
};

const readusers = () => {
  axios.get("/read.php?readuser").then((response) => {
    originalRows.value = response.data;
    tableRef.value.requestServerInteraction(); // Ensure this is called after data is fetched
  });
};

const tableRef = ref(null);

onMounted(() => {
  readusers();
});

// Select Account Type
var actoptions2 = [];
const actoptions = ref(actoptions2);

onMounted(() => {
  populateacttype();
});

const populateacttype = () => {
  axios.get("/read.php?acttypes").then((response) => {
    actoptions2 = response.data;
  });
};

const filteracnt = (val, update) => {
  if (val === "") {
    update(() => {
      actoptions.value = actoptions2;
    });
    return;
  }

  update(() => {
    const needle = parseInt(val); // Convert val to integer
    actoptions.value = actoptions2.filter((option) => {
      // Check if option.label is an integer and matches the needle
      return Number.isInteger(option.label) && option.label === needle;
    });
  });
};

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

// Create New User

const step1 = () => {
  refstaff.value.validate();
  reffname.value.validate();
  reflname.value.validate();
  refbirth.value.validate();
  refsex.value.validate();
  refpob.value.validate();
  refwregion.value.validate();
  refstreet.value.validate();

  refmun.value.validate();
  refprov.value.validate();
  refreg.value.validate();
  refdist.value.validate();
  rfprovinceZip.value.validate();
  refmail.value.validate();
  refcontact.value.validate();
  if (
    reffname.value.hasError ||
    reflname.value.hasError ||
    refbirth.value.hasError ||
    refpob.value.hasError ||
    refwregion.value.hasError ||
    refstreet.value.hasError ||
    refmun.value.hasError ||
    refprov.value.hasError ||
    refreg.value.hasError ||
    refdist.value.hasError ||
    refmail.value.hasError ||
    rfprovinceZip.value.hasError ||
    refcontact.value.hasError
  ) {
  } else {
    step.value = 2;
  }
};

const CreateUser = () => {
  refUsername.value.validate();
  refActType.value.validate();
  refPassword.value.validate();
  refConfPassword.value.validate();
  refRegion.value.validate();

  if (
    refUsername.value.hasError ||
    refActType.value.hasError ||
    refPassword.value.hasError ||
    refConfPassword.value.hasError ||
    refRegion.value.hasError
  ) {
  } else {
    var formData = new FormData(document.getElementById("UserForm"));

    // Personal Information Append
    formData.append("staffid", state.staffid);
    formData.append("fname", state.fname);
    formData.append("mname", state.mname);
    formData.append("lname", state.lname);
    formData.append("sname", state.sname);
    formData.append("gender", state.gender);
    formData.append("birth", state.birth);
    formData.append("pob", state.pob);
    formData.append("wregion", state.wregion);
    formData.append("scCode", state.scCode);

    formData.append("street", state.street);
    formData.append("village", state.village);
    formData.append("barangay", state.barangay);
    formData.append("municipality", state.municipality);
    formData.append("province", state.province);
    formData.append("region", state.region);
    formData.append("district", state.district);
    formData.append("zip", provinceZip.value);
    formData.append("zipcode", state.zipcode);
    formData.append("mail", state.mail);
    formData.append("contact", state.contact);

    axios.post("/create.php?createuser", formData).then(function (response) {
      if (response.data == true) {
        state.intid = "";
        state.usernames = "";
        state.password = "";
        state.confirmpassword = "";
        state.acttype = "";
        state.regions = "";

        newUser.value = false;
        showalert();
        readusers();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to create new user",
        });
      }
    });
  }
};

// Batch Upload code

const batchUp = () => {
  refBulkUpload.value.validate();

  if (refBulkUpload.value.hasError) {
    // Error Here
  } else {
    var formData = new FormData(document.getElementById("batchuploadForm"));

    formData.append("usercreator", user.username);
    formData.append("authid", user.id);

    axios.post("/create.php?batchUploads", formData).then(function (response) {
      if (response.data == true) {
        batchUpload.value = false;
        batchUplAlert();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "Failed to upload user lists.",
        });
      }
    });
  }
};

const showUpdateUser = (props) => {
  showedit.value = true;
  state.upintid = props.row.internal_id;
  state.upusernames = props.row.username;
  state.upacttype = props.row.account_type;
  state.upregions = props.row.uregion;
  state.upcode = props.row.uscode;

  state.id = props.row.id;

  state.upstaffid = props.row.staff_id;
  state.upfname = props.row.first_name;
  state.upmname = props.row.middle_name;
  state.uplname = props.row.last_name;
  state.upsname = props.row.suffix_name;
  state.upgender = props.row.sex;
  state.upbirth = props.row.dob;
  state.uppob = props.row.pob;
  state.upwregion = props.row.work_region;
  state.upscCode = props.row.srscode;

  state.upstreet = props.row.street;
  state.upvillage = props.row.village;
  state.upbarangay = props.row.barangay;
  state.upmunicipality = props.row.municipality;
  state.upprovince = props.row.province;
  state.upregion = props.row.srregion;
  state.updistrict = props.row.district;
  // upzipid.value = props.row.zip_id;
  state.upzipcode = props.row.zipcode;

  state.upmail = props.row.email;
  state.upcontact = props.row.contact_no;
};

const UpdateUser = () => {
  refUpId.value.validate();
  refUpUsername.value.validate();
  refUpPassword.value.validate();
  refUpConfPassword.value.validate();
  refUpActType.value.validate();
  refUpRegion.value.validate();

  if (
    refUpId.value.hasError ||
    refUpUsername.value.hasError ||
    refUpPassword.value.hasError ||
    refUpConfPassword.value.hasError ||
    refUpActType.value.hasError ||
    refUpRegion.value.hasError
  ) {
  } else {
    var formData = new FormData(document.getElementById("updateUserForm"));

    formData.append("upintid", state.upintid);
    formData.append("upusernames", state.upusernames);
    formData.append("uppassword", state.uppassword);
    formData.append("upacttype", state.upacttype);
    formData.append("upregions", state.upregions);

    formData.append("id", state.id);

    axios.post("/update.php?updateuser", formData).then(function (response) {
      if (response.data == true) {
        upUserAlert();
        showedit.value = false;
        readusers();
      } else {
        $q.notify({
          color: "red",
          textColor: "white",
          message: "User not updated",
        });
      }
    });
  }
};

const UpdateStaffInfo = () => {
  refUpstaff.value.validate();
  refUpfname.value.validate();
  refUplname.value.validate();
  refUpbirth.value.validate();
  refUppob.value.validate();
  refUpwregion.value.validate();
  refUpscCode.value.validate();
  refUpstreet.value.validate();
  refUpvillage.value.validate();
  refUpBrgy.value.validate();
  refUpmun.value.validate();
  refUpprov.value.validate();
  refUpreg.value.validate();
  refUpdist.value.validate();

  refUpmail.value.validate();
  refUpcontact.value.validate();
  if (
    refUpstaff.value.hasError ||
    refUpfname.value.hasError ||
    refUplname.value.hasError ||
    refUpbirth.value.hasError ||
    refUppob.value.hasError ||
    refUpwregion.value.hasError ||
    refUpscCode.value.hasError ||
    refUpstreet.value.hasError ||
    refUpvillage.value.hasError ||
    refUpBrgy.value.hasError ||
    refUpmun.value.hasError ||
    refUpprov.value.hasError ||
    refUpreg.value.hasError ||
    refUpdist.value.hasError ||
    refUpmail.value.hasError ||
    refUpcontact.value.hasError
  ) {
  } else {
    var formData = new FormData(document.getElementById("UpdateUserInfoForm"));

    formData.append("id", state.id);

    axios
      .post("/update.php?updateuserInfo", formData)
      .then(function (response) {
        if (response.data == true) {
          upUserAlert();
          showedit.value = false;
          readusers();
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "User not updated",
          });
        }
      });
  }
};

// Remove User Info

const DelStaffInfo = () => {
  showedit.value = false;
  var formData = new FormData(document.getElementById("DelUserForm"));
  formData.append("id", state.id);
  console.log(state.id);

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
      axios.post("/delete.php?delUserInfo", formData).then(function (response) {
        if (response.data == true) {
          readusers();
          Swal.fire({
            title: "Deleted!",
            text: "The user has been removed.",
            icon: "success",
          });
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "User not updated",
          });
        }
      });
    }
  });
};

// Showing Province
var zipOption2 = [];
const zipOption = ref(zipOption2);

onMounted(() => {
  populateZip();
});

const populateZip = () => {
  axios.get("/read.php?address").then((response) => {
    zipOption2 = response.data;
  });
};

const filterZip = (val, update) => {
  if (val === "") {
    update(() => {
      zipOption.value = zipOption2;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    zipOption.value = zipOption2.filter((option) => {
      return option.label.toLowerCase().includes(needle);
    });
  });
};

// Showing Adress Data

onMounted(() => {
  populateaddress();
});

const populateaddress = () => {
  var formData = new FormData();
  formData.append("province", provinceZip.value);

  axios.post("/read.php?addressid", formData).then(function (response) {
    state.district = response.data.zdis;
    state.region = response.data.zreg;
    state.municipality = response.data.zmun;
    state.province = response.data.zpro;
    state.zipcode = response.data.zzip;
  });
};

// Showing Adress Data On update

onMounted(() => {
  populateUpAddress();
});

const populateUpAddress = () => {
  var formData = new FormData();

  formData.append("province", upzipid.value);

  axios.post("/read.php?addressid", formData).then(function (response) {
    state.updistrict = response.data.zdis;
    state.upregion = response.data.zreg;
    state.upmunicipality = response.data.zmun;
    state.upprovince = response.data.zpro;
    state.upzipcode = response.data.zzip;
  });
};
</script>
<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}

#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  max-width: 400px;
  margin: 40px auto;
}

input {
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
}
</style>
