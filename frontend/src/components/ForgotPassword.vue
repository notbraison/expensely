<template>

  <div class="loginform">
    <h2 class="card-title">Forgotten Password</h2>
    <form @submit.prevent="resetPassword">
      <div class="card">

        <div class="card-body">

          <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com" v-model="email" required>
        </div>

        <div class="mb-3">
        <label class="form-label"  for="newPassword">New Password</label>
        <input type="password" id="newPassword" class="form-control"  placeholder="new password" v-model="newPassword" required>
        </div>

        <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirmPassword" placeholder="name@example.com"  v-model="confirmPassword" required>
        </div>

        <div class="btn-container">
          <button type="submit" class="btn btn-primary">Reset Password</button>
        </div>

        </div>

        

      </div>
          
    </form>
  </div>

</template>

<script>
import axios from 'axios';

export default {
  name:'ForgotPassword',
  data() {
    return {
      email:"",
      newPassword: "",
      confirmPassword: "",
      response:'',
      request:'',
    };
  },
  methods: {
    async resetPassword() {
  try {
     request = await axios.put('http://127.0.0.1:8000/api/users', {
      email: this.email,
      password: this.password,
      confirmpassword: this.confirmPassword,
    });

    if (request.status === 200) {
      // Check if the request contains a 'message' field
      if (request.data && request.data.message) {
        const message = request.data.message;
        this.displayAlert(message);
        this.executeWithDelay();
      } else {
        console.error('Password reset successful, but message not received from the backend.');
      }
    } else {
      console.error('Password reset failed. Status code:', request.status);
    }
  } catch (error) {
    console.error('Axios error:', error);
  }
},
    displayAlert(message){
      alert(message);
    },

    executeWithDelay() {
      // Delay in milliseconds 
      const delay = 5000;

      // introduce a delay before executing the command
      setTimeout(() => {
        // The code to execute after the delay
        this.performCommand();
      }, delay);
    },
    performCommand() {
      // This is the command  to execute after the delay
      this.$router.push('/login')
      console.log("Command executed after delay.");
    },
    
  },
};
</script>

<style >


</style>
