<template>
    <div class="container mt-5">
      <h5 class="mb-4">Your Friends</h5>
      
      <!-- Search Bar to Search Friends by ID -->
      <div class="mb-4">
        <input
          v-model="searchQuery"
          type="text"
          class="form-control"
          placeholder="Search friends by name or ID"
        />
      </div>
  
      <!-- Friends Table -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Profile</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Iterate over the filtered list of friends -->
          <tr v-for="(friend, index) in filteredFriends" :key="friend.user_id">
            <th scope="row">{{ index + 1 }}</th>
            
            <!-- Friend Profile (with icon/image) -->
            <td>
              <img :src="friend.profile_picture" alt="Profile" class="rounded-circle" width="40" height="40" />
            </td>
  
            <!-- Friend ID -->
            <td>{{ friend.user_id }}</td>
  
            <!-- Friend Name -->
            <td>{{ friend.first_name }} {{ friend.last_name }}</td>
  
            <td>
              <!-- Actions: View Profile, Remove Friend -->
              <button class="btn btn-outline-info btn-sm" @click="viewProfile(friend)">
                <i class="fas fa-eye"></i> View
              </button>
              <button class="btn btn-danger btn-sm" @click="removeFriend(friend)">
                <i class="fas fa-user-times"></i> Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- No Friends Found -->
      <div v-if="filteredFriends.length === 0" class="text-center text-muted">
        No friends found.
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  export default {
    data() {
      return {
        friends: [], // To store friends' data
        searchQuery: "", // To filter friends by search
      };
    },
    computed: {
      // Filter friends based on search query
      filteredFriends() {
        return this.friends.filter((friend) => {
          const name = `${friend.first_name} ${friend.last_name}`.toLowerCase();
          return (
            name.includes(this.searchQuery.toLowerCase()) ||
            friend.user_id.toString().includes(this.searchQuery)
          );
        });
      },
    },
    mounted() {
      this.fetchFriends();
    },
    methods: {
      // Fetch the logged-in user's friends from the API
      fetchFriends() {
        const userId = localStorage.getItem("userId"); // Get user ID from local storage
        axios
          .get(`/api/friends/${userId}`)
          .then((response) => {
            this.friends = response.data.data;
          })
          .catch((error) => {
            console.error("Error fetching friends:", error);
          });
      },
      // Navigate to the selected friend's profile
      viewProfile(friend) {
        this.$router.push({ name: "profile", params: { userId: friend.user_id } });
      },
      // Remove a friend from the list
      removeFriend(friend) {
        const confirmRemove = confirm(`Are you sure you want to remove ${friend.first_name} ${friend.last_name} from your friends?`);
        if (confirmRemove) {
          axios
            .delete(`/api/friends/${friend.user_id}`)
            .then(() => {
              this.fetchFriends(); // Refresh the list after removing
              alert(`${friend.first_name} has been removed from your friends list.`);
            })
            .catch((error) => {
              console.error("Error removing friend:", error);
            });
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Styling for the table and actions */
  .table {
    background-color: #f8f9fa;
  }
  
  .table th,
  .table td {
    vertical-align: middle;
  }
  
  .table td img {
    object-fit: cover;
  }
  
  button {
    margin-right: 5px;
  }
  
  /* Style for the Profile image */
  img.rounded-circle {
    border: 2px solid #ddd;
  }
  
  /* Responsive Styles */
  @media (max-width: 767px) {
    .table {
      font-size: 0.9rem;
    }
  }
  </style>
  