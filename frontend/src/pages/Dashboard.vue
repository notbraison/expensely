<template>
  <div class="container py-5">
    <h2 class="text-center mb-5">Expense Tracking Dashboard</h2>
    
    <!-- Overview Section (Key Metrics) -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Total Expenses</h5>
            <p class="card-text text-muted">Total expenses for the selected period</p>
            <h3 class="text-primary">${{ totalExpenses }}</h3>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Total Income</h5>
            <p class="card-text text-muted">Total income for the selected period</p>
            <h3 class="text-success">${{ totalIncome }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title">Balance</h5>
            <p class="card-text text-muted">Remaining balance after expenses</p>
            <h3 class="text-warning">${{ totalBalance }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Expense Breakdown Table -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Expense Breakdown</h5>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Category</th>
              <th scope="col">Amount</th>
              <th scope="col">Date</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(expense, index) in expenses" :key="expense.id">
              <td>{{ expense.category }}</td>
              <td>${{ expense.amount }}</td>
              <td>{{ expense.date }}</td>
              <td>
                <button class="btn btn-info btn-sm" @click="viewExpense(expense.id)">View</button>
                <button class="btn btn-danger btn-sm" @click="deleteExpense(expense.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Expense Trends (Chart) -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Expense Trends</h5>
        <line-chart :data="expenseTrendsData"></line-chart>
      </div>
    </div>

    <!-- Category Breakdown (Pie Chart) -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Expense by Category</h5>
        <pie-chart :data="categoryBreakdownData"></pie-chart>
      </div>
    </div>

    <!-- Recurring Expenses -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Recurring Expenses</h5>
        <ul class="list-group">
          <li v-for="recurringExpense in recurringExpenses" :key="recurringExpense.id" class="list-group-item d-flex justify-content-between">
            <span>{{ recurringExpense.name }} - ${{ recurringExpense.amount }}</span>
            <span class="text-muted">{{ recurringExpense.frequency }}</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Budget Tracking -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Budget Tracking</h5>
        <div class="d-flex justify-content-between">
          <div>Budget: ${{ budget }}</div>
          <div>Spent: ${{ spent }}</div>
          <div>Remaining: ${{ remaining }}</div>
        </div>
        <div class="progress mt-3">
          <div class="progress-bar" :style="{ width: `${(spent / budget) * 100}%` }"></div>
        </div>
      </div>
    </div>

    <!-- Notifications & Reminders -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Upcoming Reminders</h5>
        <ul class="list-group">
          <li v-for="reminder in upcomingReminders" :key="reminder.id" class="list-group-item">
            <strong>{{ reminder.name }}</strong> - Due: {{ reminder.dueDate }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
// Import necessary components
import LineChart from '../components/LineChart.vue';
import PieChart from '../components/PieChart.vue';

export default {
  components: {
    LineChart,
    PieChart
  },
  data() {
    return {
      expenses: [], // List of expenses
      totalExpenses: 0,
      totalIncome: 0,
      totalBalance: 0,
      expenseTrendsData: [], // Data for line chart (Expense Trends)
      categoryBreakdownData: [], // Data for pie chart (Expense Categories)
      recurringExpenses: [], // List of recurring expenses
      budget: 1000, // Example budget
      spent: 450, // Example spent amount
      remaining: 550, // Example remaining amount
      upcomingReminders: [], // List of upcoming reminders
    };
  },
  mounted() {
    this.fetchExpenses();
    this.fetchExpenseTrends();
    this.fetchCategoryBreakdown();
    this.fetchRecurringExpenses();
    this.fetchUpcomingReminders();
  },
  methods: {
    fetchExpenses() {
      // Example API call to fetch expenses
      axios.get('/api/expenses')
        .then(response => {
          this.expenses = response.data;
          this.totalExpenses = response.data.reduce((acc, exp) => acc + exp.amount, 0);
          this.totalBalance = this.totalIncome - this.totalExpenses;
        });
    },
    fetchExpenseTrends() {
      // Example data for trends
      this.expenseTrendsData = [
        { date: '2021-01-01', expense: 200 },
        { date: '2021-02-01', expense: 300 },
        { date: '2021-03-01', expense: 250 },
      ];
    },
    fetchCategoryBreakdown() {
      // Example data for category breakdown
      this.categoryBreakdownData = [
        { category: 'Food', value: 150 },
        { category: 'Rent', value: 500 },
        { category: 'Utilities', value: 100 },
      ];
    },
    fetchRecurringExpenses() {
      // Example data for recurring expenses
      this.recurringExpenses = [
        { id: 1, name: 'Rent', amount: 500, frequency: 'Monthly' },
        { id: 2, name: 'Electricity Bill', amount: 100, frequency: 'Monthly' },
      ];
    },
    fetchUpcomingReminders() {
      // Example data for reminders
      this.upcomingReminders = [
        { id: 1, name: 'Rent Payment', dueDate: '2021-04-01' },
        { id: 2, name: 'Electricity Bill', dueDate: '2021-04-05' },
      ];
    },
    viewExpense(expenseId) {
      // Navigate to the expense details page (e.g., using Vue Router)
      this.$router.push(`/expenses/${expenseId}`);
    },
    deleteExpense(expenseId) {
      // Example method to delete an expense
      axios.delete(`/api/expenses/${expenseId}`)
        .then(() => {
          this.fetchExpenses(); // Refresh the expense list
        });
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
}

.card {
  background-color: #f8f9fa;
}

.card-body {
  padding: 20px;
}

h3 {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
}

h5 {
  font-size: 1.2rem;
}

.list-group-item {
  padding: 10px 15px;
  border: 1px solid #ddd;
}

.list-group-item button {
  background-color: #dc3545;
  border-color: #dc3545;
}

.list-group-item button:hover {
  background-color: #c82333;
}

.progress-bar {
  background-color: #007bff;
}
</style>
