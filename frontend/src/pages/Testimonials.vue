<template>
  <div>
    <h2>Customer Testimonials</h2>
    <div v-for="note in logNotes" :key="note.note_id" class="mb-4">
      <p><strong>{{ note.user.firstname }} {{ note.user.lastname }}</strong> on {{ formatDate(note.created_at) }}</p>
      <p>{{ note.log_note_text }}</p>
      <router-link :to="`/room/${note.room_id}`">View Room</router-link>
      
      <!-- Button to navigate to edit comment page -->
      <div v-if="note.user.user_id === loggedInUserId">
        <router-link :to="`/edit-comment/${note.note_id}`" class="btn btn-primary btn-sm mt-2">Edit Comment</router-link>
      </div>
    </div>
  </div>
  <Backbutton/>
</template>

<script>
import axios from 'axios';
import Backbutton from '../components/Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  data() {
    return {
      logNotes: [],
      loggedInUserId: '', // Variable to hold the logged-in user's ID
    };
  },
  created() {
    this.fetchLogNotes();
    this.getUserIdFromLocalStorage(); // Fetch logged-in user's ID
  },
  methods: {
    async fetchLogNotes() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/log-notes');
        this.logNotes = response.data;
      } catch (error) {
        console.error('Error fetching log notes:', error);
      }
    },
    getUserIdFromLocalStorage() {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.user_id) {
        this.loggedInUserId = user.user_id; // Set logged-in user ID
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
  },
};
</script>

<style scoped>
.mb-4 {
  margin-bottom: 1.5rem;
}
</style>
