<template>
    <div>
      <h1>Log out</h1>
      <br>
      <p>Are you sure you want to log out?</p>
      <br>
      <button @click="logout" class="btn btn-outline-success btn-lg">Yes</button>
      &nbsp;
      &nbsp;
      <router-link to="/"><button  class="btn btn-outline-danger btn-lg">No</button></router-link>
      
    </div>
  </template>
  
  <script>
import axios from 'axios';


  export default {
    name:"Logout",
    methods: {
  async logout() {
    try {
      await axios.post("http://127.0.0.1:8000/api/logout");
      alert("You are logged out");
      this.$router.push({ name: 'Login' });
    } catch (error) {
      console.error('Logout failed:', error);
      // Handle logout failure, e.g., show an error message
    }
  }
}

  };
  </script>
  
  <style>
  
  </style>
  