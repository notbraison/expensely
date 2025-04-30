<template>
  <div class="back-button-container">
    <button class="back-button" @click="goBack">
      Back
    </button>
  </div>
</template>

<script>
export default {
  name: 'BackButton',
  methods: {
    goBack() {
      this.$router.go(-1); // Go back to the previous page
    }
  }
}
</script>

<style scoped>
.back-button-container {
  display: flex;
  justify-content: center; /* Center horizontally */
  margin-top: 20px; /* Optional: Add some margin from the top */
}

.back-button {
  display: flex;
  align-items: center;
  background-color: #007bff; /* Primary color */
  color: white; /* Text color */
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  cursor: pointer;
  font-size: 1em;
  transition: background-color 0.3s ease;
}

.back-button:hover {
  background-color: #0056b3; /* Darker shade for hover effect */
}
</style>
