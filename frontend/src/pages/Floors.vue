<template>
    <div>
      <h5>Floors for {{ building.building_name }}</h5>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Number of Rooms</th>
            <th scope="col">Floor Number</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(floor, index) in floors" :key="floor.floor_id" class="clickable-row">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ floor.floor_id }}</td>
            <td>{{ floor.number_of_rooms }}</td>
            <td>{{ floor.floor_number }}</td>
            <td>
              <button class="btn btn-warning btn-sm" @click="edit(floor)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="delete(floor.floor_id, floor.floor_number)">Delete</button>
              <button class="btn btn-primary btn-sm" @click="room(floor.floor_id)">Rooms</button>
            </td>
          </tr>
        </tbody>
      </table>
      <br><br>
      <button class="btn btn-warning btn-sm" @click="addFloor">Add Floor</button>
      <br><br>
    </div>

    <br>
    <Backbutton/>    <br>
  </template>
  
  <script>
  import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';
  
  export default {
    name: "Floors",
    components:{
      Backbutton
    },
    data() {
      return {
        building: {}, // Initialize the building as an empty object
        floors: [],
        buildingId: '' // Ensure buildingId is initialized
      };
    },
    methods: {
      async getBuilding() {
        const building_id = this.$route.params.building_id; // Get building_id from route
        try {
          const response = await axios.get(`http://127.0.0.1:8000/api/building/${building_id}`);
          this.building = response.data; // Assign the fetched building data
          this.buildingId = this.building.building_id;
          this.retrieveFloors(); // Fetch floors after setting buildingId
        } catch (error) {
          console.error('Error fetching building:', error);
        }
      },
      async retrieveFloors() {
        try {
          const response = await axios.get(`http://127.0.0.1:8000/api/floors/building/${this.buildingId}`);
          this.floors = response.data.floors;
          this.building_name = response.data.building.building_name;
          this.location = response.data.building.location;
          this.maxFloors = response.data.building.number_of_floors;
          this.remainingFloors = response.data.remaining_floors;
          this.nextFloorNumber = response.data.next_floor_number;
        } catch (error) {
          console.error('Error fetching floors:', error);
        }
      },
      edit(floor) {
        this.$router.push(`/editfloor/${floor.floor_id}`);
      },
      async delete(floor_id, floor_number) {
        try {
          const confirmDelete = confirm(`Are you sure you want to delete Floor: ${floor_number}?`);
          if (confirmDelete) {
            const response = await axios.delete(`http://127.0.0.1:8000/api/floor/${floor_id}`);
            if (response.status === 200) {
              alert(`Floor ${floor_number} has been deleted.`);
              this.retrieveFloors(); // Refresh the list after deletion
            } else {
              console.error('Error deleting floor:', response.data.message);
            }
          }
        } catch (error) {
          console.error('Error deleting floor:', error.response ? error.response.data.message : error.message);
          alert(`Error deleting floor: ${error.response ? error.response.data.message : error.message}`);
        }
      },
      room(floor_id) {
        this.$router.push(`/floors/${floor_id}/rooms`); // Pass the floor_id correctly
    },
      addFloor() {
        this.$router.push(`/addfloor/${this.building.building_id}`);
      }
    },
    created() {
      this.getBuilding(); // Fetch building details when component is created
    }
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
  </style>
  