<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  
}

body, html{
    width: 100%;
    height: 100%;
    font-family: Verdana;
   
}

*{
    /* box-sizing: border-box; */
    margin: 0;
    padding: 0;
    font-family: Verdana;
    list-style:none;
  }  
</style>
