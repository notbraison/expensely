<template>
    <div class="container my-5">
        <h2 class="text-center mb-4">Payment Details</h2>
        <div v-if="payment" class="card p-4">
            <h3 class="mb-3">Payment Information</h3>
            <p><strong>Payment ID:</strong> {{ payment.payment_id }}</p>
            <p><strong>Amount:</strong> {{ payment.amount }}</p>
            <p><strong>Status:</strong> {{ payment.status }}</p>
            <p><strong>Paid At:</strong> {{ payment.paid_at }}</p>
            <p><strong>Transaction ID:</strong> {{ payment.transaction_id }}</p>
            <p><strong>Payment Method:</strong> {{ payment.payment_method }}</p>
            <p><strong>Payment Account:</strong> {{ payment.payment_account }}</p>

            <h3 class="mt-4 mb-3">User Information</h3>
            <p v-if="userInfo"><strong>Name:</strong> {{ userInfo.firstname }} {{ userInfo.lastname }}</p>
            <p v-if="userInfo"><strong>Email:</strong> {{ userInfo.email }}</p>
            <p v-if="userInfo"><strong>Contact:</strong> {{ userInfo.contact }}</p>

            <h3 class="mt-4 mb-3">Booking Information</h3>
            <p v-if="bookingInfo"><strong>Purpose:</strong> {{ bookingInfo.purpose }}</p>
            <p v-if="bookingInfo"><strong>Status:</strong> {{ bookingInfo.status }}</p>
            <p v-if="bookingInfo"><strong>Start Date:</strong> {{ bookingInfo.start_date }}</p>
            <p v-if="bookingInfo"><strong>End Date:</strong> {{ bookingInfo.end_date }}</p>
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
            payment: null,
            userInfo: null,
            bookingInfo: null,
        };
    },
    created() {
        const paymentId = this.$route.params.payment_id; // Get payment ID from route parameters
        this.fetchPaymentDetails(paymentId);
    },
    methods: {
        async fetchPaymentDetails(paymentId) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/payments/${paymentId}`);
                this.payment = response.data.payment; // Access the payment object

                // Fetch user and booking info
                await this.fetchUserInfo(this.payment.user_id);
                await this.fetchBookingInfo(this.payment.booking_id);
            } catch (error) {
                console.error('Error fetching payment details:', error);
            }
        },
        async fetchUserInfo(userId) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`);
                this.userInfo = response.data; // Access the user object
            } catch (error) {
                console.error('Error fetching user info:', error);
            }
        },
        async fetchBookingInfo(bookingId) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/bookings/${bookingId}`);
                this.bookingInfo = response.data; // Access the booking object
            } catch (error) {
                console.error('Error fetching booking info:', error);
            }
        },
    },
};
</script>

<style scoped>
.card {
    border: 1px solid #dee2e6; /* Add a border */
    border-radius: 0.25rem; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.card h3 {
    border-bottom: 2px solid #007bff; /* Bottom border for headings */
    padding-bottom: 0.5rem; /* Space below the heading */
}

.container {
    max-width: 600px; /* Limit the width of the container */
}
</style>