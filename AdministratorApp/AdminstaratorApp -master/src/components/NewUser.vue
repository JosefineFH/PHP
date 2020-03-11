<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal" role="dialog">
        
        <header class="modal-header" id="modalTitle">
          <a>NY BRUKER</a>
        </header>

        <section class="modal-body" id="modalDescription">
          <a>Navn:</a>
          <br>
          <input  id="visualName" type="text" v-model="visualName">
          <br>
          <a>Brukernavn:</a>
          <br>
          <input id="userName" type="text" v-model="userName" >
          <br>
          <a>Passord:</a>
          <br>
          <input id="newUserPassword"  v-model="newUserPassword">
          <br>
          <a>Integrasjonskode:</a>
          <br>
          <input id="intCode" type="text"  v-model="intCode">
         
          <ul>
      <li >{{ message }}</li>
        </ul>
        </section>

        <footer class="modal-footer">
          <slot name="footer">
            <button title="Lagre" class="btn-green" v-on:click="save()" >Lagre</button>
            <button title="Avbryt" class="btn-green" v-on:click="cancel()">Avbryt</button>           
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
   name: "NewUser",
   props: ["loggedUsrDep", "loggedUsrApp", "loggedIn", "depId", "appId", "departmentName", "applicationId", "numberOfApps"],
   mounted: function() {

   },
   data() {
     return {
       message: '',
       visualName: null,
       userName: null,
       newUserPassword: null,
       intCode: null
     };
   },

   methods: {
     async save() {
       if(visualName.value == "" || userName.value == "" || newUserPassword.value == ""){
         this.message += 'Alle felt må være utfylt for å lagre.';
         

       } else{
          this.message += 'Ny bruker opprettet.';

          var newUser = {
            visualName : visualName.value,
            userName :userName.value,
            newUserPassword : newUserPassword.value,
            intCode : intCode.value, 
            departmentId : this.depId,
            applicationId : this.applicationId
          }
           console.log("this.applicationId i NEWuser: ", this.applicationId);
          const url = "https://localhost:8080/fw2/adminstaratorApp/php/service.php?module=newUser";
          const response = await Axios.post(url, newUser, {withCredentials: true}); 
          
      }
      
         this.clear(); 
         this.cancel();  
     },
     async clear(){
        visualName.value = '',
        userName.value = '',
        newUserPassword.value = '',
        intCode.value = ''
     },

     async cancel() {
      this.$emit("close"); 
      
      this.$router.push({ name: "User", params: { depId:this.depId, loggedUsrDep: this.loggedUsrDep,  
      loggedIn: this.loggedIn, appId: this.loggedUsrApp, departmentName: this.departmentName, applicationId: this.applicationId, numberOfApps: this.numberOfApps} 
      });
      this.isModalVisible = false;
      
    },
   }
 };
</script>

<style>
#lagre {
  margin-top: 3%;
  margin-bottom: 14%;
}
#passwordKode,
#code {
  padding-bottom: 4%;
  padding-top: 2%;
}

input {
  margin-top: 3%;
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
  padding: 4%;
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