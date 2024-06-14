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
        <q-td key="account_type" :props="props">
          {{ props.row.account_type }}
        </q-td>
        <q-td key="region" :props="props">
          {{ props.row.region }}
        </q-td>
        <q-td key="school_code" :props="props">
          {{ props.row.school_code }}
        </q-td>
      </q-tr>
    </template>
  </q-table>

  <!-- New User -->

  <q-dialog v-model="newUser" persistent>
    <q-card class="rounded-borders-20">
      <form id="UserForm" @submit.prevent.stop="CreateUser">
        <q-toolbar>
          <IconUserPlus :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">NEW</span> User
            Profile</q-toolbar-title
          >

          <q-btn flat round dense icon="close" @click="CloseBtn" />
        </q-toolbar>

        <q-card-section class="q-pt-none">
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
        </q-card-section>

        <q-card-actions align="center">
          <q-btn
            rounded
            label="SUBMIT"
            color="primary"
            type="submit"
            style="width: 80%"
            class="q-my-lg"
          />
        </q-card-actions>
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
    <q-card class="rounded-borders-20">
      <form id="updateUserForm" @submit.prevent.stop="UpdateUser">
        <q-toolbar>
          <IconUserEdit :size="30" stroke-width="2" />

          <q-toolbar-title
            ><span class="text-weight-bold" color="primary">EDIT</span> User
            Profile</q-toolbar-title
          >

          <q-btn flat round dense icon="close" @click="CloseEditBtn" />
        </q-toolbar>

        <q-card-section class="q-pt-none">
          <div class="q-pa-md">
            <div class="row row_width q-col-gutter-xs">
              <div class="col-xs-12 col-sm-12">
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
              <div class="col-xs-12 col-sm-12">
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
                  >
                  </q-select>
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
                    ref="refUpSchoolCode"
                    outlined
                    dense
                    hide-bottom-space
                    type="number"
                    v-model="state.upcode"
                    name="code"
                    :rules="inputNumRules"
                  />
                </div>
              </div>
            </div>
          </div>
        </q-card-section>

        <q-card-actions>
          <div class="row fit justify-center">
            <q-btn
              rounded
              label="SUBMIT"
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

const batchUpload = ref(false);
const batchUploadUsers = ref(null);
const newUser = ref(false);
const showedit = ref(false);

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

  upintid: "",
  upusernames: "",
  uppassword: "",
  upconfirmpassword: "",
  upacttype: "",
  upregions: "",
  upcode: "",
});

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
    name: "account_type",
    align: "center",
    label: "Account Type",
    field: "account_type",
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
    name: "school_code",
    align: "left",
    label: "School Code",
    field: "school_code",
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
