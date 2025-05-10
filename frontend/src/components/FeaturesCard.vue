<template>
  <div class="container my-5">
    <h1 class="text-center mb-4">Key Features & Enhancements</h1>

    <!-- Features Cards Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      <!-- Group & Friends Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/grouproles.svg" class="card-img-top" alt="Group & Friends">
          <div class="card-body">
            <h5 class="card-title">Groups & Friends</h5>
            <p class="card-text">Enhance group management with roles, chat threads, and splitting rules presets.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/groups" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

      <!-- Expense Tracking Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/expensetracking.svg" class="card-img-top" alt="Expense Tracking">
          <div class="card-body">
            <h5 class="card-title">Expense Tracking</h5>
            <p class="card-text">Track recurring expenses, attachments (receipts), and manage currency conversions.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/dashboard" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

      <!-- Payment Integration Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/paymentintegration.svg" class="card-img-top" alt="Payment Integration">
          <div class="card-body">
            <h5 class="card-title">Payment Integration</h5>
            <p class="card-text">Integrate payments and track partial payments, confirmations, and wallet balances.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/payment-integration" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

      <!-- Notifications & Reminders Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/notifications.svg" class="card-img-top" alt="Notifications & Reminders">
          <div class="card-body">
            <h5 class="card-title">Notifications & Reminders</h5>
            <p class="card-text">Set custom reminders and push notifications for timely payments and updates.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/notifications" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

      <!-- Dashboard & Insights Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/dashboard.svg" class="card-img-top" alt="Dashboard & Insights">
          <div class="card-body">
            <h5 class="card-title">Dashboard & Insights</h5>
            <p class="card-text">Get debt simplification insights, spending analysis, and downloadable reports.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/dashboard" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

      <!-- Security & Roles Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/security.svg" class="card-img-top" alt="Security & Roles">
          <div class="card-body">
            <h5 class="card-title">Security & Roles</h5>
            <p class="card-text">Track activity, set role-based access control, and secure API calls.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/security" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

      <!-- AI & Smart Features Card -->
      <div class="col">
        <div class="card shadow-lg">
          <img src="../assets/images/smartmoney.svg" class="card-img-top" alt="AI & Smart Features">
          <div class="card-body">
            <h5 class="card-title">AI & Smart Features</h5>
            <p class="card-text">Detect spending anomalies, provide optimization tips, and send smart reminders.</p>
            <!-- Use router-link for navigation -->
            <router-link to="/ai-insights" class="btn btn-primary">Explore</router-link>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "FeaturesCard",
  data() {
    return {
      // You can use this data object to store any required dynamic data
    };
  },
};
</script>

<style scoped>
.card {
  transition: transform 0.2s ease-in-out;
}

.card:hover {
  transform: scale(1.05);
}

.card-img-top {
  object-fit: cover;
  height: 200px;
}
</style>
