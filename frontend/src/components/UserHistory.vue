<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Your Payment History</h2>
    
    <div v-if="payments.length > 0">
      <table class="table table-hover">
        <thead>
          <tr>
            <!-- <th scope="col">Payment ID</th> -->
            <th scope="col">Transaction ID</th>
            <th scope="col">Room Name</th>
            <th scope="col">Amount</th>
            <th scope="col">Payment Method</th>
            <th scope="col">Status</th>
            <th scope="col">Paid At</th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="payment in payments" :key="payment.payment_id">
            <!-- <td>{{ payment.payment_id }}</td> -->
            <td>{{ payment.transaction_id }}</td>
            <td>{{ payment.room_name }}</td>
            <td>{{ payment.amount }} {{ payment.currency }}</td>
            <td>{{ payment.payment_method }}</td>
            <td><span class="badge" :class="getStatusClass(payment.status)">{{ payment.status }}</span></td>
            <td>{{ formatDate(payment.paid_at) }}</td>
            
          </tr>
        </tbody>
      </table>
    </div>
    
    <div v-else>
      <p class="text-center">No payment history available.</p>
    </div>

    <hr class="my-5">

    <h2 class="text-center mb-4">Your Comments History</h2>
    
    <div v-if="comments.length > 0">
      <table class="table table-hover">
        <thead>
          <tr>
            <!-- <th scope="col">Comment ID</th> -->
            <th scope="col">Room ID</th>
            <th scope="col">Comment Text</th>
            <th scope="col">Payment ID</th>
            <th scope="col">Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="comment in comments" :key="comment.comment_id">
            <!-- <td>{{ comment.comment_id }}</td> -->
            <td>{{ comment.room_id }}</td>
            <td>{{ comment.comment_text }}</td>
            <td>{{ comment.payment_id }}</td>
            <td>{{ formatDate(comment.created_at) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else>
      <p class="text-center">No comments history available.</p>
    </div>
  </div>
  <br>
  <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  data() {
    
    return {
      userId: '', // Will hold the logged-in user's ID
      payments: [], // List of payments
      comments: [] // List of comments
    };
  },
  created() {
    this.getUserIdFromLocalStorage(); // Retrieve user ID
    this.fetchPaymentHistory(); // Fetch payment history when component is created
    this.fetchCommentsHistory(); // Fetch comments history when component is created
  },
  methods: {
    getUserIdFromLocalStorage() {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.user_id) {
        this.userId = user.user_id;
      }
    },
    async fetchPaymentHistory() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/user/${this.userId}/payment-history`);
        this.payments = response.data;
      } catch (error) {
        console.error('Error fetching payment history:', error);
      }
    },
    async fetchCommentsHistory() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/comments/user/${this.userId}`);
        this.comments = response.data;
      } catch (error) {
        console.error('Error fetching comments history:', error);
      }
    },
    getStatusClass(status) {
      return status === 'completed' ? 'bg-success' : 'bg-danger';
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    }
  }
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}

.table th,
.table td {
  vertical-align: middle;
}
</style>
