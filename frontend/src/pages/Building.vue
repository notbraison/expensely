<template>
    <div>
        <h5>Buildings</h5>
        <br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Number of Floors</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(building, index) in buildings" :key="building.building_id" class="clickable-row">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ building.building_id }}</td>
                    <td>{{ building.building_name }}</td>                    
                    <td>{{ building.location }}</td>
                    <td>{{ building.number_of_floors }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" @click="edit(building)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="delete(building.building_id,building.building_name)">Delete</button>
                        <button class="btn btn-outline-info" @click="floor(building.building_id,building.building_name)">Floors</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br><br><br>
    <router-link to="/addbuilding" tag="button" class="btn btn-warning btn-sm">Add Building</router-link>
<br>
<Backbutton/>
<br>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
    name: "Buildings",
    components:{
Backbutton
    },
    data() {
        return {
            buildings: []
        };
    },
    methods: {
        async retrieve() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/buildings');
                this.buildings = response.data;
            } catch (error) {
                console.error('Error fetching buildings:', error);
            }
        },
        edit(building) {
            this.$router.push(`/editbuilding/${building.building_id}`);
        },
        floor(building_id) {
            this.$router.push(`/floors/${building_id}`);
        },
        async delete(building_id,building_name) {
            try {
                alert(`${building_name} will be deleted`);
                const response = await axios.delete(`http://127.0.0.1:8000/api/building/${building_id}`);
                if(response.status === 200){
                    alert(`building: ${building_name}  has been deleted`);
                    this.retrieve();
                }else{
                    console.error('Error deleting building:', response.data.message);
                }
                               
            } catch (error) {
                console.error('Error deleting building:',  error.response ? error.response.data.message : error.message);
                alert(`Error deleting building: ${error.response ? error.response.data.message : error.message}`);
            }
        }
    },
    created() {
        this.retrieve();
    }
}
</script>

<style>
.clickable-row {
    transition: background-color 0.3s;
}

.clickable-row:hover {
    background-color: #f0f0f0;
}

.clickable-row:active {
    background-color: #e0e0e0;
}

.table th, .table td {
    vertical-align: middle;
}

.btn {
    margin-right: 5px;
}
</style>
