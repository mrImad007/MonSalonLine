
<script setup>
import { useClientStore } from '../stores/ClientStore';


const ClientStore = useClientStore();


var userRef = ClientStore.getuserRef;
var userName = ClientStore.getuserName;
console.log(userName);

const logout =()=>{
  localStorage.removeItem('userRef');
  window.location.href = "/login";
}

// userRef = null;
</script>

<template>
  <header class=". shadow">
    <h3>
      <router-link to="/"><img src="./SalonLogo.jpg" alt="" style="width: 200px; height: 70px;"></router-link>
    </h3>
    <nav>
      <router-link to="/reserve" class="userRef" v-if="userRef"><span style="color: white;">Welcome </span>{{userName}}</router-link>
    </nav>
    <div class="menu">
      <router-link to="/">Home</router-link>
      <router-link v-if="userRef" to="/Rdv">mes RDVs</router-link>
      <router-link v-if="!userRef" to="/login"><button>Login</button></router-link>
      <a v-if="userRef" href="#"  @click="logout">logout</a>
      <router-link v-if="!userRef" to="/register">Register</router-link>
    </div>
  </header>
</template>

<style  scoped>
header {
  display: flex;
  width: 100%;
  height: 10vh;
  justify-content: space-between;
  align-items: center;
  padding: 0 1rem ;
  background-color: black;
  color: #fff;
  position: sticky;
}

nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  color: #fff;
  margin: 30px;
}
 nav a{
  color: #fff;
  text-decoration: none;
}

.userRef{
  color:  rgb(13, 142, 228);
}

.menu{
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
}

.menu :hover{
  color: rgb(13, 142, 228);
  text-decoration: none;
}

</style>
