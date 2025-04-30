<template>
    <div>
        <br>
        <br>
        <h5 style="text-decoration:underline" >Admins</h5>
        <br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">admintype</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Date Joined</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(admin, index) in admins" :key="admin.admin_id" class="clickable-row">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ admin.firstname }}</td>
                    <td>{{ admin.lastname }}</td>
                    <td>{{ admin.email }}</td>
                    <td>{{ admin.usertype }}</td>
                    <td>{{ admin.contact }}</td>
                    <td>{{ admin.created_at}}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" @click="editadmin(admin.admin_id)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteadmin(admin.admin_id,admin.firstname, admin.lastname)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>
    <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
    name: 'adminList',
    components:{
        Backbutton
    },
    data() {
        return {
            admins: [],
        };
    },
    methods: {
        async retrieve() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/admin/index');
                this.admins = response.data.map(admin => {
                    return{
                        ...admin,
                        admin_id:Number(admin.admin_id) || null //conveert adminid to number handle undefined
                    }
                })
            } catch (error) {
                console.error('Error fetching admins:', error);
            }
        },
        editadmin(adminId) {
            this.$router.push(`/editadmin/${adminId}`);
        },
        async deleteadmin(adminId, firstname, lastname) {
            try {
                alert(`${firstname} ${lastname} will be deleted`)
                const response = await axios.delete(`http://127.0.0.1:8000/api/admin/${adminId}`);
                if(response.status === 200){
                    alert(`admin: ${firstname} ${lastname} of admin id:${adminId} has been deleted`);
                    this.retrieve();
                }else{
                    console.error('Error deleting admin:', response.data.message);
                }
                               
            } catch (error) {
                console.error('Error deleting admin:',  error.response ? error.response.data.message : error.message);
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
