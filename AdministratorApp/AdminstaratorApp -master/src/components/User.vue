<style>
@import "../assets/styles/style.css";
</style>
<template>
  <div class="wrapper">
    <div class="topnav">

      <div title="Bytt avdeling" class="appAvd" v-if="isSuper" v-on:click="goDepartment()">
        <img src="../assets/icons/return-button.png" id="arrow">AVDELING
      </div>
      <div class="appAvd">| BRUKERE | </div>
      
      <div class="appAvd">{{this.departmentName}}</div>
      
      <button title="Logout" class="logout" v-on:click="logout()">LOGG UT</button>
      <button title="Ny bruker" class="logout" v-on:click="newUser(user)">NY BRUKER |</button>

    </div>

    <div id="user">
      <div id="showuser">
        <table>
          <tr>
            <th>Navn</th>
            <th>Brukernavn</th>
            <th>Kode</th>
            <th>Integrasjonskode</th>
            <th>Status</th>
            <th></th>
          </tr>
          <tr v-for="user in users" :key="user.id">
            <td>{{user.name}}</td>
            <td>{{user.username}}</td>
            <td>{{user.code}}</td>
            <td>{{user.integrationcode}}</td>
            <td v-bind:class="computedColor(user.activated)">{{printactivated(user.activated)}}</td>

            <td>
              <img
                title="Rediger bruker"
                src="../assets/icons/edit.png"
                id="png"
                v-on:click="selectUser(user)"
              >
              <img
                title="Generer kode"
                src="../assets/icons/refresh.png"
                id="png"
                v-on:click="generateCode(user)"
              >
              <img
                title="Slett bruker"
                src="../assets/icons/cancel.png"
                id="png"
                v-on:click="deleteUser(user)"
              >
            </td>
          </tr>
        </table>
      </div>
      <div id="footer"></div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import Modal from "./Modal.vue";

export default {
  name: "User",
  props: [
    "depId",
    "departmentName",
    "appId",
    "loggedUsrDep",
    "loggedIn",
    "numberOfApps",
    "applicationId"
  ],
  components: {
    Modal
  },

  mounted: function() {
    this.checkIfLoggedIn();
  },

  data() {
    return {
      user: "",
      users: [],
      code: "",
      integrationcode: "",
      isModalVisible: false,
      isSuper: false
    };
  },
  methods: {
    async checkIfLoggedIn() {
      if (this.loggedIn == true) {
        this.getData();
      } else {
        this.$router.push({ path: "./" });
      }
    },

    computedColor: function(num) {
      switch (num) {
        case "-1":
          return "stateDemo";
        case "0":
          return "stateInprogress";
        case "1":
          return "stateAcive";
        case "100":
          return "stateWeb";
        default:
          return "stateError";
      }
    },
    printactivated(num) {
      switch (num) {
        case "-1":
          return "Demo";
        case "0":
          return "Avventer";
        case "1":
          return "Aktiv";
        case "100":
          return "Web";
        default:
          return "Error";
      }
    },
    async getData() {
      const url =
        "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=user";
     

      const response = await Axios.post(
        url,
        { departmentId: this.depId, applicationId: this.appId },
        { withCredentials: true }
      );
     
      this.users.length = 0;
      for (let user of response.data) {
        user.editMode = false;
        user.isDeleting = false;
        user.confirmDelete = false;
        user.password = "";
        user.isChangingPassword = false;
        user.matchPassword = "";
        this.users.push(user);
      }

      if (this.loggedUsrDep == -1) {
        this.isSuper = true;
      } else {
        this.isSuper = false;
      }
    },
    async selectUser(user) {
      var userObj = {
        userId: user.id,
        name: user.name,
        integrationcode: user.integrationcode,
        code: user.code,
        password: user.password,
        matchPassword: user.matchPassword,
        activated: user.activated,
        userDepId: user.dep_id
      };

      this.$router.push({
        name: "Modal",
        params: {
          userData: userObj,
          loggedIn: this.loggedIn,
          loggedUsrDep: this.loggedUsrDep,
          departmentName: this.departmentName,
          depId: this.depId,
          applicationId: this.applicationId,
          numberOfApps: this.numberOfApps
        }
      });
      this.isModalVisible = true;
    },
    async closeModal() {
      this.isModalVisible = false;
    },

    async deleteUser(user) {
      var confirmBox = confirm("Sikker på at du vil slette brukeren?");
      if (confirmBox == true) {
        {
          user.confirmDelete = true;
        }

        if (user.confirmDelete) {
          var deActivate = {
            deActivateUser: user.confirmDelete,
            selectedUser: user.id
          };
         
          const deActivateUserUrl =
            "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=deActivate";
          const response = await Axios.post(deActivateUserUrl, deActivate, {
            withCredentials: true
          });
          this.getData();
        } else {
          user.editMode = true;
        }
      }
    },

    async generateCode(user) {
      var selectedUserId = {
        selectedUserId: user.id
      };
      const editUserUrl =
        "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=editCode";

      const response = await Axios.post(editUserUrl, selectedUserId, {
        withCredentials: true
      });

      user.code = response.data;
    },

    async logout() {
      const url =
        "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=logout";
      const response = await Axios.post(url, user.id, {
        withCredentials: true
      });
      this.$router.push({ path: "/" });
    },

    async newUser(user) {
     
      this.$router.push({
        name: "NewUser",
        params: {
          loggedIn: this.loggedIn,
          loggedUsrDep: this.loggedUsrDep,
          loggedUsrApp: this.appId,
          depId: this.depId,
          departmentName: this.departmentName,
          applicationId: this.applicationId,
          numberOfApps: this.numberOfApps
        }
      });
    },

    async goDepartment() {
      if ((this.loggedUsrDep = -1)) {
        this.$router.push({
          name: "Department",
          params: {
            numberOfApps: this.numberOfApps,
            departmentId: this.loggedUsrDep,
            loggedIn: this.loggedIn,
            loggedUsrDep: this.departmentId,
            applicationId: this.applicationId,
            departmentName: this.departmentName
          }
        });
        console.log(
          "Tilbake til departemn fra user (loggedUserDep: ",
          this.loggedUsrDep
        );
      } else {
        this.logout();
      }
    }
  }
};
</script>

<style scoped >
.appAvd{
  margin-top: 1%;
  display: inline-block;
  font-size: 20px;
  float: left; 
  cursor: pointer; 
}

button {
  margin-top: 1%;
  float: right;
  background-color: transparent;
  color: white;
  font-size: 20px;
  border: none;
  font-family: Verdana;
  width: 140px;
  cursor: pointer;
}

#arrow {
  width: 16px;
  height: 15px;
  cursor: pointer;
  padding-right: 2px;
}

#depname {
  margin-left: 35%;
  margin-bottom: 5px;
  text-align: inherit;
  position: fixed;
  font-size: 25px;
}
#png {
  width: 35px;
  height: 35px;
  margin-left: 10px;
  align: right;
  cursor: pointer;
}

.users {
  display: inline;
  float: left;
  margin-left: 1%;
  margin-top: 2px;
}
.departmentLink {
  display: inline;
  float: left;
  margin-left: 1%;
  cursor: pointer;
}
.wrapper {
  grid-gap: 5px;
  display: grid;
  grid-template-rows: auto;
  width: 100%;
  height: 100%;
  font-family: Verdana;
}

.topnav {
  padding: 2%;
  background-image: linear-gradient(to bottom right, #006da5, #66ccff);
  height: 50px;
  text-align: left;
  color: whitesmoke;
  margin: 0;
  position: sticky;
}

a {
 margin-top: 1%;
    display: inline-block;
    font-size: 20px;
    font-family: Verdana;
}

table {
  border-collapse: collapse;
  width: 100%;
}

tr,
th {
  text-align: left;
  padding-left: 1%;
  padding-bottom: 1%;
  padding-top: 1%;
}

td {
  text-align: left;

  padding-left: 1%;
  padding-bottom: 1%;
  padding-top: 1%;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
.stateDemo {
  color: gray;
}
.stateAcive {
  color: #1fce1c;
}
.stateInprogress {
  color: #ff8000;
}
#footer {
  height: 40px;
  background-image: linear-gradient(to bottom right, #66ccff, #006da5);
}
</style>
