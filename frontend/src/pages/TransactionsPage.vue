<template>
  <div class="container py-5">
    <h2 class="text-center mb-4">Your Transactions & Expenses</h2>

    <!-- Filters -->
    <div class="row mb-4">
      <div class="col-md-6">
        <input
          type="text"
          class="form-control"
          placeholder="Search by description"
          v-model="searchQuery"
          @input="filterTransactions"
        />
      </div>
      <div class="col-md-6">
        <select class="form-control" v-model="selectedCategory" @change="filterTransactions">
          <option value="">All Categories</option>
          <option value="Food">Food</option>
          <option value="Rent">Rent</option>
          <option value="Utilities">Utilities</option>
          <option value="Entertainment">Entertainment</option>
        </select>
      </div>
    </div>

    <!-- Transactions List -->
    <div v-if="transactions.length > 0" class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Transaction List</h5>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Amount</th>
              <th scope="col">Category</th>
              <th scope="col">Date</th>
              <th scope="col">Status</th>
              <th scope="col">Description</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in filteredTransactions" :key="transaction.id">
              <td>{{ transaction.id }}</td>
              <td>${{ transaction.amount }}</td>
              <td>{{ transaction.category }}</td>
              <td>{{ transaction.date }}</td>
              <td :class="{'text-success': transaction.status === 'paid', 'text-danger': transaction.status === 'pending'}">
                {{ transaction.status }}
              </td>
              <td>{{ transaction.description }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-else class="text-center text-muted">
      No transactions available.
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      transactions: [], // Store all user transactions
      filteredTransactions: [], // Store filtered transactions based on search and category
      searchQuery: '', // Search query for filtering by description
      selectedCategory: '', // Selected category for filtering
    };
  },
  mounted() {
    this.fetchTransactions(); // Fetch the transactions when the component is mounted
  },
  methods: {
    // Fetch all transactions from the backend
    fetchTransactions() {
      axios
        .get('/api/transactions')
        .then(response => {
          this.transactions = response.data;
          this.filteredTransactions = this.transactions; // Initially show all transactions
        })
        .catch(error => {
          console.error('Error fetching transactions:', error);
        });
    },

    // Filter transactions based on search query or selected category
    filterTransactions() {
      this.filteredTransactions = this.transactions.filter(transaction => {
        const matchesSearch = transaction.description.toLowerCase().includes(this.searchQuery.toLowerCase());
        const matchesCategory = this.selectedCategory ? transaction.category === this.selectedCategory : true;
        return matchesSearch && matchesCategory;
      });
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
