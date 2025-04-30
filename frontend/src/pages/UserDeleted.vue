<template>
  <div class="user-deleted-container">
      <h1>User Deleted</h1>
      <p>The user {{ firstname }} {{ lastname }} has been successfully deleted.</p>
      <router-link to="/" class="home-button">Go Back to Home</router-link>
  </div>
</template>

<script>
export default {
  name: 'UserDeleted',
  props: {
      firstname: {
          type: String,
          required: true
      },
      lastname: {
          type: String,
          required: true
      }
  }
};
</script>

<style scoped>
.user-deleted-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  text-align: center;
  background-color: #f8f9fa;
  padding: 20px;
  box-sizing: border-box;
}

h1 {
  font-size: 2.5rem;
  color: #dc3545;
  margin-bottom: 20px;
}

p {
  font-size: 1.2rem;
  margin-bottom: 30px;
}

.home-button {
  display: inline-block;
  padding: 10px 20px;
  font-size: 1rem;
  color: #fff;
  background-color: #007bff;
  border-radius: 5px;
  text-decoration: none;
  transition: background-color 0.3s;
}

.home-button:hover {
  background-color: #0056b3;
}
</style>
