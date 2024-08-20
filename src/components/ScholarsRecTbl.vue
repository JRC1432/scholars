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
      <div class="q-ml-sm">
        <q-btn
          color="primary"
          size="10px"
          no-caps
          round
          icon="download"
          tag="a"
          href="http://localhost/scholars/scholars_backend/upload/Scholar_Rec.csv"
          target="_blank"
        >
          <q-tooltip class="bg-primary"
            >Download Scholars Records Template</q-tooltip
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
      <form id="ScholarForm" @submit.prevent.stop="CreateScholars">
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
                        mask="A - #### - NN - #####"
                        name="spasid"
                        :rules="combinedRules"
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
                        ref="refgender"
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
                        :rules="inputRules"
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
                        input-debounce="0"
                        :options="zipOption"
                        @filter="filterZip"
                        behavior="menu"
                        @update:model-value="populateaddress"
                        :rules="[myRule]"
                        clearable
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

              <div class="q-px-sm text-bold">
                <span class="text-bold">Use different Current Address?</span>
                <q-toggle
                  v-model="curadd"
                  checked-icon="check"
                  color="green"
                  unchecked-icon="clear"
                  @click="tog"
                  name="diffcur"
                />
              </div>

              <q-card-section v-if="curadd">
                <div class="q-pa-xs">
                  <div class="row row_width q-col-gutter-xs">
                    <div class="col-xs-12">
                      <div class="q-px-sm">
                        <span class="text-bold">Select Province:</span>

                        <q-select
                          ref="rfprovinceZip2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="provinceZip2"
                          name="provinceZip2"
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          :options="zipOption"
                          @filter="filterZip"
                          behavior="menu"
                          @update:model-value="populateaddress2"
                          :rules="[myRule]"
                          clearable
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
                          ref="refstreet2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.street2"
                          name="street2"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Village</span>
                        <q-input
                          ref="refvillage2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.village2"
                          name="village2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Barangay</span>
                        <q-input
                          ref="refBrgy2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.barangay2"
                          name="barangay2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Municipality</span>
                        <q-input
                          ref="refmun2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.municipality2"
                          name="municipality2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Province</span>
                        <q-input
                          ref="refprov2"
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.province2"
                          name="province2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Region</span>
                        <q-input
                          ref="refreg2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.region2"
                          name="region2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">District</span>
                        <q-input
                          ref="refdist2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.district2"
                          name="district2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">ZipCode</span>
                        <q-input
                          ref="refzip2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.zip2"
                          name="zip2"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </q-card-section>

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
                      name="usernames"
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

  <!-- Update Functions -->
  <q-dialog v-model="showedit" persistent
    ><q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
      <q-toolbar>
        <IconUserEdit :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">UPDATE</span> Scholar
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
                      :rules="[maxLength]"
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
              </div>
            </q-card-actions>
          </form>
        </q-tab-panel>

        <!-- Updates HERE!!!! -->

        <q-tab-panel name="personal">
          <form
            id="UpdateScholarInfoForm"
            @submit.prevent.stop="UpdateScholarInfo"
          >
            <q-scroll-area style="height: 600px; max-width: 800px">
              <div class="text-h6">Personal Informartions</div>
              <div class="q-pa-md">
                <div class="row row_width q-col-gutter-xs">
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">SPAS ID</span>
                      <q-input
                        ref="refupspasid"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.upspasid"
                        mask="A - #### - NN - #####"
                        name="upspasid"
                        :rules="combinedRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">First Name</span>
                      <q-input
                        ref="refupfname"
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
                        ref="refupmname"
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
                        ref="refuplname"
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
                        ref="refupsname"
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
                        ref="refupgender"
                        :options="sexoptions"
                        v-model="state.upgender"
                        emit-value
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
                        ref="refupbirth"
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
                        ref="refuppob"
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
                      <span class="text-bold">Tribe</span>
                      <q-input
                        ref="refuptribe"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.uptribe"
                        name="uptribe"
                        :rules="inputRules"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">School Region</span>
                      <q-select
                        ref="refupscregions"
                        outlined
                        dense
                        hide-bottom-space
                        behavior="menu"
                        emit-value
                        map-options
                        use-input
                        input-debounce="0"
                        v-model="state.upscregions"
                        name="upscregions"
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
                        ref="refupscCode"
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
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="q-px-sm">
                      <span class="text-bold">Email</span>
                      <q-input
                        ref="refupmail"
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
                        ref="refupcontact"
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
                  <div class="col-xs-12">
                    <div class="q-px-sm">
                      <span class="text-bold">Select Province:</span>

                      <q-select
                        ref="rfupprovinceZip"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="upprovinceZip"
                        name="upprovinceZip"
                        emit-value
                        map-options
                        use-input
                        input-debounce="0"
                        :options="zipOption"
                        @filter="filterZip"
                        behavior="menu"
                        @update:model-value="populateupaddress"
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
                        ref="refupstreet"
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
                        ref="refupvillage"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.upvillage"
                        name="upvillage"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Barangay</span>
                      <q-input
                        ref="refupBrgy"
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.upbarangay"
                        name="upbarangay"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Municipality</span>
                      <q-input
                        ref="refupmun"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.upmunicipality"
                        name="upmunicipality"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Province</span>
                      <q-input
                        ref="refupprov"
                        readonly
                        outlined
                        dense
                        hide-bottom-space
                        v-model="state.upprovince"
                        name="upprovince"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">Region</span>
                      <q-input
                        ref="refupreg"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.upregion"
                        name="upregion"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">District</span>
                      <q-input
                        ref="refupdist"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.updistrict"
                        name="updistrict"
                      />
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="q-px-sm">
                      <span class="text-bold">ZipCode</span>
                      <q-input
                        ref="refupzip"
                        outlined
                        dense
                        readonly
                        hide-bottom-space
                        v-model="state.upzip"
                        name="upzip"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="q-px-sm text-bold">
                <span class="text-bold">Use different Current Address?</span>
                <q-toggle
                  v-model="upcuradd"
                  checked-icon="check"
                  color="green"
                  unchecked-icon="clear"
                  name="upcuradd"
                  @click="uptog"
                />
              </div>

              <q-card-section v-if="upcuradd">
                <div class="q-pa-xs">
                  <div class="row row_width q-col-gutter-xs">
                    <div class="col-xs-12">
                      <div class="q-px-sm">
                        <span class="text-bold">Select Province:</span>

                        <q-select
                          ref="rfupprovinceZip2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="upprovinceZip2"
                          name="upprovinceZip2"
                          emit-value
                          map-options
                          use-input
                          input-debounce="0"
                          :options="zipOption"
                          @filter="filterZip"
                          behavior="menu"
                          @update:model-value="populateupaddress2"
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
                          ref="refupstreet2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upstreet2"
                          name="upstreet2"
                          :rules="inputRules"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Village</span>
                        <q-input
                          ref="refupvillage2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upvillage2"
                          name="upvillage2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Barangay</span>
                        <q-input
                          ref="refupBrgy2"
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upbarangay2"
                          name="upbarangay2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Municipality</span>
                        <q-input
                          ref="refupmun2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.upmunicipality2"
                          name="upmunicipality2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Province</span>
                        <q-input
                          ref="refupprov2"
                          readonly
                          outlined
                          dense
                          hide-bottom-space
                          v-model="state.upprovince2"
                          name="upprovince2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">Region</span>
                        <q-input
                          ref="refupreg2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.upregion2"
                          name="upregion2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">District</span>
                        <q-input
                          ref="refupdist2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.updistrict2"
                          name="updistrict2"
                        />
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="q-px-sm">
                        <span class="text-bold">ZipCode</span>
                        <q-input
                          ref="refupzip2"
                          outlined
                          dense
                          readonly
                          hide-bottom-space
                          v-model="state.upzip2"
                          name="upzip2"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </q-card-section>
            </q-scroll-area>
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

  <!-- Batch Upload -->

  <q-dialog v-model="batchUpload" persistent>
    <q-card style="min-width: 500px; width: 500px" class="rounded-borders-20">
      <q-toolbar>
        <IconFileTypeCsv :size="30" stroke-width="2" />

        <q-toolbar-title
          ><span class="text-weight-bold" color="primary">CSV</span> Scholars
          Batch Upload</q-toolbar-title
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
                v-model="batchUploadScholars"
                name="batchUploadScholars"
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
import PasswordMeter from "vue-simple-password-meter";

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
const batchUpload = ref(false);
const batchUploadScholars = ref(null);

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

// Validation rules
const errorMessage = ref("");
const inputpassRules = [
  (val) => (val && val.length > 0) || "Please type something",
  (val) => val.length >= 8 || "Password must be at least 8 characters long",
  (val) => score.value > 0 || "Use a better password",
];

// Function to validate password
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

function maxLength(val) {
  return val.length >= 6 || "Please use maximum of 6 characters";
}

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

const emailRule = (val) => {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(val) || "Please enter a valid email address";
};

// Username Validations

const checkUsername = async (value) => {
  const formData = new FormData(document.getElementById("ScholarForm"));
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

// SPAS ID Validations

const checkSpasid = async (value) => {
  const formData = new FormData(document.getElementById("ScholarForm"));
  formData.append("checkSpasid", state.spasid);
  try {
    const response = await axios.post("/read.php?checkSpas", formData);
    if (response.data === true) {
      // Do something if username is available
    } else {
      return new Promise((resolve) => {
        setTimeout(() => {
          resolve("This SPAS ID is already been taken!!!");
        }, 1500);
      });
    }
  } catch (error) {
    // Handle any errors
    console.error("Error:", error);
  }
};

const combinedRules = [checkSpasid, ...inputRules];

// Email Validations

// const checkMails = async (value) => {
//   const formData = new FormData(document.getElementById("ScholarForm"));
//   formData.append("mail", state.mail);
//   try {
//     const response = await axios.post("/read.php?checkMail", formData);
//     if (response.data === true) {
//       // Do something if username is available
//     } else {
//       return new Promise((resolve) => {
//         setTimeout(() => {
//           resolve("This E-mail is already been taken!!!");
//         }, 1500);
//       });
//     }
//   } catch (error) {
//     // Handle any errors
//     console.error("Error:", error);
//   }
// };

// const combinedMails = [checkMails, ...inputRules];

// Contact Validations

// const cheknum = async (value) => {
//   const formData = new FormData(document.getElementById("ScholarForm"));
//   formData.append("contact", state.contact);
//   try {
//     const response = await axios.post("/read.php?checkContact", formData);
//     if (response.data === true) {
//       // Do something if username is available
//     } else {
//       return new Promise((resolve) => {
//         setTimeout(() => {
//           resolve("This phone number is already been taken!!!");
//         }, 1500);
//       });
//     }
//   } catch (error) {
//     // Handle any errors
//     console.error("Error:", error);
//   }
// };

// const combinedNum = [cheknum, ...inputRules];

// Sweet Alerts

const showalert = () => {
  let timerInterval;
  Swal.fire({
    title: "Creating New Scholar!",
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

// Items reference

const curadd = ref(false);
const upcuradd = ref(false);
const provinceZip = ref(null);
const upprovinceZip = ref(null);
const provinceZip2 = ref(null);
const upprovinceZip2 = ref(null);

const refBulkUpload = ref(null);

const refId = ref(null);
const refUsername = ref(null);
const refPassword = ref(null);
const refConfPassword = ref(null);
const refActType = ref(null);
const refRegion = ref(null);

const refspas = ref(null);
const reffname = ref(null);
const refmname = ref(null);
const reflname = ref(null);
const refsname = ref(null);
const refbirth = ref(null);
const refgender = ref(null);
const refpob = ref(null);
const reftribe = ref(null);
const refscregions = ref(null);
const refscCode = ref(null);
const refmail = ref(null);
const refcontact = ref(null);
const rfprovinceZip = ref(null);
const refstreet = ref(null);
const refvillage = ref(null);
const refBrgy = ref(null);
const refmun = ref(null);
const refprov = ref(null);
const refreg = ref(null);
const refdist = ref(null);
const refzip = ref(null);

const rfprovinceZip2 = ref(null);
const refstreet2 = ref(null);
const refvillage2 = ref(null);
const refBrgy2 = ref(null);
const refmun2 = ref(null);
const refprov2 = ref(null);
const refreg2 = ref(null);
const refdist2 = ref(null);
const refzip2 = ref(null);

const refUpId = ref(null);
const refUpUsername = ref(null);
const refUpPassword = ref(null);
const refUpConfPassword = ref(null);
const refUpActType = ref(null);
const refUpRegion = ref(null);
const refUpSchoolCode = ref(null);

const refupspasid = ref(null);
const refupfname = ref(null);
const refupmname = ref(null);
const refuplname = ref(null);
const refupsname = ref(null);
const refupgender = ref(null);
const refupbirth = ref(null);
const refuppob = ref(null);
const refuptribe = ref(null);
const refupscregions = ref(null);
const refupscCode = ref(null);
const refupmail = ref(null);
const refupcontact = ref(null);
const rfupprovinceZip = ref(null);
const refupstreet = ref(null);
const refupvillage = ref(null);
const refupBrgy = ref(null);
const refupmun = ref(null);
const refupprov = ref(null);
const refupreg = ref(null);
const refupdist = ref(null);
const refupzip = ref(null);

const rfupprovinceZip2 = ref(null);
const refupstreet2 = ref(null);
const refupvillage2 = ref(null);
const refupBrgy2 = ref(null);
const refupmun2 = ref(null);
const refupprov2 = ref(null);
const refupreg2 = ref(null);
const refupdist2 = ref(null);
const refupzip2 = ref(null);

// @state v-model
const state = reactive({
  id: "",
  intid: "",
  usernames: "",
  password: "",
  confirmpassword: "",
  acttype: "",
  regions: "",

  spasid: "",
  fname: "",
  mname: "",
  lname: "",
  sname: "",
  gender: "",
  birth: "",
  pob: "",
  tribe: "",
  scregions: "",
  scCode: "",
  mail: "",
  contact: "",
  street: "",
  village: "",
  barangay: "",
  municipality: "",
  province: "",
  region: "",
  district: "",
  zip: "",

  street2: "",
  village2: "",
  barangay2: "",
  municipality2: "",
  province2: "",
  region2: "",
  district2: "",
  zip2: "",

  upintid: "",
  upusernames: "",
  uppassword: "",
  upconfirmpassword: "",
  upacttype: "",
  upregions: "",
  upscode: "",

  upspasid: "",
  upfname: "",
  upmname: "",
  uplname: "",
  upsname: "",
  upgender: "",
  upbirth: "",
  uppob: "",
  uptribe: "",
  upscregions: "",
  upscCode: "",
  upmail: "",
  upcontact: "",
  upstreet: "",
  upvillage: "",
  upbarangay: "",
  upmunicipality: "",
  upprovince: "",
  upregion: "",
  updistrict: "",
  upzip: "",

  upstreet2: "",
  upvillage2: "",
  upbarangay2: "",
  upmunicipality2: "",
  upprovince2: "",
  upregion2: "",
  updistrict2: "",
  upzip2: "",
});

// SWAL
const upUserAlert = () => {
  let timerInterval;
  Swal.fire({
    title: "Updating Scholar Information!",
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

// SELECT OPTIONS
const sexoptions = computed(() => [
  { label: "Male", value: "M", color: "primary" },
  { label: "Female", value: "F", color: "primary" },
]);

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

const tog = () => {
  if (curadd.value === false) {
    provinceZip2.value = "";
    state.street2 = "";
    state.village2 = "";
    state.barangay2 = "";
    state.municipality2 = "";
    state.province2 = "";
    state.region2 = "";
    state.district2 = "";
    state.zip2 = 0;
  }
};

const uptog = () => {
  if (curadd.value === false) {
    upprovinceZip2.value = "";
    state.upstreet2 = "";
    state.upvillage2 = "";
    state.upbarangay2 = "";
    state.upmunicipality2 = "";
    state.upprovince2 = "";
    state.upregion2 = "";
    state.updistrict2 = "";
    state.upzip2 = 0;
  }
};

// Create New Scholar

const step1 = () => {
  // Validate all references if they exist
  const refs = [
    refspas,
    reffname,
    reflname,
    refgender,
    refbirth,
    refpob,
    reftribe,
    refscregions,
    refscCode,
    refmail,
    refcontact,
    rfprovinceZip,
    refstreet,
    rfprovinceZip2,
    refstreet2,
  ];

  // Iterate over each reference and validate if not null
  refs.forEach((ref) => {
    if (ref?.value) {
      ref.value.validate();
    }
  });

  // Check for errors, making sure refs are not null
  const hasError = refs.some((ref) => ref?.value?.hasError);

  if (hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all required fields.",
    });
  } else if (
    curadd.value === true &&
    (refvillage2?.value?.hasError || rfprovinceZip2?.value?.hasError)
  ) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all required fields.",
    });
  } else {
    step.value = 2;
  }
};

const CreateScholars = () => {
  const refs = [
    refId,
    refUsername,
    refPassword,
    refConfPassword,
    refActType,
    refRegion,
  ];

  refs.forEach((ref) => {
    if (ref?.value) {
      ref.value.validate();
    }
  });

  const hasError = refs.some((ref) => ref?.value?.hasError);

  if (hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all required fields.",
    });
  } else {
    var formData = new FormData(document.getElementById("ScholarForm"));

    // Personal Information Append
    formData.append("spasid", state.spasid);
    formData.append("fname", state.fname);
    formData.append("mname", state.mname);
    formData.append("lname", state.lname);
    formData.append("sname", state.sname);
    formData.append("gender", state.gender);
    formData.append("birth", state.birth);
    formData.append("pob", state.pob);
    formData.append("tribe", state.tribe);
    formData.append("scregions", state.scregions);
    formData.append("scCode", state.scCode);

    formData.append("mail", state.mail);
    formData.append("contact", state.contact);

    formData.append("zipid", provinceZip.value);
    formData.append("street", state.street);
    formData.append("village", state.village);
    formData.append("barangay", state.barangay);
    formData.append("municipality", state.municipality);
    formData.append("province", state.province);
    formData.append("region", state.region);
    formData.append("district", state.district);
    formData.append("zip", state.zip);

    formData.append("diffcur", curadd.value);

    formData.append("zipid2", provinceZip2.value);
    formData.append("street2", state.street2);
    formData.append("village2", state.village2);
    formData.append("barangay2", state.barangay2);
    formData.append("municipality2", state.municipality2);
    formData.append("province2", state.province2);
    formData.append("region2", state.region2);
    formData.append("district2", state.district2);
    formData.append("zip2", state.zip2);

    axios.post("/create.php?createScholar", formData).then(function (response) {
      if (response.data == true) {
        newScholar.value = false;
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

// UPdate Scholar

const showUpdateScholar = (props) => {
  showedit.value = true;
  state.upintid = props.row.internal_id;
  state.upusernames = props.row.username;
  state.upacttype = props.row.account_type;
  state.upregions = props.row.uregion;
  state.upscode = props.row.uschoolcode;
  state.id = props.row.id;

  state.upspasid = props.row.spas_id;
  state.upfname = props.row.first_name;
  state.upmname = props.row.middle_name;
  state.uplname = props.row.last_name;
  state.upsname = props.row.suffix_name;
  state.upgender = props.row.sex;
  state.upbirth = props.row.dob;
  state.uppob = props.row.pob;
  state.uptribe = props.row.tribe;
  state.upscregions = props.row.school_region;
  state.upscCode = props.row.school_code;
  state.upmail = props.row.email;
  state.upcontact = props.row.contact_no;
  state.upstreet = props.row.street;
  state.upvillage = props.row.village;
  state.upbarangay = props.row.barangay;
  state.upmunicipality = props.row.municipality;
  state.upprovince = props.row.province;
  state.upregion = props.row.region;
  state.updistrict = props.row.district;
  state.upzip = props.row.zipcode;

  state.upstreet2 = props.row.astreet;
  state.upvillage2 = props.row.avillage;
  state.upbarangay2 = props.row.abarangay;
  state.upmunicipality2 = props.row.amunicipality;
  state.upprovince2 = props.row.aprovince;
  state.upregion2 = props.row.aregion;
  state.updistrict2 = props.row.adistrict;
  state.upzip2 = props.row.azipcode;

  // upprovinceZip.value = props.row.zip_id;

  upcuradd.value = props.row.diff_curr_add;

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

const UpdateScholarInfo = () => {
  const refs = [
    refupfname,
    refuplname,
    refupgender,
    refupbirth,
    refuppob,
    refuptribe,
    refupscregions,
    refupscCode,
    refupmail,
    refupcontact,
    refupstreet,
    refupstreet2,
  ];

  // Iterate over each reference and validate if not null
  refs.forEach((ref) => {
    if (ref?.value) {
      ref.value.validate();
    }
  });

  // Check for errors, making sure refs are not null
  const hasError = refs.some((ref) => ref?.value?.hasError);

  if (hasError) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all required fields.",
    });
  } else if (
    upcuradd.value === true &&
    (refupstreet2?.value?.hasError || rfupprovinceZip2?.value?.hasError)
  ) {
    $q.notify({
      color: "red",
      textColor: "white",
      message: "Please complete all required fields.",
    });
  } else {
    // alert("Test Complete");

    var formData = new FormData(
      document.getElementById("UpdateScholarInfoForm")
    );

    formData.append("id", state.id);
    formData.append("upcuradd", upcuradd.value);

    axios
      .post("/update.php?updateScholarInfo", formData)
      .then(function (response) {
        if (response.data == true) {
          upUserAlert();
          showedit.value = false;
        } else {
          $q.notify({
            color: "red",
            textColor: "white",
            message: "User not updated",
          });
        }
      });

    axios
      .post("/update.php?updateScholarAddr", formData)
      .then(function (response) {
        if (response.data == true) {
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
    state.zip = response.data.zzip;
  });
};

onMounted(() => {
  populateupaddress();
});

const populateupaddress = () => {
  var formData = new FormData();
  formData.append("province", upprovinceZip.value);
  console.log(upprovinceZip.value);

  axios.post("/read.php?addressid", formData).then(function (response) {
    state.updistrict = response.data.zdis;
    state.upregion = response.data.zreg;
    state.upmunicipality = response.data.zmun;
    state.upprovince = response.data.zpro;
    state.upzip = response.data.zzip;
  });
};

// Showing Adress Data 2

onMounted(() => {
  populateaddress2();
});

const populateaddress2 = () => {
  var formData = new FormData();

  formData.append("province", provinceZip2.value);

  axios.post("/read.php?addressid", formData).then(function (response) {
    state.district2 = response.data.zdis;
    state.region2 = response.data.zreg;
    state.municipality2 = response.data.zmun;
    state.province2 = response.data.zpro;
    state.zip2 = response.data.zzip;
  });
};

onMounted(() => {
  populateupaddress2();
});

const populateupaddress2 = () => {
  var formData = new FormData();

  formData.append("province", upprovinceZip2.value);

  axios.post("/read.php?addressid", formData).then(function (response) {
    state.updistrict2 = response.data.zdis;
    state.upregion2 = response.data.zreg;
    state.upmunicipality2 = response.data.zmun;
    state.upprovince2 = response.data.zpro;
    state.upzip2 = response.data.zzip;
  });
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

    axios
      .post("/create.php?batchUploadScholar", formData)
      .then(function (response) {
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
