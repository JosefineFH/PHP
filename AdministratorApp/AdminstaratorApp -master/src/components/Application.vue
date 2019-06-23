<style>
@import "../assets/styles/style.css";
</style>

<template>
  <div class="wrapper">
    <div class="header">
      <div class="application">APPLIKASJONER</div>
      <button title="Logut" class="logout" v-on:click="logout()">LOGG UT</button>
    </div>

    <table id="showData">
      <tr id="application" v-for="application in applications" :key="application.id">
        <th v-on:click="showform(application)">{{application.name}}</th>
      </tr>
    </table>

    <div id="footer"></div>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  name: "application",
  props: [
    "applicationId",
    "loggedIn",
    "departmentId",
    "numberOfApps",
    "loggedUsrDep",
    "appId",
    "depId"
  ], 
  mounted: function() {
    this.checkIfLoggedIn();
  },
  data() {
    return {
      applications: {}
    };
  },
  methods: {
    async checkIfLoggedIn() {
      if (this.loggedIn == true) {
        this.showData();
      } else {
        this.$router.push({ path: "./" });
      }
    },

    async showData() {
      const url =
        "https://db.hgnett.no:8080/fw2/hgoffline/php/service.php?module=applicationList";

      const response = await Axios.post(
        url,
        { application: this.applications },
        { withCredentials: true }
      ); 
      this.applications = response.data;

    },

    async showform(application) {

      this.$router.push({
        name: "Department",
        params: {
          applicationId: application.appId,
          selectedApplicationName: application.name,
          departmentId: this.departmentId,
          loggedIn: this.loggedIn,
          numberOfApps: this.numberOfApps,
          loggedUsrDep: this.departmentId
        }
      });
    },

    async logout() {
      const url =
        "https://db.hgnett.no/fw2/hgoffline/php/service.php?module=logout";
      const response = await Axios.post(url, { withCredentials: true });
      this.$router.push({ path: "./" });
    }
  }
};
</script>

<style scoped>
.wrapper {
  width: 100%;
  height: 100%;
  font-family: Verdana;
  grid-gap: 5px;
  display: grid;
  grid-template-rows: auto;
}

.header {
  padding: 2%;
  background-image: linear-gradient(to bottom right, #006da5, #66ccff);
  height: 50px;
  text-align: left;
  color: whitesmoke;
  margin: 0;
  position: sticky;

}
 .application {
  display: inline;
  position: relative;
  margin-top: 1%;
  float: left;
  background-color: transparent;
  font-size: 25px;
  cursor: pointer;
} 
a {
  margin-top: 1%;
  display: inline-block;
  font-size: 25px;
  font-family: Verdana;
  padding-left: 3%;
}
button {
  margin-top: 1%;
  float: right;
  background-color: transparent;
  color: white;
  font-size: 25px;
  border: none;
  font-family: Verdana;
  width: 150px;
  cursor: pointer;
} 

table {
  border-collapse: collapse;
  width: 100%;
}
#department {
  padding: 1%;
  display: grid;
  padding-top: 2%;
  font-size: 20px;
  border: none;
}

tr,
th {
  padding: 5px;
  text-align: left;
  padding-left: 5%;
  cursor: pointer;
}

th {
  padding: 1%;
  display: grid;
  padding-top: 2%;
  font-size: 20px;
  border: none;
  padding-left: 5%;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

#footer {
  height: 40px;
  background-image: linear-gradient(to bottom right, #006da5, #66ccff);
}
</style>

