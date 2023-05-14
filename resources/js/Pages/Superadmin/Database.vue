<style>
.table-row {
  padding: 20px;
}

</style>
<template>
  <v-card>
    <v-layout>
      <superadmin-navigation></superadmin-navigation>

        <v-main>
          <v-row class="table-row">
            <v-col>
              <v-toolbar-title>Databases</v-toolbar-title>
             
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
      
    };
  },
  computed: {
   
  },
  methods: {

  },
  mounted() {
   
  },
};
</script>