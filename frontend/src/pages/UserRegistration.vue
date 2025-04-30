<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 60rem;">
                <h5 class="card-header">Register User</h5>
                <div class="card-body">
                    <form @submit.prevent="register" class="register-form">
                        <div class="row mb-3">
                            <label for="firstname" class="col-sm-2 col-form-label">First Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="firstname" v-model="form.firstname"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lastname" class="col-sm-2 col-form-label">Last Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lastname" v-model="form.lastname" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" v-model="form.email" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password:</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" v-model="form.password"
                                    minlength="8" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="age" class="col-sm-2 col-form-label">Age:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="age" v-model="form.age" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="national_id" class="col-sm-2 col-form-label">National ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="national_id" v-model="form.national_id"
                                    required>
                            </div>
                        </div>
                        <div class="form-check">
                            <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="male" v-model="form.gender"
                                        value="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="female" v-model="form.gender"
                                        value="female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="contact" class="col-sm-2 col-form-label">Contact:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="contact" v-model="form.contact" required>
                            </div>
                        </div>
                        <br>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            &nbsp; &nbsp;
                            <button type="submit" class="btn btn-success" name="submit"
                                value="Register">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import { reactive } from 'vue';
import router from '../router/router';

const form = reactive({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    age: '',
    gender: '',
    national_id: '',
    contact: '',

});

const register = async () => {
    const newUser = {
        firstname: form.firstname,
        lastname: form.lastname,
        email: form.email,
        password: form.password,
        age: form.age,
        gender: form.gender,
        national_id: form.national_id,
        contact: form.contact,
        usertype: "client"
    }
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/register', newUser);
        console.log(response);  // Check the API response
        alert('User registered successfully');
        router.push('/login');
    } catch (error) {
        if (error.response && error.response.data) {
            console.error('Validation errors:', error.response.data.errors);
        } else {
            console.error('Registration failed:', error.message);
        }
        alert('Registration failed. Please try again.');
    }
}
</script>

<style scoped>
* {
    background-color: white;
}

.container {
    min-height: 100vh;
    /* Full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    margin: auto;
}

.register-form .form-control {
    width: 450px;
}

.register-form {
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
