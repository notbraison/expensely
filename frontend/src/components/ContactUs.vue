<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Contact Us</h2>
    <p>If you have any questions or need assistance, please reach out to us:</p>
    <p><strong>Email:</strong> support@example.com</p>
    <p><strong>Phone:</strong> +254 123 456 789</p>
    <p><strong>Address:</strong> Nairobi, Kenya</p>
    <h5>Send us a message:</h5>
    <form @submit.prevent="sendMessage">
      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" class="form-control" id="name" v-model="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Your Email</label>
        <input type="email" class="form-control" id="email" v-model="email" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" v-model="message" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
  </div>
  <Backbutton/>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  data() {
    return {
      name: '',
      email: '',
      message: '',
    };
  },
  methods: {
    sendMessage() {
      // Implement message sending logic here
      alert(`Message sent from ${this.name}!`);
    }
  }
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}
</style>
