<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 60rem;">
                <h5 class="card-header">Edit Building</h5>
                <div class="card-body">
                    <form @submit.prevent="updateBuilding">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="row mb-3">
                            <label for="building_id" class="col-sm-2 col-form-label">Building ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="building_id" v-model="form.building_id">
                        </div>
                        </div>

                        <div class="row mb-3">
                            <label for="building_name" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="building_name" v-model="form.building_name"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="location" class="col-sm-2 col-form-label">Location:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="location" v-model="form.location" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="number_of_floors" class="col-sm-2 col-form-label">Number of Floors:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="number_of_floors"
                                    v-model="form.number_of_floors" required>
                            </div>
                        </div>
                        <br>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            &nbsp; &nbsp;
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <Backbutton/>
</template>

<script setup>

import axios from 'axios';
import { reactive, onMounted } from 'vue';
import router from '../router/router';
import { useRoute } from 'vue-router';//for getting usr id
import Backbutton from '../components/Backbutton.vue';

const route = useRoute();//above explained

const building_id = route.params.id;

const state = reactive({
    building: {},
});//to track state of user



const form = reactive({
    building_id:'',
    building_name: '',
            location: '',
            number_of_floors: '',
});

const updateBuilding = async () => {
    const updatedBuilding = {
        building_id:form.building_id,
        building_name: form.building_name,
        location: form.location,
        number_of_floors: form.number_of_floors,
    }
    try {
        //console.log(updatedBuilding)
        //await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');//set csrf token
        const response = await axios.put(`http://127.0.0.1:8000/api/building/${building_id}`, updatedBuilding);
        alert('Building updated successfully');
        router.push('/buildings');
    } catch (error) {        
            console.error('Update failed:', error);
        }

    }


onMounted(async () => {
    try {
        const response = await axios.get(`http://127.0.0.1:8000/api/building/${building_id}`);
        state.building = response.data;

        //populate inputs
        form.building_id = state.building.building_id;
        form.building_name = state.building.building_name;
        form.location = state.building.location;
        form.number_of_floors = state.building.number_of_floors;
    } catch (error) {
        console.error('error fetching user:', error)
    }
});
</script>

<style>
* {
    background-color: white;
}

.btn-container {
    padding: 10px;
}

h5 {
    text-align: center;
}

.card {
    display: flex;
    justify-content: center;
    align-items: center;
    width: auto;
    height: auto;
    padding-top: 50px;
}

.form-control {
    width: 450px;
}

.link {
    text-decoration: underline;
    font-weight: 800;
}
</style>
