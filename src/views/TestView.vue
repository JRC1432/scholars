<template>
  <q-card class="rounded-borders-20" style="width: 700px; max-width: 80vw">
    <q-toolbar>
      <IconUserPlus :size="30" stroke-width="2" />

      <q-toolbar-title
        ><span class="text-weight-bold" color="primary">NEW</span> User
        Profile</q-toolbar-title
      >

      <q-btn flat round dense icon="close" @click="CloseBtn" />
    </q-toolbar>
    <form id="scholarForm" @submit.prevent.stop="submitUser">
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
          <div class="text-h6">Personal Informartions</div>
          <div class="q-pa-md">
            <div class="row row_width q-col-gutter-xs">
              <div class="col-xs-12 col-sm-6 col-md-3">
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
              <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="q-px-sm">
                  <span class="text-bold">Middle Name</span>
                  <q-input
                    ref="refmname"
                    outlined
                    dense
                    hide-bottom-space
                    v-model="state.mname"
                    name="mname"
                    :rules="inputRules"
                  />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-3">
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
              <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="q-px-sm">
                  <span class="text-bold">Suffix Name</span>
                  <q-input
                    ref="refsname"
                    outlined
                    dense
                    hide-bottom-space
                    v-model="state.sname"
                    name="sname"
                    :rules="inputRules"
                  />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="q-px-sm">
                  <span class="text-bold">SEX </span>
                  <q-select
                    :options="sexoptions"
                    v-model="state.gender"
                    name="gender"
                    outlined
                    dense
                    hide-bottom-space
                  />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
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
              <div class="col-xs-12 col-sm-6 col-md-4">
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
                  <q-input
                    ref="refwregion"
                    outlined
                    dense
                    hide-bottom-space
                    v-model="state.wregion"
                    name="wregion"
                    :rules="inputRules"
                  />
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
                    ref="refzip"
                    outlined
                    dense
                    hide-bottom-space
                    v-model="state.zip"
                    name="zip"
                    :rules="inputRules"
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
                    :rules="inputRules"
                  />
                </div>
              </div>
            </div>
          </div>
          <q-stepper-navigation>
            <q-btn @click="step1" color="primary" label="Continue" />
          </q-stepper-navigation>
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
                    :rules="inputNumRules"
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

const batchUpload = ref(false);
const batchUploadUsers = ref(null);
const newUser = ref(false);
const showedit = ref(false);
const tab = ref("user");
const step = ref(1);

// Items reference

const refId = ref(null);
const refUsername = ref(null);
const refActType = ref(null);
const refPassword = ref(null);
const refConfPassword = ref(null);
const refRegion = ref(null);
const refSchoolCode = ref(null);
const refBulkUpload = ref(null);

const refUpId = ref(null);
const refUpUsername = ref(null);
const refUpPassword = ref(null);
const refUpConfPassword = ref(null);
const refUpActType = ref(null);
const refUpRegion = ref(null);
const refUpSchoolCode = ref(null);

const reffname = ref(null);
const refmname = ref(null);
const reflname = ref(null);
const refsname = ref(null);
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
const refzip = ref(null);
const refmail = ref(null);
const refcontact = ref(null);

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
const refUpzip = ref(null);
const refUpmail = ref(null);
const refUpcontact = ref(null);

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

const fileRules = (val) => {
  if (val === null) {
    return "Please Select a File!";
  }
  return true;
};

function maxLength(val) {
  return val.length >= 6 || "Please use maximum of 6 characters";
}

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
  code: "",

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
  zip: "",
  mail: "",
  contact: "",

  upintid: "",
  upusernames: "",
  uppassword: "",
  upconfirmpassword: "",
  upacttype: "",
  upregions: "",
  upcode: "",

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
  upzip: "",
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
  state.code = "";
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
  let timerInterval;
  Swal.fire({
    title: "Creating Multiple New Users!",
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

onMounted(() => {
  readusers();
});

const readusers = () => {
  axios.get("/read.php?readuser").then(function (response) {
    rows.value = response.data;
  });
};

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
  step.value = 2;
};

const CreateUser = () => {
  refUsername.value.validate();
  refActType.value.validate();
  refPassword.value.validate();
  refConfPassword.value.validate();
  refRegion.value.validate();
  refSchoolCode.value.validate();

  if (
    refUsername.value.hasError ||
    refActType.value.hasError ||
    refPassword.value.hasError ||
    refConfPassword.value.hasError ||
    refRegion.value.hasError ||
    refSchoolCode.value.hasError
  ) {
  } else {
    var formData = new FormData(document.getElementById("UserForm"));

    axios.post("/create.php?createuser", formData).then(function (response) {
      if (response.data == true) {
        state.intid = "";
        state.usernames = "";
        state.password = "";
        state.confirmpassword = "";
        state.acttype = "";
        state.regions = "";
        state.code = "";
        newUser.value = false;
        showalert();
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
  state.upregions = props.row.region;
  state.upcode = props.row.school_code;
  state.id = props.row.id;

  state.upfname = props.row.first_name;
  state.upmname = props.row.middle_name;
  state.uplname = props.row.last_name;
  state.upsname = props.row.suffix_name;
  state.upgender = props.row.sex;
  state.upbirth = props.row.dob;
  state.uppob = props.row.pob;
  state.upwregion = props.row.work_region;
  state.upscCode = props.row.school_code;

  state.upstreet = props.row.street;
  state.upvillage = props.row.village;
  state.upbarangay = props.row.barangay;
  state.upmunicipality = props.row.municipality;
  state.upprovince = props.row.province;
  state.upregion = props.row.region;
  state.updistrict = props.row.district;
  state.upzip = props.row.zipcode;
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
  refUpSchoolCode.value.validate();
  if (
    refUpId.value.hasError ||
    refUpUsername.value.hasError ||
    refUpPassword.value.hasError ||
    refUpConfPassword.value.hasError ||
    refUpActType.value.hasError ||
    refUpRegion.value.hasError ||
    refUpSchoolCode.value.hasError
  ) {
  } else {
    var formData = new FormData(document.getElementById("updateUserForm"));

    formData.append("upintid", state.upintid);
    formData.append("upusernames", state.upusernames);
    formData.append("uppassword", state.uppassword);
    formData.append("upacttype", state.upacttype);
    formData.append("upregions", state.upregions);
    formData.append("upcode", state.upcode);
    formData.append("id", state.id);

    axios.post("/update.php?updateuser", formData).then(function (response) {
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
  }
};
</script>

<style scoped>
.custom-table tbody tr td {
  cursor: pointer; /* Change cursor design on hover */
}
</style>
