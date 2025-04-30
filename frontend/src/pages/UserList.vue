<template>
    <div> <br>
        <h5>Users</h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Age</th>
                    <th scope="col">Gender</th>
                    <th scope="col">National ID</th>
                    <th scope="col">usertype</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Date Joined</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="user.user_id" class="clickable-row">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ user.firstname }}</td>
                    <td>{{ user.lastname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.age }}</td>
                    <td>{{ user.gender }}</td>
                    <td>{{ user.national_id }}</td>
                    <td>{{ user.usertype }}</td>
                    <td>{{ user.contact }}</td>
                    <td>{{ user.created_at}}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" @click="editUser(user.user_id)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteUser(user.user_id,user.firstname, user.lastname)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
    name: 'UserList',
    components:{
        Backbutton
        
    },
    data() {
        return {
            users: [],
        };
    },
    methods: {
        async retrieve() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/users');
                this.users = response.data.map(user => {
                    return{
                        ...user,
                        user_id:Number(user.user_id) || null //conveert userid to number handle undefined
                    }
                })
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        editUser(userId) {
            this.$router.push(`/edituser/${userId}`);
        },
        async deleteUser(userId, firstname, lastname) {
            try {
                alert(`${firstname} ${lastname} will be deleted`)
                const response = await axios.delete(`http://127.0.0.1:8000/api/user/${userId}`);
                if(response.status === 200){
                    alert(`user: ${firstname} ${lastname} of user id:${userId} has been deleted`);
                    this.retrieve();
                }else{
                    console.error('Error deleting user:', response.data.message);
                }
                               
            } catch (error) {
                console.error('Error deleting user:',  error.response ? error.response.data.message : error.message);
            }
        },
        
    },
    created() {
        this.retrieve();
    },
};
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
