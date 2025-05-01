<template>
    <div class="features-container">
      <router-link to="/group-roles">
        <h3 class="hover-text">Group & Friends Enhancements</h3>
      </router-link>
  
      <div class="feature-cards">
        <div class="feature-card" v-for="(feature, index) in features" :key="index">
          <router-link :to="feature.link">
            <img :src="feature.image" alt="Feature Image" class="feature-image" />
            <h3>{{ feature.title }}</h3>
            <p>{{ feature.description }}</p>
          </router-link>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import img1 from '../assets/images/grouproles.svg'; // Example images for each feature
  import img2 from '../assets/images/expensetracking.svg';
  import img3 from '../assets/images/paymentintegration.svg';
  import img4 from '../assets/images/notifications.svg';
  import img5 from '../assets/images/dashboard.svg';
  import img6 from '../assets/images/security.svg';
  import img7 from '../assets/images/smartmoney.svg';
  
  export default {
    name: 'FeatureCards',
    data() {
      return {
        features: [
          { 
            title: 'Group & Friends Enhancements', 
            image: img1, 
            description: 'Manage group roles, chat threads, and split expenses easily.',
            link: '/groups' 
          },
          { 
            title: 'Expense Tracking', 
            image: img2, 
            description: 'Track expenses, manage recurring bills, and upload receipts.',
            link: '/expense-tracking'
          },
          { 
            title: 'Payment Integration', 
            image: img3, 
            description: 'Integrate payments with support for partial payments and in-app wallets.',
            link: '/payment-integration'
          },
          { 
            title: 'Notifications & Reminders', 
            image: img4, 
            description: 'Get reminders and push notifications for upcoming expenses.',
            link: '/notifications-reminders'
          },
          { 
            title: 'Dashboard & Insights', 
            image: img5, 
            description: 'View spending insights, debt simplification, and financial reports.',
            link: '/dashboard-insights'
          },
          { 
            title: 'Security & Roles', 
            image: img6, 
            description: 'Manage user roles and ensure data security with activity logs.',
            link: '/security-roles'
          },
          { 
            title: 'AI & Smart Features', 
            image: img7, 
            description: 'Benefit from anomaly detection and smart reminders for better spending.',
            link: '/ai-smart-features'
          }
        ]
      };
    }
  };
  </script>
  
  <style scoped>
  .hover-text {
    color: black; /* Default color */
    transition: color 0.3s ease; /* Smooth transition */
  }
  
  .hover-text:hover {
    color: red; /* Color on hover */
  }
  
  .features-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 2rem;
  }
  
  .feature-cards {
    display: flex;
    flex-wrap: wrap; /* Ensure that cards wrap to the next line */
    justify-content: space-around; /* Evenly space the cards */
  }
  
  .feature-card {
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 1rem;
    width: 220px;
    text-align: center;
    transition: transform 0.3s;
  }
  
  .feature-card:hover {
    transform: translateY(-5px);
  }
  
  .feature-image {
    width: 100%;
    height: 200px; /* Adjust height as needed */
    object-fit: cover; /* Maintain aspect ratio */
    border-radius: 10px;
  }
  
  .nav-button {
    background-color: #007bff; /* Primary color */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    margin: 0 10px; /* Space between buttons and cards */
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .nav-button:hover {
    background-color: #0056b3; /* Darker shade on hover */
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .feature-card {
      width: 45%; /* Adjust for smaller screens, 2 cards per row */
    }
  }
  
  @media (max-width: 574px) {
    .feature-card {
      width: 90%; /* One card per row on very small screens */
    }
  }
  </style>
  