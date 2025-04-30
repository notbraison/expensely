<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Payment Options</h2>
    <p>We offer several payment options for your convenience:</p>
    <ul>
      <li><strong>M-PESA:</strong> Secure payments via M-PESA from Safaricom.</li>
      <li><strong>Credit/Debit Card:</strong> Secure payments via Visa, MasterCard, etc.</li>
      <li><strong>Bank Transfer:</strong> Transfer directly from your bank account.</li>
      <li><strong>Mobile Payments:</strong> Use services like M-Pesa or Airtel Money.</li>
    </ul>
    <p>Please choose the payment method that suits you best during the booking process.</p>
  </div>
  <Backbutton/>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  name: "PaymentOptions",
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}
</style>
