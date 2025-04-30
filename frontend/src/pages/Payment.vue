<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <!-- Room Price Card -->
        <div class="card mb-4 shadow-sm border-0">
          <div class="card-header bg-light text-dark">
            <h5 class="card-title mb-0">Room Payment Details</h5>
          </div>
          <div class="card-body">
            <p class="mb-0">Room Name: <strong>{{ room.room_name }}</strong></p>
            <p class="mb-0">Type: <strong>{{ room.type }}</strong></p>
            <p class="mb-0">Size: <strong>{{ room.size }} sqft</strong></p>
            <p class="mb-0">Number of Bedrooms: <strong>{{ room.number_of_bedrooms }}</strong></p>
            <hr>
            <p class="h4">Price: <strong>{{ room.rate }} {{ room.currency }}</strong></p>
          </div>
        </div>

        <!-- Payment Form -->
        <div class="card shadow-sm border-0">
          <div class="card-header bg-light text-dark">
            <h5 class="card-title mb-0">Payment</h5>
          </div>
          <div class="card-body">
            <p class="text-muted">Please select a payment method to complete your booking.</p>
            <form @submit.prevent="processPayment">
              <div class="form-group mb-3">
                <label for="paymentMethod" class="form-label">Payment Method</label>
                <select v-model="paymentMethod" id="paymentMethod" class="form-control" required>
                  <option value="" disabled>Select a payment method</option>
                  <option value="credit_card">Credit Card</option>
                  <option value="mobile_wallet">Mobile Wallet</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="m-pesa">Mpesa</option>
                </select>
              </div>

              <!-- Conditional Payment Inputs -->
              <div v-if="paymentMethod === 'm-pesa'" class="form-group mb-3">
                <label for="mpesaNumber" class="form-label">Mpesa Number</label>
                <input type="text" v-model="mpesaNumber" id="mpesaNumber" class="form-control" placeholder="Enter Mpesa number" required />
              </div>

              <div v-if="paymentMethod === 'credit_card'" class="form-group mb-3">
                <label for="creditCardNumber" class="form-label">Credit Card Number</label>
                <input type="text" v-model="creditCardNumber" id="creditCardNumber" class="form-control" placeholder="Enter Credit Card number" required />
              </div>

              <div v-if="paymentMethod === 'mobile_wallet'" class="form-group mb-3">
                <label for="walletNumber" class="form-label">Mobile Wallet Number</label>
                <input type="text" v-model="walletNumber" id="walletNumber" class="form-control" placeholder="Enter Wallet number" required />
              </div>

              <div v-if="paymentMethod === 'bank_transfer'" class="form-group mb-3">
                <label for="bankAccount" class="form-label">Bank Account Number</label>
                <input type="text" v-model="bankAccount" id="bankAccount" class="form-control" placeholder="Enter Bank Account number" required />
              </div>

              <button type="submit" class="btn btn-dark btn-lg w-100" :disabled="isLoading">
                <span v-if="isLoading" style="color: white; background-color: gray;">Processing...</span>
                <span v-else style="color: white; background-color: grey;">Confirm Payment</span>
            </button>
            
 
            </form>
            <br>
            <button @click="cancelPayment" class="btn btn-danger w-100">Cancel Payment</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  data() {
    return {
      bookingId: this.$route.params.booking_id,
      roomId: this.$route.params.room_id,
      paymentMethod: '',
      mpesaNumber: '',
      creditCardNumber: '',
      walletNumber: '',
      bankAccount: '',
      room: {
        rate: 0,
        currency: '',
        room_name: '',
        type: '',
        size: '',
        number_of_bedrooms: ''
      },
      userId: '',
      isLoading: false // Loading state
    };
  },
  created() {
    this.getUserIdFromLocalStorage();
    this.fetchBookingDetails();
  },
  methods: {
    getUserIdFromLocalStorage() {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.user_id) {
        this.userId = user.user_id;
      }
    },

    async fetchBookingDetails() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/bookings/${this.bookingId}`);
        this.roomId = response.data.room_id;
        await this.fetchRoomDetails();
      } catch (error) {
        console.error('Error fetching booking details:', error);
      }
    },

    async fetchRoomDetails() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/room/${this.roomId}`);
        this.room = response.data;
      } catch (error) {
        console.error('Error fetching room details:', error);
      }
    },

    async processPayment() {
    const paymentDetails = {
        booking_id: this.bookingId,
        room_id: this.roomId,
        user_id: this.userId,
        payment_method: this.paymentMethod,
        amount: this.room.rate,
    };

    // Add payment account based on the selected payment method
    if (this.paymentMethod === 'm-pesa') {
        paymentDetails.payment_account = this.mpesaNumber; // Assuming mpesaNumber is the account info for m-pesa
    } else if (this.paymentMethod === 'credit_card') {
        paymentDetails.payment_account = this.creditCardNumber; // Assuming this is the account info for credit card
    } else if (this.paymentMethod === 'mobile_wallet') {
        paymentDetails.payment_account = this.walletNumber; // Assuming this is the account info for mobile wallet
    } else if (this.paymentMethod === 'bank_transfer') {
        paymentDetails.payment_account = this.bankAccount; // Assuming this is the bank account info
    }

    console.log("Payment Details to send:", paymentDetails); // Log the payment details

    try {
        this.isLoading = true;
        const response = await axios.post('http://127.0.0.1:8000/api/simulate-payment', paymentDetails);
        alert('Payment processed successfully!');
        this.$router.push('/rented-rooms');
    } catch (error) {
        console.error('Error simulating payment:', error.response.data); // Log the error response
        alert('Payment simulation failed: ' + JSON.stringify(error.response.data.errors || error.message));
    } finally {
        this.isLoading = false;
    }
},

    async cancelPayment() {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/bookings/${this.bookingId}`);
        alert('Booking canceled successfully.');
        this.$router.push('/browserooms');
      } catch (error) {
        console.error('Error canceling booking:', error);
        alert('Failed to cancel booking.');
      }
    }
  }
};
</script>

<style scoped>
.container {
  margin: 30px auto;
}

.card {
  border-radius: 12px;
  border: none;
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #e9ecef;
  font-weight: bold;
}

.card-body {
  background-color: #ffffff;
}

.btn {
  font-size: 1.2rem;
}

.btn-dark {
  background-color: #343a40; /* Background color */
  border-color: #343a40; /* Border color */
  color: black !important; /* Force text color to white */
  font-size: 1.2rem; /* Adjust as needed */
  font-weight: bold; /* Make text bold */
}

.btn-dark:hover {
  background-color: green; /* Hover background color */
  border-color: #1d2124; /* Hover border color */
  color: black !important; /* Ensure text color remains white on hover */
}



</style>
