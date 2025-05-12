<template>
  <div class="container profile-page py-5">
    <h2 class="text-center mb-4">{{ isClient ? 'User Profile' : 'Admin Profile' }}</h2>

    <!-- Profile Section -->
    <div class="row justify-content-center">
      <!-- Profile Picture Section -->
      <div class="col-md-3 text-center">
        <img 
          :src="profilePhotoUrl"
          alt="Profile Photo"
          class="img-fluid rounded-circle"
          width="150"
          height="150"
        />
        <br />
        <button @click="chooseFile" class="btn btn-outline-primary mt-3">Change Profile Photo</button>
      </div>

      
      <!-- Profile Details -->
      <div class="col-md-8 mt-4 mt-md-0">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="card-title">{{ user.firstname }} {{ user.lastname }}</h4>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p v-if="!isClient"><strong>Contact:</strong> {{ user.contact }}</p>
            <p v-if="isClient"><strong>Gender:</strong> {{ user.gender }}</p>
            <p v-if="isClient"><strong>National ID:</strong> {{ user.national_id }}</p>
            <p><strong>Joined:</strong> {{ formattedDate(user.created_at) }}</p>
            <p v-if="isClient"><strong>Age:</strong> {{ user.age }}</p>
            <button @click="editProfile" class="btn btn-warning mt-3">Edit Profile</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Profile Form (Visible when editProfileMode is true) -->
    <div v-if="editProfileMode" class="card shadow-sm mt-4">
      <div class="card-body p-4">
        <h4>Edit Profile</h4>
        <form @submit.prevent="updateProfile">
          <div class="form-group mb-3">
            <label for="firstname">First Name</label>
            <input v-model="user.firstname" type="text" id="firstname" class="form-control" />
          </div>

          <div class="form-group mb-3">
            <label for="lastname">Last Name</label>
            <input v-model="user.lastname" type="text" id="lastname" class="form-control" />
          </div>

          <div class="form-group mb-3">
            <label for="contact">Contact Number</label>
            <input v-model="user.contact" type="text" id="contact" class="form-control" />
          </div>

          <div class="form-group mb-3">
            <label for="email">Email</label>
            <input v-model="user.email" type="email" id="email" class="form-control" disabled />
          </div>

          <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
        <button @click="cancelEdit" class="btn btn-secondary mt-3">Cancel</button>
      </div>
    </div>

    <!-- Toggle Edit Form Button -->
    <div class="text-center mt-4">
      <button class="btn btn-primary" @click="toggleForm">{{ showForm ? 'Cancel' : 'Update Info' }}</button>
    </div>

    <!-- Profile Update Form -->
    <div v-if="showForm" class="update-form mt-4">
      <form @submit.prevent="updateUser">
        <div class="card mx-auto" style="width: 35rem;">
          <div class="card-body">
            <h5 class="card-title">Update {{ user.firstname }} {{ user.lastname }}</h5>

            <div class="form-group">
              <label for="firstname">First Name:</label>
              <input v-model="updatedUser.firstname" type="text" id="firstname" class="form-control" required />
            </div>

            <div class="form-group mt-3">
              <label for="lastname">Last Name:</label>
              <input v-model="updatedUser.lastname" type="text" id="lastname" class="form-control" required />
            </div>

            <div class="form-group mt-3">
              <label for="email">Email:</label>
              <input v-model="updatedUser.email" type="email" id="email" class="form-control" required />
            </div>

            <div class="form-group mt-3">
              <label for="contact">Contact:</label>
              <input v-model="updatedUser.contact" type="text" id="contact" class="form-control" required />
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
              <input v-model="updatedUser.age" type="number" id="age" class="form-control" required />
            </div>

            <div class="form-group mt-3" v-if="isClient">
              <label for="national_id">National ID:</label>
              <input v-model="updatedUser.national_id" type="text" id="national_id" class="form-control" required />
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
  components: {
    Backbutton
  },
  data() {
    return {
      user: null, // User data loaded from local storage or API
      updatedUser: {}, // Object for storing updated user info
      showForm: false, // Toggle form visibility
      isClient: false, // Determine if the logged-in user is a client
      profilePhotoUrl: '', // Profile photo URL
      editProfileMode: false, // Flag to toggle between view and edit mode
      selectedFile: null, // For handling the uploaded profile photo
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
    // Handle the file input change
    chooseFile(event) {
      this.selectedFile = event.target.files[0];
      this.uploadProfilePhoto(); // Immediately upload the new photo
    },

    // Update the profile photo on the server
    uploadProfilePhoto() {
      const formData = new FormData();
      formData.append('profile_photo', this.selectedFile);

      axios.post('/api/update-profile-photo', formData)
        .then(response => {
          this.fetchUserProfile(); // Refresh the user profile after the photo upload
          alert('Profile photo updated successfully!');
        })
        .catch(error => {
          console.error('Error uploading profile photo:', error);
        });
    },

    // Enable edit mode
    editProfile() {
      this.editProfileMode = true;
    },

    // Cancel edit and revert back to view mode
    cancelEdit() {
      this.editProfileMode = false;
    },

    // Save updated profile data
    updateProfile() {
      axios.put('/api/user', this.user)
        .then(response => {
          this.editProfileMode = false;
          alert('Profile updated successfully!');
        })
        .catch(error => {
          console.error('Error updating profile:', error);
        });
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
