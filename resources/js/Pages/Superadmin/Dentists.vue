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
            <v-toolbar-title>Dentists</v-toolbar-title>
           
            <div class="table-container">
              <v-data-table
                :headers="headers"
                :items="dentists"
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

                    <!-- Name field -->
                    <v-card-text class="px-5">
                      <v-text-field
                        label="Name"
                        v-model="dentist_items.name"
                        prepend-inner-icon="mdi-account"
                        required
                      ></v-text-field>
                    </v-card-text>

                    <!-- Phone field -->
                    <v-card-text class="px-5">
                      <v-text-field
                        label="Phone"
                        v-model="dentist_items.phone"
                        prepend-inner-icon="mdi-phone"
                        type="tel"
                        required
                      ></v-text-field>
                    </v-card-text>

                    <!-- Email field -->
                    <v-card-text class="px-5">
                      <v-text-field
                        label="Email"
                        v-model="dentist_items.email"
                        prepend-inner-icon="mdi-email"
                        type="email"
                        required
                      ></v-text-field>
                    </v-card-text>

                    <!-- Gender field -->
                    <v-card-text class="px-5">
                      <v-autocomplete
                        :rules="[v => !!v || 'Field is required']"
                        :items="['female', 'male']"
                        label="Gender"
                        v-model="dentist_items.gender"
                        prepend-icon="mdi-gender-male-female"
                        required
                      ></v-autocomplete>
                    </v-card-text>

                    <!-- Address field -->
                    <v-card-text class="px-5">
                      <v-text-field
                        label="Address"
                        v-model="dentist_items.address"
                        prepend-inner-icon="mdi-map-marker"
                        required
                      ></v-text-field>
                    </v-card-text>

                  

                    <!-- DOB field -->
                    <v-card-text class="px-5">
                      <v-text-field
                        label="Date of Birth"
                        v-model="dentist_items.DOB"
                        prepend-inner-icon="mdi-calendar"
                       
                        required
                      ></v-text-field>
                    </v-card-text>

                    <v-card-actions class="px-5">
                      <v-spacer></v-spacer>

                      <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            x-small
                            fab
                            dark
                            color="primary"
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
                        <span>Save</span>
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
                        <span>Cancel</span>
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
                      <span class="expanded-item__header-text">Address:</span>
                      <span class="expanded-item__header-value">{{ item.address }}</span>
                    </div>
                    <div class="expanded-item__divider"></div>
                    <div class="expanded-item__header">
                      <span class="expanded-item__header-text">Date of Birth:</span>
                      <span class="expanded-item__header-value">{{ item.DOB }}</span>
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
        { text: 'Name', value: 'name' },
        { text: 'Phone', value: 'phone' },
        { text: 'Email', value: 'email' },
        { text: 'Gender', value: 'gender' },
        { text: "Actions", value: "actions", sortable: false, align: "right" },
      ],
      expanded: [],
      dentists: [],
      dentist_items:{
        name:"",
        phone:"",
        gender:"", 
        address:"",   
        email:"",
      },
      editedIndex: -1,
      defaultItem: {  
        name:"",
        phone:"",
        gender:"", 
        address:"",   
        email:"",  
      },
      id:null,
      valid: false,
    
  }),
  computed: {
          formTitle() {
            return this.editedIndex === -1 ? "New Dentist Record" : "Edit Dentist Record";
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
          initialize() {
            this.DentistList();
          
          },
         
          async DentistList() {
            var res = await axios.get("/dentists");
            if (res.status === 200) this.dentists = res.data;
            else {
              this.$Notice.error({
                title: "Error",
                desc: "Error occurred while loading data",
              });
            }
          },
          editItem(item) {
            this.id = item.id;
            this.editedIndex = this.dentists.indexOf(item);
            this.dentist_items = Object.assign({}, item);
            this.dialog = true;
          },
          deleteItem(item) {
            this.id = item.id;
            this.dialogDelete = true;
          },
          async deleteItemConfirm() {
            var res = await axios.delete("/dentists/delete/" + this.id);
            if (res.status === 200) {
              this.DentistList();
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
              this.dentist_items = Object.assign({}, this.defaultItem);
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
                  .put("/dentists/update/" + this.id, this.dentist_items)
                  .then((response) => {
                    this.DentistList();
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
                  .post("/dentists/create", this.dentist_items)
                  .then((response) => {
                    this.DentistList();
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
