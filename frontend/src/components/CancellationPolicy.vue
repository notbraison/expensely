<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Cancellation Policy</h2>
    <p>Your satisfaction is our priority. Please take a moment to review our cancellation policy:</p>
    
    <div class="policy-item">
      <h5>Free Cancellation</h5>
      <p>Guests can cancel their reservation without any penalty within 24 hours of booking.</p>
    </div>

    <div class="policy-item">
      <h5>Cancellation within 7 Days</h5>
      <p>If you cancel your reservation within 7 days of your scheduled arrival, a cancellation fee equal to 50% of the total booking amount will be charged.</p>
    </div>

    <div class="policy-item">
      <h5>Cancellation on Arrival Day</h5>
      <p>In the event of cancellation on the day of your scheduled arrival, the total booking amount will be charged as a cancellation fee.</p>
    </div>

    <div class="policy-item">
      <h5>How to Cancel</h5>
      <p>To cancel your booking, please contact our customer support team via phone or email. Ensure to have your booking details ready for a smooth cancellation process.</p>
    </div>

    <div class="policy-item">
      <h5>Exceptions</h5>
      <p>Some special offers and discounted rates may have different cancellation policies. Please refer to the terms and conditions of your specific booking for more details.</p>
    </div>

    <div class="policy-item">
      <h5>Feedback and Suggestions</h5>
      <p>Your feedback is important to us. If you have any suggestions regarding our cancellation policy, feel free to reach out to us.</p>
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
  name: "CancellationPolicy",
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}

.policy-item {
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #eaeaea;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.policy-item h5 {
  margin-bottom: 10px;
  color: #dc3545; /* Use a color that stands out, like red */
}
</style>
