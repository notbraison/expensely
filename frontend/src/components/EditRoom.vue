<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 100rem;">
                <h5 class="card-header">Edit Room (Room ID: {{ room.room_id }})</h5>
                <div class="card-body">
                    <form @submit.prevent="updateRoom">
                        <div class="mb-4">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Room Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="room.room_name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Size:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="room.size" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Number of Bedrooms:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" v-model="room.number_of_bedrooms" required min="0">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Type:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" v-model="room.type" required>
                                        <option value="">Select Room Type</option> <!-- Added default option -->
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
                                        <option value="">Select Status</option> <!-- Added default option -->
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

                        </div>
                        <!-- Submit button -->
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Update Room</button>
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
            room: {
                room_id: null,
                room_name: '',
                size: '',
                number_of_bedrooms: '',
                type: '',
                status: '',
                rate:'',
                currency:''
            },
            error: null
        };
    },
    methods: {
        
        // Fetch the room details based on the room ID
        async fetchRoomDetails() {
            const room_id = this.$route.params.id; // Get room ID from route
            console.log('Fetching room details for ID:', room_id); // Log room_id
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/room/${room_id}`);
                this.room = response.data; // Populate room data
            } catch (error) {
                console.error('Error fetching room details:', error);
                this.error = 'Error fetching room details: ' + (error.response ? error.response.data.message : error.message);
            }
        },

        // Update the room details
        async updateRoom() {
            try {
                const room_id = this.room.room_id; // Get room ID
                console.log(this.room)
                await axios.put(`http://127.0.0.1:8000/api/room/${room_id}`, this.room);
                // Redirect to the room listing or another appropriate page
                this.$router.push(`/floors/${this.room.floor_id}/rooms`); // Adjust the path as necessary
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    console.error('Validation errors:', error.response.data.errors);
                    this.error = 'Please correct the errors and try again.';
                } else {
                    console.error('Update failed:', error.message);
                    this.error = 'Failed to update room. Please try again later.';
                }
            }
        }
    },

    mounted() {
        this.fetchRoomDetails(); // Fetch room details when the component is mounted
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
