<template>
    <div>
      <h5>Rooms for {{ building_name }} (Floor {{ floor_number }})</h5>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Room ID</th>
            <th scope="col">Room Name</th>
            <th scope="col">Size(ft<sup>2</sup>)</th>
            <th scope="col">Number of Bedrooms</th>
            <th scope="col">Rate</th>
            <th scope="col">Type</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(room, index) in rooms" :key="room.id" class="clickable-row">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ room.room_id }}</td>
            <td>{{ room.room_name }}</td>
            <td>{{ room.size }}</td>
            <td>{{ room.number_of_bedrooms }}</td>
            <td>{{ room.rate}}  {{ room.currency }}</td>
            <td>{{ room.type }}</td>
            <td>{{ room.status }}</td>
            <td>
              <button class="btn btn-warning btn-sm" @click="editRoom(room.room_id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deleteRoom(room.room_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <br> <br>
      <div class="text-right">
        <button class="btn btn-success" @click="addRoom(floor_id)">Add Room</button>
      </div> <br> <br>
  
      <p v-if="error" class="text-danger">{{ error }}</p>
    </div>

    <br>
    <Backbutton/>
    <br> <br>
  </template>
  
  <script>
  import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';
  
  export default {
    components:{
      Backbutton
    },
    name: 'RoomList',
    props: {
      floor_id: {
        type: String,
        required: true,
      },
      floor_name: {
        type: String,
        default: '',
      },
      floor_number: {
        type: String,
        default: '',
      },
      building_name: {
        type: String,
        default: '',
      },
      location: {
        type: String,
        default: '',
      },
    },
    data() {
      return {
        rooms: [],
        error: null,
      };
    },
    methods: {
        async getRooms() {
    try {
        const response = await axios.get(`http://127.0.0.1:8000/api/rooms/floor/${this.floor_id}`); // Correctly fetch rooms for the specific floor
        this.rooms = response.data; // No need to filter here if you're getting specific floor rooms directly
    } catch (error) {
        console.error('Error fetching rooms:', error);
        this.error = 'Error fetching rooms: ' + (error.response ? error.response.data.message : error.message);
    }
},
  
      addRoom(floor_id) {
        this.$router.push(`/addRoom/${floor_id}`); // Adjust the route for adding a room
      },
  
      editRoom(room_id) {
        this.$router.push(`/editroom/${room_id}`); 
      },
  
      async deleteRoom(room_id) {
        if (confirm('Are you sure you want to delete this room?')) {
          try {
            await axios.delete(`http://127.0.0.1:8000/api/rooms/${room_id}`);
            this.getRooms(); // Reload rooms after deletion
          } catch (error) {
            console.error('Error deleting room:', error);
            this.error = 'Error deleting room: ' + (error.response ? error.response.data.message : error.message);
          }
        }
      }
    },
    mounted() {
      this.getRooms(); // Fetch rooms when component is mounted
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
  .text-right {
    margin-top: 20px;
  }
  </style>
  