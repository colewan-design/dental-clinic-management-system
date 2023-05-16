<style>
  .table-row {
    padding: 20px;
  }

  .v-data-table__wrapper {
    width: 100%;
  }

  .table-container {
    overflow-x: auto;
  }

  .v-data-table__expanded__content {
    white-space: pre-wrap;
  }

  td {
    white-space: pre-wrap;
    overflow-x: auto;
  }

  .expanded-item {
  white-space: normal;
  word-break: break-all;
  max-width: 400px;
  padding: 20px;
  background-color: #f5f5f5;
  border-top: 1px solid #ddd;
}

.expanded-item__header {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.expanded-item__header-text {
  color: #333;
  font-weight: bold;
  margin-right: 10px;
  flex-basis: 100px;
}

.expanded-item__header-value {
  flex-grow: 1;
}

.expanded-item__divider {
  height: 1px;
  background-color: #ddd;
  margin: 20px 0;
}
</style>

<template>
  <v-card>
    <v-layout>
      <superadmin-navigation></superadmin-navigation>

      <v-main>
        <v-row class="table-row">
          <v-col>
            <v-toolbar-title>Appointments</v-toolbar-title>
           
            <div class="table-container">
              <v-data-table
                :headers="headers"
                :items="appointments"
                :search="search"
                :expanded.sync="expanded"
                item-key="id"
                show-expand
                class="elevation-1"
              >
              <template v-slot:top>
                  <v-row>
                    <v-col cols="12" md="4">
                      <v-text-field v-model="search" label="Search" clearable></v-text-field>
                    </v-col>
                   
                  </v-row>
                  <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }" >
                  <v-btn x-small fab color="primary" dark v-bind="attrs" v-on="on" style="float: right;">
                    <v-icon dark> mdi-plus </v-icon>
                  </v-btn>
                </template>
      <!-- modal for edit -->
      <v-form ref="form" v-model="valid">
      <v-card class="py-5">
        <v-card-title class="px-5">
          <span class="text-h6">{{ formTitle }}</span>
        </v-card-title>

        <v-card-text class="px-5">
          <v-autocomplete
          label="Patient"
          hide-details
          :items="patients"
          :item-text="patients => `${patients.name}`"
          :item-value="patients => patients.id"
          v-model="appointment_items.patient_id"
          prepend-inner-icon="mdi-pencil"
        ></v-autocomplete>
        </v-card-text>
        
        <v-card-text class="px-5">
          <v-autocomplete
          label="Dentist"
          hide-details
          :items="dentists"
          :item-text="dentists => `${dentists.name}`"
          :item-value="dentists => dentists.id"
          v-model="appointment_items.dentist_id"
          prepend-inner-icon="mdi-pencil"
        ></v-autocomplete>
        </v-card-text>

        <!-- Date field -->
        <v-card-text class="px-5">
          <v-text-field
            label="Date"
            v-model="appointment_items.date"
            prepend-inner-icon="mdi-calendar"
            type="date"
            required
          ></v-text-field>
        </v-card-text>

        <!-- Time field -->
        <v-card-text class="px-5">
          <v-text-field
            label="Time"
            v-model="appointment_items.time"
            prepend-inner-icon="mdi-clock-time-four-outline"
            type="time"
            required
          ></v-text-field>
        </v-card-text>

        <v-card-actions class="px-5">
  <v-tooltip top>
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        x-small
        fab
        dark
        :color="'primary'"
        v-bind="attrs"
        v-on="on"
        @click="Submit"
        :disabled="!valid"
      >
        <v-icon>
          mdi-check
        </v-icon>
      </v-btn>
    </template>
    Save
  </v-tooltip>

  <v-tooltip top>
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        x-small
        fab
        dark
        color="secondary"
        v-bind="attrs"
        v-on="on"
        class="ml-2"
        @click="close"
      >
        <v-icon>
          mdi-close
        </v-icon>
      </v-btn>
    </template>
    <span>Close</span>
  </v-tooltip>

  <v-tooltip top>
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        x-small
        fab
        dark
        :color="appointment_items.status === 'active' ? 'red' : 'green'"
        v-bind="attrs"
        v-on="on"
        class="ml-2"
        @click="addStatus"
      >
        <v-icon>
          {{ appointment_items.status === 'active' ? 'mdi-close' : 'mdi-check' }}
        </v-icon>
    
      </v-btn>
    </template>
    <span>{{ appointment_items.status === 'active' ? 'Cancel Appointment' : 'Activate Appointment' }}</span>
    
  </v-tooltip>
</v-card-actions>


      </v-card>
    </v-form>

              </v-dialog>
              <!--Dialog Delete-->
              <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h6 justify-center">
                Are you sure you want to delete?
              </v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      x-small
                      fab
                      dark
                      color="secondary"
                      v-bind="attrs"
                      v-on="on"
                      class="ml-2"
                      @click="closeDelete"
                    >
                      <v-icon style="color: #fff !important">
                        mdi-close
                      </v-icon></v-btn
                    >
                  </template>
                  <span>Cancel</span>
                </v-tooltip>
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      x-small
                      fab
                      dark
                      color="error"
                      v-bind="attrs"
                      v-on="on"
                      class="ml-2"
                      @click="deleteItemConfirm"
                    >
                      <v-icon style="color: #fff !important">
                        mdi-check
                      </v-icon></v-btn
                    >
                  </template>
                  <span>Continue</span>
                </v-tooltip>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
                </template>
                <!-- Expanded item-->
                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length" class="expanded-item">
                    <div class="expanded-item__header">
                      <span class="expanded-item__header-text">Status:</span>
                      <span class="expanded-item__header-value">{{ item.status }}</span>
                    </div>
                    
                    <div class="expanded-item__divider"></div>
                    <div class="expanded-item__header">
                      <span class="expanded-item__header-text">CreatedAt:</span>
                      <span class="expanded-item__header-value">{{ item.created_at }}</span>
                    </div>
                  </td>
                </template>

                <template v-slot:item.actions="{ item }">
                  <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
                  <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
                </template>

              </v-data-table>
            </div>
          </v-col>
        </v-row>
      </v-main>
    </v-layout>
  </v-card>
</template>



<script>
import SuperadminNavigation from "../Navigation/SuperadminNavigation.vue";
import axios from 'axios';

export default {
  components:{
    SuperadminNavigation: SuperadminNavigation,
  },
  data: () => ({
      successSnackbar: false,
      dialogDelete: false,
      dialog: false,
      search: '',
      headers: [
        { text: 'Patient', value: 'patient_id' },
        { text: 'Dentist', value: 'dentist_id' },
        { text: 'Date', value: 'date' },
        { text: 'Time', value: 'time' },
        { text: "Actions", value: "actions", sortable: false, align: "right" },
      ],
      expanded: [],
      appointments: [],
      patients: [],
      dentists: [],
      appointment_items:{
        patient_id:"",
        dentist_id:"",
        date:"", 
        time:"",   
        status: "active",
      },
      editedIndex: -1,
      defaultItem: {  
        patient_id:"",
        dentist_id:"",
        date:"", 
        time:"",   
        status:"", 
      },
      id:null,
      valid: false,
    
  }),
  computed: {
          formTitle() {
            return this.editedIndex === -1 ? "New Appointment Record" : "Edit Appointment Record";
          },
        },
        watch: {
          dialog(val) {
            val || this.close();
          },
          dialogDelete(val) {
            val || this.closeDelete();
          },
        },
        created() {
          this.initialize();
        },
        methods: {
          initialize() {
            this.AppointmentList();
            this.PatientList();
            this.DentistList();
          },
          async PatientList() {
            var res = await axios.get("/patients");
            if (res.status === 200 && res.data) this.patients = res.data;
            console.log(res.data);
          },
          async DentistList() {
            var res = await axios.get("/dentists");
            if (res.status === 200 && res.data) this.dentists = res.data;
            console.log(res.data);
          },
          addStatus() {
      if (this.appointment_items.status === 'cancelled') {
        this.appointment_items.status = 'active';
      } else {
        this.appointment_items.status = 'cancelled';
      }
    },

          logout() {
          axios.post('/logout')
            .then(response => {
              // Success message
              console.log(response.data.message);
              // Redirect to the login page
              this.$router.push('/login');
            })
            .catch(error => {
              console.log(error.response.data.message);
            });
        },
          
         
          async AppointmentList() {
            var res = await axios.get("/appointments");
            if (res.status === 200) this.appointments = res.data;
            else {
              this.$Notice.error({
                title: "Error",
                desc: "Error occurred while loading data",
              });
            }
          },
          editItem(item) {
            this.id = item.id;
            this.editedIndex = this.appointments.indexOf(item);
            this.appointment_items = Object.assign({}, item);
            this.dialog = true;
          },
          deleteItem(item) {
            this.id = item.id;
            this.dialogDelete = true;
          },
          async deleteItemConfirm() {
            var res = await axios.delete("/appointments/delete/" + this.id);
            if (res.status === 200) {
              this.AppointmentList();
              this.closeDelete();
            } else {
              this.$Notice.error({
                title: "Error",
                desc: "Error occurred while loading data",
              });
            }
          },
          close() {
            this.dialog = false;
            this.$nextTick(() => {
              this.appointment_items = Object.assign({}, this.defaultItem);
              this.editedIndex = -1;
            });
          },
          closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
              this.editedItem = Object.assign({}, this.defaultItem);
              this.editedIndex = -1;
            });
          },
          Submit() {
            if (this.$refs.form.validate()) {
              if (this.id) {
                axios
                  .put("/appointments/update/" + this.id, this.appointment_items)
                  .then((response) => {
                    this.AppointmentList();
                    this.close();
                  })
                  .catch((error) => {
                    this.$swal({
                    icon: "error",
                    title: "Email Already Taken!",
                })
                  });
              } else {
                axios
                  .post("/appointments/create", this.appointment_items)
                  .then((response) => {
                    this.AppointmentList();
                    this.close();
                    window.location.reload()
                  })
                  .catch((error) => {
                    this.$swal({
                    icon: "error",
                    title: "Email Already Taken!",
                })
                  });
                // this.close();
              }
            }
          },
        },
    };
    </script>
