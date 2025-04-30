<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Privacy Policy</h2>
    <p>Your privacy is important to us. We are committed to protecting your personal information.</p>
    <h5>Information Collection:</h5>
    <p>We collect personal information when you book a room or contact us.</p>
    <h5>Use of Information:</h5>
    <p>Your information may be used to process transactions, improve our services, or send periodic emails.</p>
    <h5>Data Security:</h5>
    <p>We implement various security measures to protect your personal information.</p>
  </div>
  <Backbutton/>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  name: "PrivacyPolicy",
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}
</style>
