<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Customer Support</h2>
    <p>We are here to help! If you have any questions, concerns, or need assistance, please don't hesitate to reach out to us through any of the following methods:</p>
    
    <div class="support-item">
      <h5>Contact Us via Phone</h5>
      <p>For immediate assistance, call our customer support hotline:</p>
      <p><strong>Phone:</strong> +254 123 456 789</p>
      <p>Our support team is available from 8 AM to 8 PM (EAT) every day.</p>
    </div>

    <div class="support-item">
      <h5>Send Us an Email</h5>
      <p>You can reach us by sending an email to:</p>
      <p><strong>Email:</strong> support@buildingmanagement.com</p>
      <p>We aim to respond to all email inquiries within 24 hours.</p>
    </div>

    <div class="support-item">
      <h5>Live Chat Support</h5>
      <p>For instant assistance, use our live chat feature available on our website.</p>
      <p>Our live chat is operational from 8 AM to 10 PM (EAT).</p>
    </div>

    <div class="support-item">
      <h5>Frequently Asked Questions (FAQ)</h5>
      <p>Before reaching out, check our <router-link to="/faq">FAQ page</router-link> for common queries and their answers.</p>
    </div>

    <div class="support-item">
      <h5>Visit Our Office</h5>
      <p>If you prefer face-to-face assistance, visit our office:</p>
      <p><strong>Address:</strong> Building Management System Office, Nairobi, Kenya</p>
      <p>Office Hours: Monday to Friday, 9 AM to 5 PM (EAT).</p>
    </div>

    <div class="support-item">
      <h5>Feedback and Suggestions</h5>
      <p>Your feedback helps us improve our services. If you have any suggestions, please share them through our contact channels.</p>
    </div>
  </div>
  <br>
  <Backbutton/>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  name: "CustomerSupport",
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}

.support-item {
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #eaeaea;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.support-item h5 {
  margin-bottom: 10px;
  color: #007bff; /* Use a color that stands out, like blue */
}
</style>
