<template>
  <div class="container my-5">
    <div v-if="rooms.length > 0">
      <h2 class="text-center mb-4">Your Rented Rooms</h2>

      <!-- Display rooms in cards -->
      <div class="row justify-content-center"> <!-- Added justify-content-center to center the cards -->
        <div v-for="room in rooms" :key="room.room_id" class="col-lg-4 col-md-6 mb-4"> <!-- Added col-md-6 for better responsiveness -->
          <div class="card h-100 shadow-sm border-0">
            <img :src="room.image_url || 'default-room-image.jpg'" class="card-img-top" alt="Room Image" />
            <div class="card-body">
              <h5 class="card-title">Room {{ room.room_name }}</h5>
              <p><strong>Type:</strong> {{ room.type }}</p>
              <p><strong>Size:</strong> {{ room.size }} sqft</p>
              <p><strong>Number of Bedrooms:</strong> {{ room.number_of_bedrooms }}</p>
              <p>
                <strong>Status:</strong>
                <span :class="room.status === 'booked' ? 'badge bg-danger' : 'badge bg-success'">{{ room.status }}</span>
              </p>
              <p><strong>Price:</strong> {{ room.rate }} {{ room.currency }}</p>
              <p><strong>Booking Period:</strong> {{ room.booking.start_date }} - {{ room.booking.end_date }}</p>
              <p><strong>Purpose:</strong> {{ room.booking.purpose }}</p>
              
              <!-- Button to add a comment -->
              <router-link :to="{ path: '/add-comment', query: { paymentId: room.payment_id, roomId: room.room_id } }">
                <button class="btn btn-secondary mt-2">Add a Comment</button>
              </router-link>              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p class="text-center">You have not rented any rooms yet.</p>
    </div>
  </div>
  <Backbutton/>
</template>


<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
  data() {
    return {
      userId: '', // Will hold the logged-in user's ID
      rooms: []   // List of rented rooms
    };
  },
  created() {
    this.getUserIdFromLocalStorage(); // Retrieve user_id
    this.fetchRentedRooms(); // Fetch rooms when component is created
  },
  methods: {
    getUserIdFromLocalStorage() {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.user_id) {
        this.userId = user.user_id;
      }
    },
    async fetchRentedRooms() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/user/${this.userId}/rented-rooms`);
        this.rooms = response.data;
      } catch (error) {
        console.error('Error fetching rented rooms:', error);
      }
    }
  }
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}
.card {
  border-radius: 10px;
  border: none;
}
.card-img-top {
  border-radius: 10px 10px 0 0; /* Rounded top corners for the image */
}
.card-title {
  font-size: 1.25rem;
  font-weight: bold;
}
.badge {
  font-size: 0.9rem; /* Adjust badge font size */
}
</style>
