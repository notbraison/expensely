<template>
  <div class="container-lg mt-5">
    <h1 class="text-center mb-4">Book Your Room</h1>
    <form @submit.prevent="bookRoom">

      <div class="row mb-3">
        <label for="purpose" class="col-sm-2 col-form-label">Purpose of Booking</label>
        <div class="col-sm-10">
          <textarea
            name="purpose"
            v-model="purpose"
            class="form-control large-textarea"
            id="purpose"
            rows="7"
            placeholder="Enter your purpose of booking this room"
            required
          ></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <label for="startDate" class="col-sm-2 col-form-label">Check-in Date</label> 
        <div class="col-sm-10">
          <Datepicker
            v-model="startDate"
            class="form-control"
            placeholder="       Select check-in date"
            required
          />
        </div>
      </div>

      <div class="row mb-3">
        <label for="endDate" class="col-sm-2 col-form-label">Check-out Date</label>
        <div class="col-sm-10">
          <Datepicker
            v-model="endDate"
            class="form-control"
            placeholder="       Select check-out date"
            required
          />
        </div>
      </div>

      <br>
      <div class="form-button">
        <button type="submit" class="btn btn-primary btn-lg">Confirm Booking</button>
      </div>
      <br><br>
    </form>
  </div>

  <Backbutton/>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import Datepicker from '@vuepic/vue-datepicker'; // Importing the component
import '@vuepic/vue-datepicker/dist/main.css';  // Importing its styles
import Backbutton from '../components/Backbutton.vue';

export default {
  components: {
    Datepicker,
    Backbutton
  },
  data() {
    return {
      roomId: this.$route.params.room_id || null,
      purpose: '',
      startDate: ref(null), // Correct use of ref()
      endDate: ref(null),   // Correct use of ref()
      userId: '',
    };
  },
  methods: {
    async bookRoom() {
    // Log the booking details to see what data is being sent
    /* console.log({
        user_id: this.userId,
        room_id: this.roomId,
        purpose: this.purpose,
        start_date: this.startDate ? this.startDate.toISOString().slice(0, 10) : null,
        end_date: this.endDate ? this.endDate.toISOString().slice(0, 10) : null,
    }); */

    const bookingDetails = {
        user_id: this.userId,
        room_id: this.roomId,
        purpose: this.purpose,
        start_date: this.startDate ? this.startDate.toISOString().slice(0, 10) : null,
        end_date: this.endDate ? this.endDate.toISOString().slice(0, 10) : null,
    };

    try {
        const response = await axios.post('http://127.0.0.1:8000/api/book', bookingDetails);
        alert('Booking successful! Proceeding to payment...');
        
        // Retrieve booking_id from the response
        const bookingId = response.data.booking.booking_id; // Update this line

        // Redirect to the payment page using the retrieved bookingId and roomId
        this.$router.push(`/payment/${bookingId}/${this.roomId}`); // Ensure this.roomId is used correctly
    } catch (error) {
        console.error('Error booking room:', error.response?.data || error);
        alert('Booking failed: ' + JSON.stringify(error.response?.data.errors || error.message));
    }
},
  },
  mounted() {
    const user = localStorage.getItem('user');
    if (user) {
        const parsedUser = JSON.parse(user);
        this.userId = parsedUser.user_id; // Make sure this is correct
    } else {
        console.log('User not found in local storage.');
    }
}
};

</script>

<style scoped>
  .container-lg {
    max-width: 800px;
    margin: 0 auto;
  }

  .large-textarea {
    width: 100%;
    height: 150px;
    font-size: 1.1rem;
  }

  .form-control {
    width: 100%;
    font-size: 1.1rem;
  }

  .btn-lg {
    font-size: 1.25rem;
    padding: 0.75rem 1.5rem;
  }

  .form-button {
    text-align: center;
    margin-top: 20px;
  }
</style>
