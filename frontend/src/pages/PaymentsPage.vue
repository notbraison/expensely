<template>
  <div class="container py-5">
    <h2 class="text-center mb-4">My Payments</h2>

    <!-- Search Filters -->
    <div class="row mb-4">
      <div class="col-md-6">
        <input
          type="text"
          class="form-control"
          placeholder="Search by transaction ID"
          v-model="searchQuery"
          @input="filterPayments"
        />
      </div>
      <div class="col-md-6">
        <select class="form-control" v-model="selectedStatus" @change="filterPayments">
          <option value="">All Statuses</option>
          <option value="pending">Pending</option>
          <option value="confirmed">Confirmed</option>
          <option value="failed">Failed</option>
        </select>
      </div>
    </div>

    <!-- Payments List -->
    <div v-if="payments.length > 0" class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Payments</h5>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Transaction ID</th>
              <th scope="col">Amount</th>
              <th scope="col">Payment Method</th>
              <th scope="col">Status</th>
              <th scope="col">Date</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="payment in filteredPayments" :key="payment.transaction_id">
              <td>{{ payment.transaction_id }}</td>
              <td>${{ payment.amount }}</td>
              <td>{{ payment.payment_method }}</td>
              <td :class="{'text-success': payment.status === 'confirmed', 'text-danger': payment.status === 'failed'}">
                {{ payment.status }}
              </td>
              <td>{{ new Date(payment.payment_date).toLocaleDateString() }}</td>
              <td>
                <button @click="viewPaymentDetails(payment.transaction_id)" class="btn btn-info btn-sm">
                  View Details
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- No Payments Available -->
    <div v-else class="text-center text-muted">
      No payments available.
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      payments: [], // Store all payments
      filteredPayments: [], // Store filtered payments based on search and status
      searchQuery: '', // Search query for transaction ID
      selectedStatus: '', // Selected status for filtering payments
    };
  },
  mounted() {
    this.fetchPayments(); // Fetch payments when the page is loaded
  },
  methods: {
    // Fetch all payments made by the user
    fetchPayments() {
      axios.get('/api/payments')
        .then(response => {
          this.payments = response.data;
          this.filteredPayments = this.payments; // Initially show all payments
        })
        .catch(error => {
          console.error('Error fetching payments:', error);
        });
    },

    // Filter payments based on search query or selected status
    filterPayments() {
      this.filteredPayments = this.payments.filter(payment => {
        const matchesSearch = payment.transaction_id.toLowerCase().includes(this.searchQuery.toLowerCase());
        const matchesStatus = this.selectedStatus ? payment.status === this.selectedStatus : true;
        return matchesSearch && matchesStatus;
      });
    },

    // View the details of a payment
    viewPaymentDetails(transactionId) {
      this.$router.push(`/payments/${transactionId}`);
    },
  },
};
</script>

<style scoped>
/* Table Styles */
.card-body {
  padding: 20px;
}

.table {
  width: 100%;
}

.table th, .table td {
  padding: 12px;
  text-align: left;
}

.table-hover tbody tr:hover {
  background-color: #f1f1f1;
}

/* Filter Input */
input.form-control, select.form-control {
  width: 100%;
  padding: 10px;
}

/* Custom Styling for Status */
.text-success {
  color: green;
}

.text-danger {
  color: red;
}
</style>
