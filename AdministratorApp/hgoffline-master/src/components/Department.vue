<style>
@import '../assets/styles/style.css';
</style>

<template>
<div class="wrapper">

<div class="header">

<div title="tilbake til applikasjon" class="appAvd" v-on:click="goApplication()"><img src="../assets/icons/return-button.png" id="arrow"> APPLIKASJONER | </div>
<div class="appAvd">AVDELINGER | </div>

<div class="appAvd">{{this.selectedApplicationName}}</div> 
<button title="Logut" class="logout" v-on:click="logout()"> LOGG UT </button>
</div>

    <table id="showData" >
      <tr id="department" v-for="department in departments" :key="department.id">
        <th v-on:click="showform(department)">{{department.name}}
          </th>
          
        </tr>
        
    </table>

<div id="footer"> </div>
</div>
</template>

<script>
import Axios from "axios";
export default {
  name: "department",
  props: ["departmentId", "loggedIn", "numberOfApps", "loggedUsrDep", "applicationId", "depId", "selectedApplicationName"],
  mounted: function() {
    this.checkIfLoggedIn();
  },
  data() {
    return {
      departments: {}
    };
  },
  methods: {
    async checkIfLoggedIn(){
      if(this.loggedIn == true){
      this.showData();
      }else{
        this.$router.push({path:'./'});
      }
    
    },

    async showData() {
      const url = "https://db.hgnett.no:8080/fw2/hgoffline/php/service.php?module=departmentListFromApplication";
      
      const param = {applicationId:  this.applicationId}; 
      const response = await Axios.post(url, param, {withCredentials: true});
      this.departments = response.data;

    
    },

   async showform(department) {
      this.$router.push({ name: 'User', params: {depId: department.id, departmentName: department.name, applicationId: department.applicationId, loggedUsrDep: this.departmentId, loggedIn: this.loggedIn,  numberOfApps: this.numberOfApps, applicationId: this.applicationId} } );
 console.log(this.applicationId);
    },

    async logout(){
    const url = "https://db.hgnett.no:8080/fw2/hgoffline/php/service.php?module=logout";
        const response = await Axios.post(url, department.id, {withCredentials: true });
        this.$router.push({path:'./'});
    },
    async goApplication(){
    
      if(this.numberOfApps >1){
       this.$router.push({name:'Application', 
       params:{applicationId: this.applicationId, loggedUsrDep: this.loggedUsrDep, loggedIn: this.loggedIn, numberOfApps: this.numberOfApps,  departmentId: this.departmentId, depId: this.depId}});
           

    } 
  }}
};
</script>

<style scoped>
.appAvd{
  margin-top: 1%;
  display: inline-block;
  font-size: 20px;
  float: left; 
  margin-top: 1.05%;
  cursor: pointer; 

}
#appname{
margin-left: 45%;
text-align: inherit;
position:fixed;
font-size: 25px;
top: 2.8%;
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
#arrow{
  width: 16px;
  height: 15px;
  cursor: pointer;
 
}

.wrapper{
   width: 100%;
   height: 100%;
   font-family: Verdana;
   grid-gap: 5px;
   display: grid;
   grid-template-rows: auto;
}

.header{
    padding: 2%;
    background-image:linear-gradient(to bottom right, #006da5, #66ccff);
    height: 50px;
    text-align: left;
    color: whitesmoke;
    margin: 0;
    position: sticky;
}

a{  
    margin-top: 1%;
    display: inline-block;
    font-size: 20px;
    font-family: Verdana;
   
}
.logout{
    margin-top: 1%;
    display: inline-block;
    float: right;
    background-color: transparent;
    color: white;
    font-size: 20px;
    border: none;
    font-family: Verdana;
    width: 100px;
    cursor: pointer;
}

table{
    border-collapse: collapse;
    width: 100%;
}
#department{
  
    padding: 1%;
    display: grid;
    padding-top: 2%;
    font-size: 20px;
    border: none;
}

tr, th{
    padding: 5px;
    text-align: left;
    padding-left: 5%;
     cursor: pointer;
}

tr:nth-child(even) {background-color: #f2f2f2;} 

#footer{
  height: 40px;
  background-image: linear-gradient(to bottom right, #006da5, #66ccff);
}
</style>

