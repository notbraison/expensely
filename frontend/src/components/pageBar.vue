<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link to="/" class="nav-link" :class="{ active: isActive('/') }">Stays</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/comments" class="nav-link" :class="{ active: isActive('/comments') }">Experiences</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'PageBar',
    
    data() {
      return {
        user: null // Store user details
      };
    },
    methods: {
      logout() {
        // Confirm logout
        if (confirm('Are you sure you want to log out?')) {
          localStorage.removeItem('token');
          localStorage.removeItem('role');
          localStorage.removeItem('user');
          this.$router.push('/login');
        }
      },
      isActive(route) {
        return this.$route.path === route; // Check if current route matches the provided route
      }
    },
    computed: {
      isLoggedIn() {
        return !!localStorage.getItem('token'); // Check if token exists
      },
      userName() {
        // Retrieve the user details from local storage
        const user = JSON.parse(localStorage.getItem('user'));
        return user ? `${user.firstname} ${user.lastname}` : ''; // Return full name or empty string
      },
      userRole() {
        return localStorage.getItem('role'); // Get role from local storage
      }
    },
    created() {
      // Check if user data is available and store it in component's state
      if (this.isLoggedIn) {
        this.user = JSON.parse(localStorage.getItem('user'));
      }
    }
  };
  </script>
  
  <style scoped>
  .navbar {
    position: fixed;
    top: 10;
    left: 0;
    width: 100%;
    height: 70px;
    padding: 10px;
    background-color: #333; /* Background color */
    z-index: 1000; /* Ensures it's above other content */
  }
  
  .nav-link {
    color: black; /* Link color */
    font-weight: bold; /* Bold links */
    transition: color 0.3s; /* Smooth transition for hover */
  }
  
  .nav-link:hover {
    color: #ffcc00; /* Color on hover */
  }
  
  .active {
    border-bottom: 2px solid #ffcc00; /* Highlight active link with a bottom border */
  }
  </style>
  