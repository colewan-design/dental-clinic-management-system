<style>
.nav-links .v-list-item {
  padding-top: 16px; /* adjust the value as needed */
  padding-bottom: 16px; /* adjust the value as needed */
}


</style>

<template>
  <main>
    <v-card>
      <v-layout>
        <v-navigation-drawer style="background-color: #009EFF;">
          <v-list-item class="px-2">
            <v-list-item>
              <v-list-item-avatar style="height: 100px; margin: 20px auto; width: 100px; display: block;">
                <img src="./img/superadmin.png">
              </v-list-item-avatar>
            </v-list-item>
          </v-list-item>
          <v-divider></v-divider>
  
              <v-list dense class="nav-links">
              <!-- Super Admin Dashboard -->
              <v-list-item to="/Superadmin_Dashboard">
                <v-list-item-icon>
                  <v-icon color="white">mdi-view-dashboard</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Dashboard</v-list-item-title>
              </v-list-item>

              <!-- Teachers Information -->
              <v-list-item to="/patients">
                <v-list-item-icon>
                  <v-icon color="white">mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Patients</v-list-item-title>
              </v-list-item>

              <!-- Students Information -->
              <v-list-item to="/dentists">
                <v-list-item-icon>
                  <v-icon color="white">mdi-tooth-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Dentists</v-list-item-title>
              </v-list-item>

              <!-- Parents Information -->
              <v-list-item to="/appointments">
                <v-list-item-icon>
                  <v-icon color="white">mdi-calendar-clock</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Appointments</v-list-item-title>
              </v-list-item>

              <!-- Staff Information -->
              <v-list-item to="/sessions">
                <v-list-item-icon>
                  <v-icon color="white">mdi-account-multiple-check</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Sessions</v-list-item-title>
              </v-list-item>

              <v-list-item to="/sessions">
                <v-list-item-icon>
                  <v-icon color="white">mdi-cog</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Settings</v-list-item-title>
              </v-list-item>

              <v-list-item to="/sessions">
                <v-list-item-icon>
                  <v-icon color="white">mdi-hospital-building</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Clinic</v-list-item-title>
              </v-list-item>

              <v-list-item to="/sessions">
                <v-list-item-icon>
                  <v-icon color="white">mdi-database</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="text-uppercase" style="color: white;">Database</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-navigation-drawer>
        </v-layout>
      </v-card>
      </main>
    </template>

<script>
export default {
  data() {
    return {
      showLogoutModal: false,
      userName: '',
      email: '',
      dialog: false,
    };
  },
  mounted() {
    const authToken = localStorage.getItem('auth_token');

    axios.get('/user', {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        this.userName = response.data.name;
        this.email = response.data.email;
    })
    .catch(error => {
        console.error(error);
        if (error.response.status === 401) {
            window.location.href = '/'; // Redirect to login page
        }
    });
},
  name: 'SuperadminNavigation',
  components: {},
  methods: {
    logout() {
        const authToken = localStorage.getItem('auth_token');
        axios.post('/logout', null, {
            headers: {
                'Authorization': `Bearer ${authToken}`
            },
            withCredentials: true
        })
        .then(response => {
            // handle successful logout
            window.location.href = '/';
        })
        .catch(error => {
            // handle logout error
        });
        // Hide the modal
    this.showLogoutModal = false;
    },
},
};
</script>

