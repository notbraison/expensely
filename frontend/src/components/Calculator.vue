<template>
  <div class="container py-5">
    <h2 class="text-center mb-5">Expense Management Calculator</h2>

    <!-- Expense Splitter Section -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h4 class="card-title">Expense Splitter</h4>
        <form @submit.prevent="calculateExpenseSplit">
          <div class="form-group mb-3">
            <label for="amount">Total Amount</label>
            <input
              v-model="expenseAmount"
              type="number"
              class="form-control"
              id="amount"
              placeholder="Enter total amount"
            />
          </div>

          <div class="form-group mb-3">
            <label for="participants">Number of Participants</label>
            <input
              v-model="numParticipants"
              type="number"
              class="form-control"
              id="participants"
              placeholder="Enter number of participants"
            />
          </div>

          <button type="submit" class="btn btn-primary">Calculate Split</button>
        </form>

        <div v-if="splitResult" class="mt-3">
          <h5>Amount per Person</h5>
          <p>${{ splitResult }}</p>
        </div>
      </div>
    </div>

    <!-- Budget Tracker Section -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h4 class="card-title">Budget Tracker</h4>
        <form @submit.prevent="calculateBudget">
          <div class="form-group mb-3">
            <label for="budget">Monthly Budget</label>
            <input
              v-model="monthlyBudget"
              type="number"
              class="form-control"
              id="budget"
              placeholder="Enter your monthly budget"
            />
          </div>

          <div class="form-group mb-3">
            <label for="spending">Total Spending</label>
            <input
              v-model="totalSpending"
              type="number"
              class="form-control"
              id="spending"
              placeholder="Enter your total spending"
            />
          </div>

          <button type="submit" class="btn btn-secondary">Track Budget</button>
        </form>

        <div v-if="budgetStatus" class="mt-3">
          <h5>Status</h5>
          <p>{{ budgetStatus }}</p>
        </div>
      </div>
    </div>

    <!-- Savings Goal Section -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h4 class="card-title">Savings Goal</h4>
        <form @submit.prevent="calculateSavingsGoal">
          <div class="form-group mb-3">
            <label for="goalAmount">Goal Amount</label>
            <input
              v-model="goalAmount"
              type="number"
              class="form-control"
              id="goalAmount"
              placeholder="Enter savings goal amount"
            />
          </div>

          <div class="form-group mb-3">
            <label for="months">Time (Months)</label>
            <input
              v-model="monthsToSave"
              type="number"
              class="form-control"
              id="months"
              placeholder="Enter the number of months to save"
            />
          </div>

          <button type="submit" class="btn btn-danger">Calculate Monthly Savings</button>
        </form>

        <div v-if="savingsResult" class="mt-3">
          <h5>Monthly Savings Needed</h5>
          <p>${{ savingsResult }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // Expense Splitter
      expenseAmount: 0,
      numParticipants: 0,
      splitResult: null,

      // Budget Tracker
      monthlyBudget: 0,
      totalSpending: 0,
      budgetStatus: '',

      // Savings Goal
      goalAmount: 0,
      monthsToSave: 0,
      savingsResult: null,
    };
  },
  methods: {
    // Calculate expense split
    calculateExpenseSplit() {
      if (this.numParticipants > 0 && this.expenseAmount > 0) {
        this.splitResult = (this.expenseAmount / this.numParticipants).toFixed(2);
      } else {
        this.splitResult = 'Invalid input!';
      }
    },

    // Track budget
    calculateBudget() {
      const remainingBudget = this.monthlyBudget - this.totalSpending;
      if (remainingBudget > 0) {
        this.budgetStatus = `You have $${remainingBudget} left in your budget for the month.`;
      } else if (remainingBudget < 0) {
        this.budgetStatus = `You have exceeded your budget by $${Math.abs(remainingBudget)}.`;
      } else {
        this.budgetStatus = 'You have exactly used your monthly budget!';
      }
    },

    // Calculate savings goal
    calculateSavingsGoal() {
      if (this.goalAmount > 0 && this.monthsToSave > 0) {
        this.savingsResult = (this.goalAmount / this.monthsToSave).toFixed(2);
      } else {
        this.savingsResult = 'Invalid input!';
      }
    },
  },
};
</script>

<style scoped>
.card-body {
  padding: 20px;
}

input.form-control {
  width: 100%;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 10px;
}

button {
  padding: 10px 20px;
  border-radius: 30px;
  font-size: 1rem;
  width: 100%;
  margin-top: 10px;
}

button:disabled {
  background-color: #ccc;
}

button.btn-primary {
  background-color: #28a745;
  color: white;
}

button.btn-secondary {
  background-color: #007bff;
  color: white;
}

button.btn-danger {
  background-color: #dc3545;
  color: white;
}

.card {
  margin-bottom: 20px;
}

h4 {
  margin-bottom: 15px;
}
</style>
