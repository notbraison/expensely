<template>
    <div><br> <br>
        <h5>Payments</h5>
        <br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Payment ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Room ID</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Paid At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(payment, index) in payments" :key="payment.payment_id" class="clickable-row">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ payment.payment_id }}</td>
                    <td>{{ payment.user_id }}</td>
                    <td>{{ payment.room_id }}</td>
                    <td>{{ payment.amount }}</td>
                    <td>{{ payment.status }}</td>
                    <td>{{ payment.paid_at }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" @click="viewDetails(payment)">View</button>
                        <button class="btn btn-danger btn-sm" @click="delete(payment.payment_id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <Backbutton/>
    <br>
</template>

<script>
import axios from 'axios';
import Backbutton from './Backbutton.vue';

export default {
    name: "Payments",
    components:{
        Backbutton
    },
    data() {
        return {
            payments: []
        };
    },
    methods: {
        async retrieve() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/payments');
                this.payments = response.data;
            } catch (error) {
                console.error('Error fetching payments:', error);
            }
        },
        viewDetails(payment) {
            // Navigate to a details page for the payment
            this.$router.push(`/payment-details/${payment.payment_id}`);
        },
        async delete(payment_id) {
            try {
                const response = await axios.delete(`http://127.0.0.1:8000/api/payments/${payment_id}`);
                if (response.status === 200) {
                    alert(`Payment ID: ${payment_id} has been deleted`);
                    this.retrieve(); // Refresh the list
                } else {
                    console.error('Error deleting payment:', response.data.message);
                }
            } catch (error) {
                console.error('Error deleting payment:', error.response ? error.response.data.message : error.message);
                alert(`Error deleting payment: ${error.response ? error.response.data.message : error.message}`);
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

.table th, .table td {
    vertical-align: middle;
}

.btn {
    margin-right: 5px;
}
</style>
