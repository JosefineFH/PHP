<template>
  <div class="wrapper" >
    
    <div id="header">
    <img id="logo" src="../assets/hg.png" >
    </div>
    
    <br>
<div id="contant">
    <div id="login">
        <input id="name"  v-on:keyup.enter="submit()" type="text" v-model="username" placeholder="Brukernavn">
        <br>
        <input id="password"  v-on:keyup.enter="submit()" type="password" v-model="password" placeholder="Passord">
        <br>
        <button title="Login" id="submit" @click="submit()">Login</button> <br>
        <a>{{errorMessage}}</a>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import Department from '@/components/Department';

export default {
  name: "Login",
  props: ["index"],
  data() {
    return {
        username: "",
        password: "",
        errorMessage: '',
        depId: null,
        appId: null,
        numberOfApps:'' 
    };
  }, 
  components:{
    departmentPage: Department
  },
  methods: {
    submit: async function(event) {
      var inputValues = {
        username: this.username,
        password: this.password
      };
     
      try {
        const url = "https://db.hgnett.no:8080/fw2/hgoffline/php/service.php?module=login";
        const response = await Axios.post(url,inputValues, {withCredentials: true});
       
                this.message = response.data.success;
                this.depId = response.data.departmentId;
                this.appId = response.data.applicationId;
                this.numberOfApps = response.data.countedIDs;

        // Gjøre bedre flyt i routinga nå som det kommer en application side inn. 
if(this.numberOfApps > 1){
this.$router.push({ name: 'Application', params: { departmentId: this.depId, loggedIn: this.message, applicationId: this.appId, numberOfApps: this.numberOfApps } })
       
}
else{
  
    if(this.depId == -1){
        this.$router.push({ name: 'Department', params: { departmentId: this.depId, loggedIn: this.message, applicationId: this.appId,  } })
          
        }else if(this.depId >= 0) {
          this.$router.push({ name: 'User', params: { depId: this.depId, appId: this.appId,loggedIn: this.message } })
        }
        else if(this.message == false){
          this.errorMessage = "Feil passord og/eller brukernavn";
        }
      }

      } catch (error) {
           error;
      } 
     
    }
    }
  
};

</script>

<style scope>
  .wrapper{
display: grid;
display: inline-grid;
grid-gap: 5px;
grid-template-rows: auto;
}

#header{
    padding-top: 50%;
    
}

#name{
    padding: 15px;
    width: 60%;
    border: none;
    border-bottom: 1px solid gray;
    text-align: center;
}

#password{
    padding: 15px;
    width: 60%;
    border: none;
    border-bottom: 1px solid gray;
    text-align: center;
}

#submit{
    margin-top: 20px;
    width: 120px;
    height: 35px ;
    background-color: #006da5;
    border: none;
    color: whitesmoke;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
}
</style>