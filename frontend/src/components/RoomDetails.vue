<template>
  <br>
  <div class="container">
    <h1 class="text-center mb-4">Room Details</h1>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Room {{ room.room_name }}</h5>
        <img :src="room.image_url || 'default-room-image.jpg'" class="card-img-top" alt="Room Image" />
        <div class="mb-3">
          <p><strong>Size:</strong> {{ room.size }}</p>
          <p><strong>Number of Bedrooms:</strong> {{ room.number_of_bedrooms }}</p>
          <p><strong>Type:</strong> {{ room.type }}</p>
          <p><strong>Monthly Rate:</strong> ${{ room.rate }}</p>
          <p><strong>Status:</strong> <span class="badge bg-success">{{ room.status }}</span></p>
          <p v-if="building"><strong>Building:</strong> {{ building.building_name }}</p>
          <p v-if="building"><strong>Location:</strong> {{ building.location }}</p>
          <p v-if="floor"><strong>Floor Number:</strong> {{ floor.floor_number }}</p>
        </div>
        <div v-if="role === 'user'">
          <button class="btn btn-primary" @click="bookRoom(room.room_id)">Book Now</button>
        </div>
      </div>
    </div>

    <!-- Swiper for Room Images -->
    <h2 class="text-center my-4">Room Images</h2>
    <RoomImageSwiper />

    <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
  </div>

  <br>

 <Backbutton/>

  <br><br>
</template>

<script>
import axios from 'axios';
import RoomImageSwiper from '../components/RoomImageSwiper.vue'; // Import the new component
import Backbutton from './Backbutton.vue';


export default {
  components:{
    RoomImageSwiper,
        Backbutton
    },
  data() {
    return {
      room: {},
      floor: null,
      building: null,
      role: null,
      error: null,
    };
  },
  components: {
    RoomImageSwiper,
  },
  methods: {
    async fetchRoomDetails() {
      const room_id = this.$route.params.id; // Get room ID from route parameters
      try {
        // Fetch room details
        const roomResponse = await axios.get(`http://127.0.0.1:8000/api/room/${room_id}`);
        this.room = roomResponse.data;
        const floor_id = this.room.floor_id;

        // Fetch floor details using floor_id from room
        const floorResponse = await axios.get(`http://127.0.0.1:8000/api/floors/${floor_id}`);
        this.floor = floorResponse.data;
        const building_id = this.floor.building_id;

        // Fetch building details using building_id from floor
        const buildingResponse = await axios.get(`http://127.0.0.1:8000/api/building/${building_id}`);
        this.building = buildingResponse.data;

      } catch (error) {
        console.error('Error fetching room details:', error);
        this.error = 'Error fetching room details: ' + (error.response ? error.response.data.message : error.message);
      }
    },
    async bookRoom(room_id) {
      this.$router.push(`/bookRoom/${room_id}`);
    }
  },
  mounted() {
    this.fetchRoomDetails(); // Fetch room details when the component is mounted
    this.role = localStorage.getItem('role'); // Retrieve role from localStorage
  },
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}

.card {
  border: 1px solid #ddd;
}

.card-title {
  font-weight: bold;
}

.badge {
  font-size: 0.85rem;
}

.btn {
  margin-top: 10px;
  width: 100%;
}
</style>
