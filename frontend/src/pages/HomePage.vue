<template>
  <div v-if="userRole==='user'">
    <PageBar />
  </div>
  
  <div class="home-container">
    <!-- Admin Dashboard Section -->
    <div v-if="userRole === 'admin'" class="admin-dashboard">
      <div class="welcome-section">
        <h1>Welcome to the Building Management System</h1>
        <p class="welcome-message">Manage your buildings with ease.</p>
      </div>
      <h2>Admin Dashboard</h2>
      <div class="options-container">
        <div class="card" v-for="(option, index) in adminOptions" :key="index">
          <router-link :to="option.path">
            <h3>{{ option.title }}</h3>
            <p>{{ option.description }}</p>
          </router-link>
        </div>
      </div>
    </div>

    <!-- User Dashboard Section -->
    <div v-else-if="userRole === 'user'" class="user-options">
      <br> <br> <h2>Welcome</h2> <br>

      <!-- Swiper for Featured Rooms -->
      <Swiper />
      <br />

      <!-- Featured Cards -->
      <div class="features-container">
        <div class="feature-card" v-for="(feature, index) in features" :key="index">
          <img :src="feature.image" alt="Feature Image" class="feature-image" />
          <h3>{{ feature.title }}</h3>
          <p>{{ feature.description }}</p>
          <router-link :to="feature.link" class="btn">Learn More</router-link>
        </div>
      </div>
      


      <!-- Booking History Section -->
      <h3>Your Booking History</h3>
      <div class="booking-history">
        <p>No booking history available.</p> <!-- Placeholder for booking history -->
      </div>

      <!-- Notifications Section -->
      <h3>Notifications</h3>
      <div class="notifications">
        <p>No new notifications.</p>
      </div>
    </div>

    <!-- Guest Section -->
    <div v-else>
      <p class="login-message">
        <router-link to="/login">Please log in to see available options.</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import Swiper from '../components/swiper.vue';

// Importing images directly
import featureRoomBooking from '../assets/images/feature_room_booking.jpeg';
import featureCustomerSupport from '../assets/images/feature_customer_support.jpeg';
import featureFeedback from '../assets/images/feature_feedback.jpeg';
import featureImageGallery from '../assets/images/feature_image_gallery.jpg';
import PageBar from '../components/pageBar.vue';

export default {
  name: 'Home',
  components: {
    Swiper,
    PageBar
  },
  data() {
    return {
      adminOptions: [
        { path: '/users', title: 'Account Management', description: 'View, add, or remove users of the system.' },
        { path: '/buildings', title: 'Building Management', description: 'View, add, or remove buildings in the system.' },
        { path: '/manage-rooms', title: 'Rooms Management', description: 'View, add, or remove rooms in the system.' },
        { path: '/admin/reports', title: 'Reports', description: 'Generate and view reports on system usage.' },
        { path: '/admin/visualizations', title: 'Visualizations', description: 'Visualize data related to the system\'s operations.' },
        { path: '/adminlist', title: 'Manage Admins', description: 'Add, update, or remove System Admins.' },
        { path: '/profile/', title: 'Profile', description: 'View your profile.' },
        { path: '/payments-list', title: 'Payments', description: 'View your payments.' },
        { path: '/comments-catalog', title: 'CommentsCatalog', description: 'Manage All Comments made by users and Admins.' },
        { path: '/bookings-catalog', title: 'BookingCatalog', description: 'Manage All Bookings made by users.' }
  
      ],
      features: [
        {
          title: 'Room Booking',
          description: 'Easily book rooms at your convenience.',
          link: '/browserooms',
          image: featureRoomBooking,
        },
        {
          title: 'Customer Support',
          description: 'Get help and support whenever you need it.',
          link: '/customer-support',
          image: featureCustomerSupport,
        },
        {
          title: 'Feedback',
          description: 'Share your experience and feedback with us.',
          link: '/under-construction',
          image: featureFeedback,
        },
        {
          title: 'ImageGallery',
          description: 'View a gallery of images of the rooms on offer.',
          link: '/under-construction',
          image: featureImageGallery,
        }
      ]
    };
  },
  mounted() {
    if (!this.isLoggedIn) {
      this.$router.push('/login'); // Redirect to login if the user is not logged in
    }
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('token'); // Check if token exists
    },
    userRole() {
      return localStorage.getItem('role'); // Get role from local storage
    }
  }
}
</script>

<style scoped>
.home-container {
  padding: 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.welcome-section {
  margin-bottom: 2rem;
}

.welcome-message {
  font-size: 1.2em;
  color: #555;
  margin-bottom: 2rem;
}

.options-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.card {
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 1rem;
  margin: 1rem;
  width: 250px;
  text-align: center;
  transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.features-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 2rem;
}

.feature-card {
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 1rem;
  margin: 1rem;
  width: 220px;
  text-align: center;
}

.feature-image {
  width: 100%;
  height: 120px; /* Adjust height as needed */
  object-fit: cover; /* Maintain aspect ratio */
  border-radius: 10px;
}

.btn {
  display: inline-block;
  margin-top: 10px;
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  border-radius: 5px;
  text-decoration: none;
}

.login-message {
  font-size: 1.2em;
  color: #ff4d4d;
}

/* Responsive */
@media (max-width: 768px) {
  .options-container {
    flex-direction: column;
    align-items: center;
  }

  .card {
    width: 90%;
  }
}
</style>
