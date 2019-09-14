<template>
  <div id="app">
    <component-navbar/>
    <router-view/>
  </div>
</template>
<script>
import Navbar from './views/Navbar'
export default {
  data(){
    return{

    }
  },
  components:{
    'component-navbar':Navbar
  }
}
</script>
<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
