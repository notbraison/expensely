<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 100rem;">
                <h5 class="card-header">Add Floors and Rooms for {{ building_name }}</h5>
                <div class="card-body">
                    <!-- Display how many floors can be added -->
                    <p>Floors available: {{ remainingFloors }} out of {{ maxFloors }}</p>

                    <form @submit.prevent="addFloors">
                        <!-- Building name and location -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Building Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="building_name" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Location:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="location" disabled>
                            </div>
                        </div>

                        <!-- Dynamic form for adding floors -->
                        <div v-for="(floor, index) in floors" :key="index" class="mb-4">
                            <h5>Floor {{ index + 1 }}</h5>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Floor Number:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="floor.floor_number" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Number of Rooms:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" v-model="floor.number_of_rooms" :disabled="floor.isExisting" required>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Add Floor button -->
                        <button type="button" class="btn btn-secondary mb-4" @click="addFloor">Add Floor</button>

                        <!-- Submit and Reset buttons -->
                        <div class="col-auto">
                            <button class="btn btn-primary" type="reset" @click="resetForm">Reset</button>
                            &nbsp; &nbsp;
                            <button type="submit" class="btn btn-primary" name="submit" value="Register">Add</button>
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
    <br>
    <br>
</template>


<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
    name: 'AddFloor',
    components:{
        Backbutton
    },
    data() {
        return {
            building_name: '',
            location: '',
            building_id: '', // Store building ID
            floors: [], // Store all floors with details, including number_of_rooms
            maxFloors: 0, // Max number of floors allowed
            remainingFloors: 0, // Remaining floors that can be added
            nextFloorNumber: 1 // Next auto-filled floor number
        };
    },
    methods: {
        // Add a new floor entry
        addFloor() {
    if (this.remainingFloors <= 0) {
        alert('Cannot add more floors. Maximum number of floors reached.');
        return;
    }

    // Add a new floor object to the `floors` array
    this.floors.push({
        floor_number: this.nextFloorNumber, // Auto-incremented floor number
        number_of_rooms: '', // Initially empty for user to fill in
        rooms: [{ room_number: '' }], // Optionally add rooms here
        isExisting: false // Mark as a new floor
    });

    // Decrease remaining floors and increment next floor number
    this.remainingFloors--;
    this.nextFloorNumber++;
},
    // Add a new room to a specific floor
    addRoom(floorIndex) {
    this.floors[floorIndex].rooms.push({ room_number: '' }); // Add a new room to the floor
},

// Remove a specific room from a floor
removeRoom(floorIndex, roomIndex) {
    this.floors[floorIndex].rooms.splice(roomIndex, 1); // Remove a specific room
}
,

        // Fetch the building details from API and populate the form
        async getBuilding() {
            const building_id = this.$route.params.building_id; // Get building ID from route
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/building/${building_id}`);
                const building = response.data;

                // Populate building data
                this.building_name = building.building_name;
                this.location = building.location;
                this.building_id = building_id; // Set building ID for submission

                // Fetch floors data for the building
                this.retrieveFloors();
            } catch (error) {
                console.error('Error fetching building:', error);
            }
        },

        // Fetch existing floors and populate the form with them
        async retrieveFloors() {
    try {
        const response = await axios.get(`http://127.0.0.1:8000/api/floors/building/${this.building_id}`);
        const data = response.data;

        this.maxFloors = data.building.number_of_floors;
        this.remainingFloors = data.remaining_floors;
        this.nextFloorNumber = data.next_floor_number;

        // Add existing floors to the `floors` array
        data.floors.forEach(floor => {
            this.floors.push({
                floor_number: floor.floor_number,
                number_of_rooms: floor.number_of_rooms, // Prefill number of rooms
                rooms: floor.rooms, // Prefill existing rooms if any
                isExisting: true // Mark as existing floor
            });
        });
    } catch (error) {
        console.error('Error fetching floors:', error);
    }
},
        // Submit the form to add floors and rooms
        async addFloors() {
    try {
        const newFloors = this.floors.filter(floor => !floor.isExisting);

        if (newFloors.length === 0) {
            this.error = 'No new floors to add.';
            return;
        }

        for (const floor of newFloors) {
            const response = await axios.post('http://127.0.0.1:8000/api/floors', {
                building_id: this.building_id,  
                floor_number: String(floor.floor_number), 
                number_of_rooms: String(floor.number_of_rooms)
            });

            console.log('Response from API:', response.data); // Log the entire response for inspection

            // Extract the floor_id from the response
            const building_id = response.data.floor.building_id; // Access floor_id from the correct path

            if (!building_id) {
                console.error('building ID not found in response:', response.data);
                this.error = 'Failed to retrieve building ID from the response.';
                return;
            }

            console.log('Floor added successfully:', response.data);
            this.$router.push(`/floors/${building_id}`); // Redirect after adding
        }
    } catch (error) {
        if (error.response && error.response.data.errors) {
            console.error('Validation errors:', error.response.data.errors);
            this.error = 'Please correct the errors and try again.';
        } else {
            console.error('Creation failed:', error.message);
            this.error = 'Failed to add floors. Please try again later.';
        }
    }
},

        // Reset the form fields
        resetForm() {
            this.building_name = '';
            this.location = '';
            this.floors = [
                {
                    floor_number: '',
                    number_of_rooms: '',
                    rooms: [{ room_number: '' }]
                }
            ];
            this.nextFloorNumber = 1;
            this.remainingFloors = this.maxFloors;
        }
    },

    mounted() {
        this.getBuilding(); // Fetch building info when the component is mounted
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
