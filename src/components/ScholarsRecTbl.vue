<template>
  <q-table
    flat
    bordered
    :rows="rows"
    :columns="columns"
    row-key="name"
    :filter="filter"
    v-model:pagination="pagination"
    class="rounded-borders-20 no-border custom-table"
  >
    <template v-slot:top-left>
      <q-btn
        color="primary"
        size="10px"
        no-caps
        round
        icon="add"
        @click="newScholar = true"
      >
        <q-tooltip class="bg-primary">Add Scholar</q-tooltip>
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
      <q-tr :prop="props" @click="showUpdateScholar(props)"
        ><q-td key="spas_id" :props="props">
          {{ props.row.spas_id }}
        </q-td>
        <q-td key="username" :props="props">
          <q-badge color="light-green-4" :label="props.value">
            {{ props.row.username }}
          </q-badge>
        </q-td>
        <q-td key="full_name" :props="props">
          {{ props.row.full_name }}
        </q-td>
        <q-td key="school_code" :props="props">
          {{ props.row.school_code }}
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
        <q-td key="school_region" :props="props">
          {{ props.row.school_region }}
        </q-td>
      </q-tr>
    </template>
  </q-table>

  <!-- New Scholar -->

  <q-dialog v-model="newScholar" persistent>
    <q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
      <q-toolbar>
        <IconUserPlus :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">NEW</span> Scholar
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
                      <span class="text-bold">SPAS ID</span>
                      <q-input
                        ref="refspas"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.spasid"
                        mask="A - #### - ## - #####"
                        name="spasid"
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
                        :options="sexoptions"
                        v-model="state.gender"
                        emit-value
                        name="gender"
                        outlined
                        dense
                        hide-bottom-space
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
                      <span class="text-bold">Tribe</span>
                      <q-input
                        ref="reftribe"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.tribe"
                        name="tribe"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">School Region</span>
                      <q-select
                        ref="refscregions"
                        outlined
                        dense
                        hide-bottom-space
                        behavior="menu"
                        emit-value
                        map-options
                        use-input
                        input-debounce="0"
                        v-model="state.scregions"
                        name="scregions"
                        :options="regoptions"
                        @filter="filterregion"
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
                        :rules="inputRules"
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
                        :rules="inputRules"
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
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Municipality</span>
                      <q-input
                        ref="refmun"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.municipality"
                        name="municipality"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Province</span>
                      <q-input
                        ref="refprov"
                        readonly
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.province"
                        name="province"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Region</span>
                      <q-input
                        ref="refreg"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.region"
                        name="region"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">District</span>
                      <q-input
                        ref="refdist"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.district"
                        name="district"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">ZipCode</span>
                      <q-input
                        ref="refzip"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.zip"
                        name="zip"
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
                    >
                      <template v-slot:append>
                        <q-icon
                          :name="isPwds ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="isPwds = !isPwds"
                        />
                      </template>
                    </q-input>
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
                    >
                    </q-select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <div class="q-px-sm">
                    <span class="text-bold">School Code</span>
                    <q-input
                      ref="refSchoolCode"
                      outlined
                      dense
                      hide-bottom-space
                      type="number"
                      v-model="state.code"
                      name="code"
                    />
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

  <!-- Update Functions -->
  <q-dialog v-model="showedit" persistent
    ><q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
      <q-toolbar>
        <IconUserEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">EDIT</span> Scholar
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
        <q-tab name="scholar" label="Scholar Account informations" />
        <q-tab name="personal" label="Personal Informations" />
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="scholar">
          <div class="text-h6">User Account Informations</div>
          <form id="updateScholarForm" @submit.prevent.stop="UpdateScholar">
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
                      name="upintid"
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
                      name="upacttype"
                      :options="actoptions"
                      @filter="filteracnt"
                    >
                    </q-select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                  <div class="q-px-sm">
                    <span class="text-bold">School Code</span>
                    <q-input
                      ref="refUpSchoolCode"
                      readonly
                      outlined
                      dense
                      hide-bottom-space
                      type="number"
                      v-model="state.upscode"
                      name="upscode"
                    />
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
                    >
                    </q-select>
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
                      name="upusernames"
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
                      name="uppassword"
                      :rules="inputpassRules"
                    >
                      <template v-slot:append>
                        <q-icon
                          :name="upisPwds ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="upisPwds = !upisPwds"
                        />
                      </template>
                    </q-input>
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
                      name="upconfirmpassword"
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

                <q-btn
                  rounded
                  style="width: 80%"
                  label="REMOVE THIS USER"
                  color="negative"
                  type="submit"
                  class="q-mb-sm"
                />
              </div>
            </q-card-actions>
          </form>
        </q-tab-panel>

        <q-tab-panel name="personal">
          <!-- <form
            id="UpdateScholarInfoForm"
            @submit.prevent.stop="UpdateScholarInfo"
          >
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
                        <q-input
                          ref="refUpwregion"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upwregion"
                          name="upwregion"
                          :rules="inputRules"
                        />
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
                          ref="refUpzipcode"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upzipcode"
                          name="upzipcode"
                          :rules="inputRules"
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
                          :rules="inputRules"
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
          </form> -->
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
} from "@tabler/icons-vue";
import Swal from "sweetalert2";

const user = inject("$user");
const q$ = useQuasar();
const $q = useQuasar();
const axios = inject("$axios");

// Items Variable

const rows = ref([]);
const filter = ref("");
const pagination = ref({
  rowsPerPage: 10,
});
const showedit = ref(false);
const tab = ref("scholar");
const newScholar = ref(false);
const step = ref(1);

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

const inputpassRules = [
  (val) => !!val || "Field is required",
  (val) => val.length >= 6 || "Please use minimum of 6 characters",
];

function maxLength(val) {
  return val.length >= 6 || "Please use maximum of 6 characters";
}

// Username Checker,
// const checkUsername = async (value) => {
//   const formData = new FormData(document.getElementById("updateUserForm"));
//   formData.append("usernames", state.upusernames);
//   try {
//     const response = await axios.post("/read.php?checkUser", formData);
//     if (response.data === true) {
//       // Do something if username is available
//     } else {
//       return new Promise((resolve) => {
//         setTimeout(() => {
//           resolve("This username is already been taken!!!");
//         }, 1500);
//       });
//     }
//   } catch (error) {
//     // Handle any errors
//     console.error("Error:", error);
//   }
// };

// Items reference

const refUpId = ref(null);
const refUpUsername = ref(null);
const refUpPassword = ref(null);
const refUpConfPassword = ref(null);
const refUpActType = ref(null);
const refUpRegion = ref(null);
const refUpSchoolCode = ref(null);

// @state v-model
const state = reactive({
  upintid: "",
  upusernames: "",
  uppassword: "",
  upconfirmpassword: "",
  upacttype: "",
  upregions: "",
  upscode: "",
});

// SWAL
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
    name: "username",
    required: true,
    label: "UserName",
    align: "left",
    field: "username",
    sortable: true,
  },
  {
    name: "full_name",
    align: "left",
    label: "Full Name",
    field: "full_name",
    sortable: true,
  },
  {
    name: "school_code",
    align: "left",
    label: "School Code",
    field: "school_code",
    sortable: true,
  },

  {
    name: "sex",
    align: "left",
    label: "SEX",
    field: "sex",
    sortable: true,
  },
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
    align: "center",
    label: "Region",
    field: "region",
    sortable: true,
  },
  {
    name: "school_region",
    align: "center",
    label: "School Region",
    field: "school_region",
    sortable: true,
  },
];

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

// Read Users

onMounted(() => {
  readusers();
});

const readusers = () => {
  axios.get("/read.php?readScholarRec").then(function (response) {
    rows.value = response.data;
  });
};
// Close Button
const CloseEditBtn = () => {
  showedit.value = false;
};

const CloseBtn = () => {
  newScholar.value = false;
};

// UPdate Scholar

const showUpdateScholar = (props) => {
  showedit.value = true;
  state.upintid = props.row.internal_id;
  state.upusernames = props.row.username;
  state.upacttype = props.row.account_type;
  state.upregions = props.row.uregion;
  state.upscode = props.row.uschoolcode;
  state.id = props.row.id;
  console.log(state.id);
};

const UpdateScholar = () => {
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
    var formData = new FormData(document.getElementById("updateScholarForm"));

    formData.append("id", state.id);

    axios.post("/update.php?updateScholar", formData).then(function (response) {
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
</script>

<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
