<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Booking Guide</h2>
    <p>Follow these steps to book a room:</p>
    <ol>
      <li>Select your desired room from the available options.</li>
      <li>Choose your check-in and check-out dates.</li>
      <li>Fill in your personal details and payment information.</li>
      <li>Review your booking details and submit your booking.</li>
      <li>You will receive a confirmation email with your booking details.</li>
    </ol>
  </div>
  <Backbutton/>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  name: "BookingGuide",
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}
</style>
