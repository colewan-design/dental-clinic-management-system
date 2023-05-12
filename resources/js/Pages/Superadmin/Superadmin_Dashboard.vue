<template>
  <v-card>
    <v-layout>
      <superadmin-navigation></superadmin-navigation>

        <v-main>
          <v-row>
            <v-col>
              <v-toolbar-title>Student Attendance</v-toolbar-title>
              <v-data-table :headers="headers" :items="students" :search="search" hide-default-footer>
                <template v-slot:top>
                  <v-row>
                    <v-col cols="12" md="4">
                      <v-text-field v-model="search" label="Search" clearable></v-text-field>
                    </v-col>
                    <v-col cols="12" md="8" class="d-flex justify-end">
                        <v-btn color="primary" @click="submitAttendance">Add Attendance</v-btn>
                  
                    </v-col>
                  </v-row>
                </template>
                <template v-slot:item.present="{ item }">
                  <v-switch v-model="item.present" :disabled="item.locked"></v-switch>
                </template>
              </v-data-table>
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
  data() {
    return {
      successSnackbar: false,
      selectedDate: new Date().toISOString().substr(0, 10),
      search: '',
      headers: [
        { text: 'First Name', value: 'first_name' },
        { text: 'Middle Name', value: 'middle_name' },
        { text: 'Last Name', value: 'last_name' },
        { text: 'Present', value: 'present', sortable: false },
        ],

      students: [],
    };
  },
  computed: {
    selectedDateString() {
      return new Date(this.selectedDate).toLocaleDateString();
    },
  },
  methods: {
    submitAttendance() {
    const authToken = localStorage.getItem('auth_token');
    const date = this.selectedDate;
    const students = this.students.map((student) => {
        return {
        id: student.account_id,
        present: student.present,
        };
    });

    axios.post('/attendance/saveAttendance', { date, students }, {
        headers: {
        'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
      
        console.log(response.data);
        this.successMessage = 'Saved successfully!';
      this.successSnackbar = true; // Display success snackbar
    })
    .catch(error => {
        console.error(error);
    });
    },

    loadStudents() {
  const authToken = localStorage.getItem('auth_token');
  axios.get('/students/students', {
    headers: {
      'Authorization': `Bearer ${authToken}`
    }
  })
  .then(response => {
    this.students = response.data.map(student => ({
      ...student,
        present: true, // Add the present key and set its default value to true
        }));
    })
    .catch(error => {
        console.error(error);
        if (error.response.status === 401) {
        window.location.href = '/'; // Redirect to login page if user is unauthorized
        }
    });
    },

    markAllPresent() {
      this.students.forEach((student) => {
        if (!student.locked) {
          student.present = true;
        }
      });
    },
    markAllAbsent() {
      this.students.forEach((student) => {
        if (!student.locked) {
          student.present = false;
        }
      });
    },
  },
  mounted() {
    this.loadStudents();
  },
};
</script>