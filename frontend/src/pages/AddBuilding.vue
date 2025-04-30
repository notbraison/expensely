<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 60rem;">
                <h5 class="card-header">Add Building</h5>
                <div class="card-body">
                    <form @submit.prevent="add">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row mb-3">
                            <label for="building_name" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="building_name" v-model="building_name"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="location" class="col-sm-2 col-form-label">Location:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="location" v-model="location" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="number_of_floors" class="col-sm-2 col-form-label">Number of Floors:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="number_of_floors"
                                    v-model="number_of_floors" required>
                            </div>
                        </div>
                        <br>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            &nbsp; &nbsp;
                            <button type="submit" class="btn btn-primary">Add</button>
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
import Backbutton from '../components/Backbutton.vue';

export default {
    name: 'AddBuilding',
    components:{
Backbutton
    },
    data() {
        return {
            building_name: '',
            location: '',
            number_of_floors: '',
        };
    },
    methods: {
        async add() {
            try {
                await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');//set csrf token  
            
                const response = await axios.post('http://127.0.0.1:8000/api/building', {
                    building_name: this.building_name,
                    location: this.location,
                    number_of_floors: this.number_of_floors,
                });
                
                console.log('Building added:', response.data);
                this.$router.push('/buildings');
            } catch (error) {
                console.error('Creation failed:', error.message);
            }
        }
    }
};
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
