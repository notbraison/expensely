<template>
    <div class="booking-catalog">
      <h1 class="text-center mb-4">Booking Catalog</h1>
      <div v-if="bookings.length === 0" class="alert alert-warning text-center">
        No bookings found.
      </div>
      <table v-else class="table table-striped">
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Room Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Purpose</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in bookings" :key="booking.booking_id">
            <td>{{ booking.booking_id }}</td>
            <td>{{ booking.user_id }}</td>
            <td>{{ booking.room.room_name }}</td>
            <td>{{ formatDate(booking.start_date) }}</td>
            <td>{{ formatDate(booking.end_date) }}</td>
            <td>
              <span class="badge" :class="getStatusClass(booking.status)">
                {{ booking.status }}
              </span>
            </td>
            <td>{{ booking.purpose }}</td>
            <td>
              <button class="btn btn-info" @click="viewBooking(booking.booking_id)">View</button>
              <button class="btn btn-danger" @click="deleteBooking(booking.booking_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
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
        bookings: [], // Array to hold booking data
      };
    },
    created() {
      this.fetchBookings(); // Fetch bookings when component is created
    },
    methods: {
      async fetchBookings() {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/bookings'); // Fetch bookings from API
          this.bookings = response.data; // Assign response data to bookings
        } catch (error) {
          console.error('Error fetching bookings:', error);
        }
      },
      formatDate(dateString) {
        return new Date(dateString).toLocaleDateString(); // Format date for display
      },
      getStatusClass(status) {
        return status === 'confirmed' ? 'bg-success' : status === 'pending' ? 'bg-warning' : 'bg-danger'; // Status badge classes
      },
      viewBooking(id) {
        this.$router.push(`/bookings/${id}`); // Navigate to booking detail page
      },
      async deleteBooking(id) {
        if (confirm('Are you sure you want to delete this booking?')) {
          try {
            await axios.delete(`http://127.0.0.1:8000/api/bookings/${id}`); // Send delete request to API
            this.fetchBookings(); // Refresh booking list after deletion
          } catch (error) {
            console.error('Error deleting booking:', error);
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .booking-catalog {
    padding: 2rem;
  }
  
  .table {
    width: 100%;
    margin-top: 1rem;
  }
  
  .btn {
    margin-right: 0.5rem;
  }
  </style>
  