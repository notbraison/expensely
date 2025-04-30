<template>
  <div>
    <h5>Room List</h5> <br> <br>

    <!-- Filter Section -->
    <div class="row g-3">

      <!-- Filter by Building -->
      <div class="col-sm">
        <select v-model="selectedBuilding" @change="filterRooms" class="form-control">
          <option value="">All Buildings</option>
          <option v-for="building in buildings" :key="building.building_id" :value="building.building_id">
            {{ building.building_name }} - {{ building.location }}
          </option>
        </select>
      </div>

      <!-- Filter by Status -->
      <div class="col-sm">
        <select v-model="selectedStatus" @change="filterRooms" class="form-control">
          <option value="">All Status</option>
          <option value="vacant">Vacant</option>
          <option value="booked">Booked</option>
          <option value="maintenance">Maintenance</option>
        </select>
      </div>

      <!-- Filter by Location -->
      <div class="col-sm">
        <select v-model="selectedLocation" @change="filterRooms" class="form-control">
          <option value="">All Locations</option>
          <option v-for="building in buildings" :key="building.building_id" :value="building.location">
            {{ building.location }}
          </option>
        </select>
      </div>

      <!-- Filter by Room Type -->
      <div class="col-sm">
        <select v-model="selectedRoomType" @change="filterRooms" class="form-control">
          <option value="">All Room Types</option>
          <option value="studio">Studio</option>
          <option value="apartment">Apartment</option>
          <option value="suite">Suite</option>
        </select>
      </div>

      <!-- Filter by Rate -->
      <div class="col-sm">
        <input type="number" v-model="selectedRate" @input="filterRooms" class="form-control" placeholder="Max Rate" />
      </div>

      <!-- Filter by Room Size -->
      <div class="col-sm">
        <input type="number" v-model="selectedRoomSize" @input="filterRooms" class="form-control" placeholder="Min Size" />
      </div>
      
    </div> <br> <br>

    <!-- Room List Table -->
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Room ID</th>
          <th scope="col">Room Name</th>
          <th scope="col">Size (ft<sup>2</sup>)</th>
          <th scope="col">Number of Bedrooms</th>
          <th scope="col">Rate</th>
          <th scope="col">Type</th>
          <th scope="col">Status</th>
          <th scope="col">Building Name</th>
          <th scope="col">Location</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(room, index) in filteredRooms" :key="room.room_id" class="clickable-row">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ room.room_id }}</td>
          <td>{{ room.room_name }}</td>
          <td>{{ room.size }}</td>
          <td>{{ room.number_of_bedrooms }}</td>
          <td>{{ room.rate }} {{ room.currency }}</td>
          <td>{{ room.type }}</td>
          <td>{{ room.status }}</td>
          <td>{{ room.floor.building.building_name }}</td>
          <td>{{ room.floor.building.location }}</td>
          <td>
            <button class="btn btn-success btn-sm" @click="moreInfo(room.room_id)">More Info</button>
            <button class="btn btn-warning btn-sm" @click="editRoom(room.room_id)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteRoom(room.room_id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <br />
    <Backbutton/>
    <br />

    <p v-if="error" class="text-danger">{{ error }}</p>
  </div>
</template>

<script>
import axios from "axios";
import Backbutton from './Backbutton.vue';

export default {
  name: "RoomCatalog",
  components:{
        Backbutton
    },
  data() {
    return {
      rooms: [],
      buildings: [],
      selectedBuilding: "",
      selectedStatus: "",
      selectedLocation: "",
      selectedRoomType: "",
      selectedRate: "",
      selectedRoomSize: "",
      error: null,
    };
  },
  computed: {
    filteredRooms() {
      return this.rooms.filter((room) => {
        return (
          (!this.selectedBuilding || room.floor.building.building_id == this.selectedBuilding) &&
          (!this.selectedStatus || room.status == this.selectedStatus) &&
          (!this.selectedLocation || room.floor.building.location == this.selectedLocation) &&
          (!this.selectedRoomType || room.type == this.selectedRoomType) &&
          (!this.selectedRate || room.rate <= this.selectedRate) &&
          (!this.selectedRoomSize || room.size >= this.selectedRoomSize)
        );
      });
    },
  },
  methods: {
    moreInfo(room_id){
      this.$router.push(`/moreInfo/${room_id}`);
    },
    async getRooms() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/rooms");
        this.rooms = response.data;
      } catch (error) {
        console.error("Error fetching rooms:", error);
        this.error =
          "Error fetching rooms: " +
          (error.response ? error.response.data.message : error.message);
      }
    },

    async getBuildings() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/buildings");
        this.buildings = response.data;
      } catch (error) {
        console.error("Error fetching buildings:", error);
        this.error =
          "Error fetching buildings: " +
          (error.response ? error.response.data.message : error.message);
      }
    },

    filterRooms() {
      // This method will trigger the computed property to recalculate
    },

    addRoom(floor_id) {
      this.$router.push(`/addRoom/${floor_id}`);
    },

    editRoom(room_id) {
      this.$router.push(`/editroom/${room_id}`);
    },

    async deleteRoom(room_id) {
      if (confirm("Are you sure you want to delete this room?")) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/rooms/${room_id}`);
          this.getRooms(); // Reload rooms after deletion
        } catch (error) {
          console.error("Error deleting room:", error);
          this.error =
            "Error deleting room: " +
            (error.response ? error.response.data.message : error.message);
        }
      }
    },
  },
  mounted() {
    this.getRooms(); // Fetch rooms when component is mounted
    this.getBuildings(); // Fetch building list
  },
};
</script>

<style scoped>
.clickable-row {
  transition: background-color 0.3s;
}
.clickable-row:hover {
  background-color: #f0f0f0;
}
.clickable-row:active {
  background-color: #e0e0e0;
}
.table th,
.table td {
  vertical-align: middle;
}
.btn {
  margin-right: 5px;
}
.text-right {
  margin-top: 20px;
}
</style>
