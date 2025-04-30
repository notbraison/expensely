<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 60rem;">
                <h5 class="card-header">Update Client</h5>
                <div class="card-body">
                    <form @submit.prevent="updateUser">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <fieldset>
                            <div class="row mb-3">
                                <label for="userId" class="col-sm-2 col-form-label">UserId:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="userId" name="userId"
                                        v-model="form.userId">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="firstname" class="col-sm-2 col-form-label">First Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        v-model="form.firstname" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="lastname" class="col-sm-2 col-form-label">Last Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        v-model="form.lastname" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="age" class="col-sm-2 col-form-label">Age:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="age" name="age" v-model="form.age"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="national_id" class="col-sm-2 col-form-label">National ID:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="national_id" name="national_id"
                                        v-model="form.national_id" required>
                                </div>
                            </div>
                            <fieldset class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="male" name="gender"
                                            value="male" v-model="form.gender" required>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="female" name="gender"
                                            value="female" v-model="form.gender" required>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="row mb-3">
                                <label for="contact" class="col-sm-2 col-form-label">Contact:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contact" name="contact"
                                        v-model="form.contact" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email"
                                        v-model="form.email" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="usertype" class="col-sm-2 col-form-label">usertype:</label>
                                <div class="col-sm-10">
                                    <input type="usertype" class="form-control" id="usertype" name="usertype"
                                        v-model="form.usertype" required>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset">Reset</button>
                                &nbsp; &nbsp;
                                <button type="submit" class="btn btn-primary" name="update"
                                    value="Update">Update</button>
                            </div>
                        </fieldset>
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

const userId = route.params.id;

const state = reactive({
    user: {},
    isLoading: true
});//to track state of user



const form = reactive({
    userId: '',
    firstname: '',
    lastname: '',
    email: '',
    age: '',
    gender: '',
    national_id: '',
    contact: '',
    usertype: ''

});

const updateUser = async () => {
    const updatedUser = {
        user_id:userId,
        firstname: form.firstname,
        lastname: form.lastname,
        email: form.email,
        age: form.age,
        gender: form.gender,
        national_id: form.national_id,
        contact: form.contact,
        usertype: form.usertype
    }
    try {
        //console.log(updatedUser)
        //await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');//set csrf token this might NEED be uncommented
        const response = await axios.put(`http://127.0.0.1:8000/api/user/${userId}`, updatedUser);
        alert('User updated successfully');
        router.push('/users');
    } catch (error) {        
            console.error('Update failed:', error);
        }

    }


onMounted(async () => {
    try {
        const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`);
        state.user = response.data;

        //populate inputs
        form.userId = state.user.user_id;
        form.firstname = state.user.firstname;
        form.lastname = state.user.lastname;
        form.email = state.user.email;
        form.age = state.user.age;
        form.gender = state.user.gender;
        form.national_id = state.user.national_id;
        form.contact = state.user.contact;
        form.usertype = state.user.usertype;

    } catch (error) {
        console.error('error fetching user:', error)
    } finally {
        state.isLoading = false;
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