<template>
  <div class="container">
    <div class="construction-message">
      <h1>🚧 Under Construction 🚧</h1>
      <p>We are currently working on this page to improve your experience. Please check back later!</p>
      <p>Thank you for your patience!</p>
      <router-link to="/" class="btn btn-primary">Return to Home</router-link>
    </div>
    
  </div>

</template>

<script>
export default {
  name: "UnderConstruction",
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  text-align: center;
  background-color: #f9f9f9; /* Light background */
}

.construction-message {
  padding: 20px;
  border: 2px dashed #e91e63; /* Dashed border for a construction theme */
  border-radius: 10px;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #e91e63; /* Accent color for headings */
  margin-bottom: 15px;
}

p {
  color: #555; /* Grey text for additional messages */
  margin-bottom: 20px;
}

.btn {
  background-color: #007bff; /* Primary button color */
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
}

.btn:hover {
  background-color: #0056b3; /* Darker shade on hover */
}
</style>
