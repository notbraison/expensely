<template>
  <div class="container">
    <h1 class="text-center mb-4">Available Rooms</h1>

    <!-- Filter Section -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <select v-model="selectedBuilding" @change="filterRooms" class="form-control">
          <option value="">All Buildings</option>
          <option v-for="building in buildings" :key="building.building_id" :value="building.building_id">
            {{ building.building_name }} - {{ building.location }}
          </option>
        </select>
      </div>

      <div class="col-md-4">
        <select v-model="selectedRoomType" @change="filterRooms" class="form-control">
          <option value="">All Room Types</option>
          <option value="standard room">Standard Room</option>
          <option value="single room">Single Room</option>
          <option value="twin room">Twin Room</option>
          <option value="bedsitter">Bedsitter</option>
          <option value="studio">Studio</option>
          <option value="deluxe room">Deluxe Room</option>
          <option value="suite">Suite</option>
          <option value="king room">King Room</option>
          <option value="queen room">Queen Room</option>
        </select>
      </div>

      <div class="col-md-4">
        <input type="number" v-model="selectedRate" @input="filterRooms" class="form-control" placeholder="Max Rate" />
      </div>

      <div class="col-md-4">
        <input type="number" v-model="selectedRoomSize" @input="filterRooms" class="form-control" placeholder="Min Size" />
      </div>
    </div>

    <!-- Display Rooms -->
    <div class="row">
      <div class="col-md-4" v-for="room in filteredRooms" :key="room.room_id">
        <div class="card mb-4">
          <img :src="room.image_url || 'default-room-image.jpg'" class="card-img-top" alt="Room Image" />
          <div class="card-body">
            <h5 class="card-title">{{ room.room_name }}</h5>
            <p class="card-text">Size: {{ room.size }} ft<sup>2</sup></p>
            <p class="card-text">Number of Bedrooms: {{ room.number_of_bedrooms }}</p>
            <p class="card-text">Type: {{ room.type }}</p>
            <p class="card-text">Rate: {{ room.rate }}</p>
            <button class="btn btn-primary" @click="viewRoomDetails(room.room_id)">More Info</button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!filteredRooms.length" class="alert alert-warning text-center">No rooms available matching your criteria.</div>
  </div>
  <br>
  <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  data() {
    return {
      vacantRooms: [],
      buildings: [],
      selectedBuilding: "",
      selectedRoomType: "",
      selectedRate: "",
      selectedRoomSize: "",
    };
  },
  computed: {
    filteredRooms() {
      return this.vacantRooms.filter((room) => {
        return (
          (!this.selectedBuilding || room.floor.building.building_id == this.selectedBuilding) &&
          (!this.selectedRoomType || room.type == this.selectedRoomType) &&
          (!this.selectedRate || room.rate <= this.selectedRate) &&
          (!this.selectedRoomSize || room.size >= this.selectedRoomSize)
        );
      });
    },
  },
  methods: {
    async fetchVacantRooms() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/rooms/vacant'); // Adjust the API endpoint as needed
        this.vacantRooms = response.data;
      } catch (error) {
        console.error('Error fetching vacant rooms:', error);
      }
    },
    async fetchBuildings() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/buildings');
        this.buildings = response.data;
      } catch (error) {
        console.error('Error fetching buildings:', error);
      }
    },
    viewRoomDetails(room_id) {
      this.$router.push(`/roominfo/${room_id}`); // Adjust the path as necessary
    },
    filterRooms() {
      // Trigger computed property recalculation
    },
  },
  mounted() {
    this.fetchVacantRooms(); // Fetch the vacant rooms when the component is mounted
    this.fetchBuildings(); // Fetch building list
  }
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
  width: 100%;
}
</style>
