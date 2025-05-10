<template>
    <div class="container py-4">
      <h3 class="text-center mb-4">Payment Methods</h3>
      
      <!-- Add Payment Method Form -->
      <div class="card p-4 shadow-sm mb-4">
        <div class="form-group">
          <label for="payment-method" class="font-weight-bold">Select Payment Method</label> <br>
          <select v-model="selectedMethod" class="form-control" id="payment-method">
            <option value="">Select Payment Method</option>
            <option value="mpesa">M-Pesa</option>
            <option value="paypal">PayPal</option>
            <option value="stripe">Stripe</option>
            <option value="stanchart">Standard Chartered</option>
          </select>
        </div>
  
        <div v-if="selectedMethod" class="form-group mt-3">
          <label for="account-id" class="font-weight-bold">Enter Account ID</label>
          <input 
            v-model="accountId" 
            type="text" 
            class="form-control" 
            id="account-id"
            placeholder="Enter Account ID"
          />
        </div>
  
        <button 
          v-if="selectedMethod && accountId" 
          @click="addPaymentMethod" 
          class="btn btn-primary btn-block mt-3"
        >
          Add Payment Method
        </button>
      </div>
  
      <!-- Display Linked Payment Methods -->
      <div v-if="paymentMethods.length" class="card p-4 shadow-sm">
        <h5>Your Linked Payment Methods</h5>
        <ul class="list-group mt-3">
          <li v-for="method in paymentMethods" :key="method.id" class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{ method.method }} - {{ method.account_id }}</span>
            <button 
              @click="removePaymentMethod(method.id)" 
              class="btn btn-danger btn-sm"
            >
              Remove
            </button>
          </li>
        </ul>
      </div>
  
      <div v-else class="text-center mt-3 text-muted">
        No payment methods linked yet. Add your first payment method above.
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        selectedMethod: '',
        accountId: '',
        paymentMethods: [],
      };
    },
    mounted() {
      this.fetchPaymentMethods();
    },
    methods: {
      // Add payment method to the user account
      addPaymentMethod() {
        axios
          .post('/api/payment-methods', {
            method: this.selectedMethod,
            account_id: this.accountId,
          })
          .then(() => {
            this.fetchPaymentMethods(); // Refresh the payment methods list
            this.selectedMethod = '';  // Reset the form
            this.accountId = '';
          })
          .catch((error) => {
            console.error('Error adding payment method:', error);
          });
      },
  
      // Fetch the user's linked payment methods
      fetchPaymentMethods() {
        axios
          .get('/api/payment-methods')
          .then((response) => {
            this.paymentMethods = response.data;
          })
          .catch((error) => {
            console.error('Error fetching payment methods:', error);
          });
      },
  
      // Remove a linked payment method
      removePaymentMethod(paymentMethodId) {
        axios
          .delete(`/api/payment-methods/${paymentMethodId}`)
          .then(() => {
            this.fetchPaymentMethods(); // Refresh the payment methods list
          })
          .catch((error) => {
            console.error('Error removing payment method:', error);
          });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Styling for the payment method page */
  
  .container {
    max-width: 600px;
  }
  
  .card {
    background-color: #f8f9fa;
  }
  
  .card h5 {
    font-size: 1.2rem;
    font-weight: bold;
  }
  
  .card p {
    font-size: 0.9rem;
  }
  
  .form-group label {
    font-size: 1rem;
    font-weight: bold;
  }
  
  .form-control {
    font-size: 1rem;
  }
  
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    font-weight: bold;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
  }
  
  .list-group-item {
    font-size: 1rem;
  }
  
  .list-group-item button {
    background-color: #dc3545;
    border-color: #dc3545;
  }
  
  .list-group-item button:hover {
    background-color: #c82333;
    border-color: #c82333;
  }
  
  /* Responsive design */
  @media (max-width: 768px) {
    .container {
      padding: 15px;
    }
  }
  </style>
  