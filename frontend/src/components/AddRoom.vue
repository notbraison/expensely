<template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="card" style="width: 100rem;">
                    <h5 class="card-header">Add Rooms for {{ floor_name }} (Floor {{ floor_number }})</h5>
                    <div class="card-body">
                        <!-- Display building and floor info -->
                        <p><strong>Building Name:</strong> {{ building_name }}</p>
                        <p><strong>Location:</strong> {{ location }}</p>

                        
                        <!-- Display Existing Rooms -->
                        <div v-if="rooms.length > 0">
                            <h5>Existing Rooms</h5>
                            <!-- Room availability counter -->
                        <p>Rooms available: {{ remainingRooms }} out of {{ maxRooms }}</p>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Number of Bedrooms</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(room, index) in rooms" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{ room.room_name }}</td>
                                        <td>{{ room.size }}</td>
                                        <td>{{ room.number_of_bedrooms }}</td>
                                        <td>{{ room.type }}</td>
                                        <td>{{ room.status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- End of Existing Rooms Section -->
    
                        <form @submit.prevent="addRooms">
                            <!-- Dynamic form for adding rooms -->
                            <div v-for="(room, index) in newRooms" :key="index" class="mb-4">
                                <h5>Room {{ index + 1 }} (Remaining: {{ remainingRooms }})</h5>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Room Name:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="room.room_name" placeholder="e.g. 501" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Size:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" v-model="room.size" placeholder="in square feet" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Number of Bedrooms:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" v-model="room.number_of_bedrooms" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Type:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" v-model="room.type" required>
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
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Status:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" v-model="room.status" required>
                                            <option value="vacant">Vacant</option>
                                            <option value="booked">Booked</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Monthly Rate:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" v-model="room.rate" required min="0">
                                    </div>
                                </div>
    
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Currency:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" v-model="room.currency" required>
                                            <option value="Kenyan Shilling">Kenyan Shilling</option>
                                            <option value="US Dollar">US Dollar</option>
                                            <option value="Euro">Euro</option>
                                            <option value="Japanese Yen">Japanese Yen</option>
                                            <option value="Pound Sterling">Pound Sterling</option>
                                            <option value="Austrian Dollar">Austrian Dollar</option>
                                            <option value="Canadian Dollar">Canadian Dollar</option>
                                        </select>
                                    </div>
                                </div>

                                <br>
                            </div>
                        
                            <!-- Add Room button -->
                            <button type="button" class="btn btn-primary" @click="addRoom" :disabled="remainingRooms <= 0">Add Another Room</button>
                        
                            <!-- Submit and Reset buttons -->
                            <div class="col-auto">
                                <button class="btn btn-primary" type="reset" @click="resetForm">Reset</button>
                                &nbsp; &nbsp;
                                <button type="submit" class="btn btn-primary" name="submit" value="Register">Add Rooms</button>
                            </div>
                        
                            <!-- Error Messages -->
                            <div v-if="error" class="alert alert-danger mt-3">
                                {{ error }}
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
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
            newRooms: [],
            rooms: [],
            building_id: null,
            floor_id: null,
            building_name: '',
            location: '',
            floor_number: '',
            number_of_rooms: 0,
            maxRooms: 0,
            remainingRooms: 0,
            error: null
        };
    },
    methods: {
        // Add a new room entry to the newRooms array
        addRoom() {
            if (this.remainingRooms > 0) {
                this.newRooms.push({
                    room_name: '',
                    size: '',
                    number_of_bedrooms: '',
                    type: '',
                    status: ''
                });
            } else {
                alert('No more rooms can be added. Maximum number of rooms reached.');
            }
        },

        // Fetch the floor and building details from API
        async getFloorDetails() {
            const floor_id = this.$route.params.floor_id; // Get floor ID from route
            try {
                // Fetch floor details
                const floorResponse = await axios.get(`http://127.0.0.1:8000/api/floors/${floor_id}`);
                const floor = floorResponse.data;

                // Populate floor and building data
                this.building_id = floor.building_id;
                this.floor_number = floor.floor_number;
                this.number_of_rooms = floor.number_of_rooms; // Adjust this based on your API response
                this.floor_id = floor_id;

                // Fetch building info
                const buildingInfo = await axios.get(`http://127.0.0.1:8000/api/building/${this.building_id}`);
                this.building_name = buildingInfo.data.building_name;
                this.location = buildingInfo.data.location;

                // Set max rooms
                this.maxRooms = this.number_of_rooms; // Set max number of rooms

                // Fetch current number of rooms created for this floor
                const roomsResponse = await axios.get(`http://127.0.0.1:8000/api/rooms/floor/${this.floor_id}`);
                this.roomsCreated = roomsResponse.data.length; // Assuming the response is an array of rooms

                // Calculate remaining rooms
                this.remainingRooms = this.maxRooms - this.roomsCreated; // Calculate remaining rooms

                // Fetch existing rooms for the floor
                this.rooms = roomsResponse.data;

            } catch (error) {
                console.error('Error fetching floor or rooms:', error);
                this.error = 'Error fetching floor or rooms: ' + (error.response ? error.response.data.message : error.message);
            }
        },

        // Submit the form to add rooms
        async addRooms() {
    if (this.remainingRooms <= 0) {
        alert('No more rooms can be added. Maximum number of rooms reached.');
        return;
    }

    try {
        // Add each new room to the database
        for (const room of this.newRooms) {
            await axios.post('http://127.0.0.1:8000/api/rooms', {
                floor_id: this.floor_id,
                room_name: room.room_name,
                size: room.size,
                number_of_bedrooms: room.number_of_bedrooms,
                type: room.type,
                status: room.status,
                rate: room.rate,  // Add rate field
                currency: room.currency  // Add currency field
            });
        }

        // Decrement remaining rooms after all rooms are successfully added
        this.remainingRooms -= this.newRooms.length;

        // Redirect after adding rooms
        this.$router.push(`/floors/${this.floor_id}/rooms`);

        // Reset the newRooms array
        this.resetForm();
    } catch (error) {
        if (error.response && error.response.data.errors) {
            console.error('Validation errors:', error.response.data.errors);
            this.error = 'Please correct the errors and try again.';
        } else {
            console.error('Creation failed:', error.message);
            this.error = 'Failed to add rooms. Please try again later.';
        }
    }
},

        // Reset the form fields
        resetForm() {
            this.newRooms = []; // Clear the newRooms array
            this.rooms = []; // Optionally clear the existing rooms if needed
            this.error = null;
        }
    },

    mounted() {
        this.getFloorDetails(); // Fetch floor details when the component is mounted
    }
};

</script>

<style scoped>
.container {
    margin-top: 20px;
}

.card-header {
    background-color: #4CAF50;
    color: white;
    text-align: center;
}

.form-control {
    width: 100%;
}

button {
    margin-top: 10px;
}
</style>
