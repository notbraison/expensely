<template>
  <div class="container profile-page mt-5">
    <h1>{{ isClient ? 'Client Profile' : 'Admin Profile' }}</h1>
    <br />

    <section class="profile-content text-center">
      <div class="card mx-auto" style="width: 35rem;" v-if="user">
        <div class="card-body">
          <h2 class="card-title">{{ user.firstname }} {{ user.lastname }}</h2>
          <p class="card-text"><strong>Email:</strong> {{ user.email }}</p>
          <p class="card-text" v-if="!isClient"><strong>Contact:</strong> {{ user.contact }}</p>
          <p class="card-text" v-if="isClient"><strong>Gender:</strong> {{ user.gender }}</p>
          <p class="card-text" v-if="isClient"><strong>National ID:</strong> {{ user.national_id }}</p>
          <p class="card-text"><strong>Joined:</strong> {{ formattedDate(user.created_at) }}</p>
          <p class="card-text" v-if="isClient"><strong>Age:</strong> {{ user.age }}</p>
        </div>
      </div>
      <div v-else>
        <p>Loading user data...</p>
      </div>
    </section>

    <br />
    <div class="text-center mt-4">
      <button class="btn btn-primary" @click="toggleForm">{{ showForm ? 'Cancel' : 'Update Info' }}</button>
    </div>
    <br />

    <div class="update-form mt-4" v-if="showForm">
      <form @submit.prevent="updateUser">
        <div class="card mx-auto" style="width: 35rem;">
          <div class="card-body">
            <h5 class="card-title">Update {{ user.firstname }} {{ user.lastname }}</h5>
            <br />
            <div class="form-group">
              <label for="firstname">First Name:</label>
              <input v-model="updatedUser.firstname" type="text" id="firstname" class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="lastname">Last Name:</label>
              <input v-model="updatedUser.lastname" type="text" id="lastname" class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="email">Email:</label>
              <input v-model="updatedUser.email" type="email" id="email" class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="contact">Contact:</label>
              <input v-model="updatedUser.contact" type="text" id="contact" class="form-control" required>
            </div>
            <div class="form-group mt-3" v-if="isClient">
              <label for="gender">Gender:</label>
              <select v-model="updatedUser.gender" id="gender" class="form-control" required>
                <option value="" disabled>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div class="form-group mt-3" v-if="isClient">
              <label for="age">Age:</label>
              <input v-model="updatedUser.age" type="number" id="age" class="form-control" required>
            </div>
            <div class="form-group mt-3" v-if="isClient">
              <label for="national_id">National ID:</label>
              <input v-model="updatedUser.national_id" type="text" id="national_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-4">Save Changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
  name: "Profile",
  components:{
        Backbutton
    },
  data() {
    return {
      user: null, // User data loaded from local storage or API
      updatedUser: {}, // Object for storing updated user info
      showForm: false, // Toggle form visibility
      isClient: false, // Determine if the logged-in user is a client
    };
  },
  methods: {
    // Format the date from the user info
    formattedDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    // Toggle form visibility
    toggleForm() {
      this.showForm = !this.showForm;
    },
    // Update user information
    async updateUser() {
      try {
        const token = localStorage.getItem('token');
        const response = await axios.put(`http://127.0.0.1:8000/api/user/${this.user.user_id}`, this.updatedUser, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.status === 200) {
          // Handle success
          this.user = { ...this.updatedUser }; // Update local user data
          localStorage.setItem('user', JSON.stringify(this.user)); // Update local storage
          this.showForm = false; // Hide form after successful update
        }
      } catch (error) {
        console.error("Error updating user:", error);
      }
    },

    // Fetch user data
    async fetchUserData() {
      try {
        const storedUser = localStorage.getItem('user');
        const userId = JSON.parse(storedUser).user_id; // Get user_id

        const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`, // Use token for authorization
          },
        });

        this.user = response.data; // Set user data
        this.isClient = this.user.usertype === 'client'; // Check user type
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
  },
  computed: {
    disableSave() {
      // Disable the save button for clients if needed
      return this.user && this.user.usertype === 'client';
    },
  },
  mounted() {
    // Retrieve user data from local storage
    const storedUser = localStorage.getItem('user');
    const token = localStorage.getItem('token');

    if (token && storedUser) {
      this.user = JSON.parse(storedUser);
      this.updatedUser = { ...this.user }; // Initialize the updatedUser object with current user data
      this.isClient = this.user.usertype === 'client';

      // Fetch additional user data
      this.fetchUserData();
    } else {
      // Handle case where no user data is available (redirect to login or show error)
      this.$router.push('/login');
    }
  },
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
}

.card {
  margin-bottom: 20px;
}

.btn {
  width: 100%;
}

.form-control {
  margin-bottom: 10px;
}
</style>
