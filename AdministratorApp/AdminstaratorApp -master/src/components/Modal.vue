<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal" role="dialog">
        <header class="modal-header" id="modalTitle">
          <slot name="header">{{userData.name}}</slot>
        </header>

        <section class="modal-body" id="modalDescription">
          <slot name="body">
            <a id="passwordKode">Passord:</a>
            <br>

            <input type="password" placeholder="Skriv inn passord" v-model="userData.password">
            
            
            <br>
            <a id="passwordKode">Integrasjonskode:</a>
            <br>
            <input type="text" placeholder="Skriv inn ny integrasjonskode" v-model="userData.integrationCode">
          </slot>
           <ul>
      <li > {{ message }}</li>
        </ul>
        </section>

        <footer class="modal-footer">
          <slot name="footer">
            <button title="Lagre"
              class="btn-green"
              id="lagre"
              v-on:click="save()"
            >Lagre</button>
            <button title="Avbryt" class="btn-green" @click="close()">Avbryt</button>
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
import User from "./User.vue";
import Axios from "axios";

export default {
  name: "Modal",
  props: ["userData", "loggedIn", "loggedUsrDep", "departmentName", "depId", "applicationId", "numberOfApps"],
  mounted: function() {
    this.checkIfLoggedIn();
  },
  data() {
    return {
      message: ''
    };
  },

  methods: {
   
    async checkIfLoggedIn() {
      if (this.loggedIn == true) {
      } else {
        this.$router.push({ path: "./" });
      }
    },

    async close() {
      this.$emit("close");
      this.$router.push({name: "User",params: 
      {depId: this.userData.userDepId, loggedIn: this.loggedIn,
        loggedUsrDep: this.loggedUsrDep, 
        departmentName: this.departmentName, 
        depId: this.depId, 
        applicationId: this.applicationId, 
        numberOfApps: this.numberOfApps}});
      this.isModalVisible = false; 
  console.log("Close: " + this.applicationId);
    },

    async changePassword(userData) {
      userData.isChangingPassword = true;
      
        var newPassword = {
          newPassword: userData.password,
          selectedUser: userData.userId
        };
        console.log("NewPassword: ", newPassword);
        const editPasswordUrl =
          "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=editPassword";
        const response = await Axios.post(editPasswordUrl, newPassword, {
          withCredentials: true
        });
         this.message += 'Nytt passord lagret';
        userData.editMode = true;
      },
    
    async changeIntegrationCode (){
      var newIntegrationCode ={
         newIntegrationCode : this.userData.integrationCode, 
         selectedUser : this.userData.userId
      }

       const changeIntCodeUrl =
          "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=editIntegrationCode";
        const response = await Axios.post(changeIntCodeUrl, newIntegrationCode, {
          withCredentials: true
        });

    },
    async save() {
      const password = this.userData.password || '';
  
  if (password == '') {
    this.message += 'Fyll inn passord';
  }
    else (password != '') 
      this.changePassword(this.userData, this.reallyChange);
      this.close();
    
    }
,}}
</script>

<style>
#lagre {
  margin-top: 3%;
  margin-bottom: 5%;
  cursor: pointer;
}
a {
  padding-bottom: 4%;
  padding-top: 3%;
}

input {
  margin-top: 1%;
  margin-bottom: 3%;
  width: 220px;
  padding-top: 5px;
  padding-bottom: 6px;
}

#modalTitle {
  font-size: 20px;
  color: #006da5;
}

/* Modal */
.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-image: linear-gradient(to bottom right, #006da5, #66ccff);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal {
  background: #ffffff;
  box-shadow: 2px 2px 20px 1px;
  flex-direction: column;
}

.modal-header,
.modal-footer {
  padding: 15px;
}

.modal-header {
  border-bottom: 1px solid #006da5;
}

.modal-footer {
  border-top: 1px solid #006da5;
}

.modal-body {
  padding: 70px 150px;
  text-align: left;
}

.btn-green {
  padding: 2%;
  color: white;
  background: #006da5;
  border: 1px solid #006da5;
  border-radius: 2px;
  width: 150px;
   cursor: pointer;
}
tr th td {
  background-color: white;
}
</style>