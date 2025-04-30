<template>
    <div class="container my-5">
      <h2 class="text-center mb-4">Admin Comment on this room</h2>
      <form @submit.prevent="submitComment" class="text-center">
        <div class="mb-3">
          <textarea 
            v-model="commentText" 
            placeholder="Document any issues or notable events concerning this room" 
            required 
            class="form-control mx-auto" 
            rows="5"
            style="max-width: 900px;" 
          ></textarea>
        </div>
        
        <input type="hidden" v-model="roomId" />
        <input type="hidden" v-model="adminId" />
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  
    <Backbutton/>
  </template>
  
  <script>
  import axios from 'axios';
  import Backbutton from '../components/Backbutton.vue';
  
  export default {
    components: {
      Backbutton
    },
    data() {
      return {
        commentText: '',
        roomId: this.$route.params.id, // Retrieve roomId from route parameters
        adminId: '' // Will hold the logged-in admin's ID
      };
    },
    created() {
      this.getAdminIdFromLocalStorage(); // Retrieve adminId
    },
    methods: {
      getAdminIdFromLocalStorage() {
        const user = JSON.parse(localStorage.getItem('user'));
        if (user && user.admin_id) {
          this.adminId = user.admin_id; // Set adminId from local storage
        }
      },
      async submitComment() {
        try {     
          console.log(this.commentText);
          console.log(this.roomId);
          console.log(this.adminId);
  
          await axios.post('http://127.0.0.1:8000/api/comments', {
            comment_text: this.commentText, // Comment text
            room_id: this.roomId,            // Room ID
            admin_id: this.adminId,          // Admin ID
          });
          this.$router.push('/comments-catalog'); // Redirect after submission
        } catch (error) {
          console.error('Error adding comment:', error);
          alert('Failed to add comment. Please try again later.'); // User feedback
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any styles for the Add Comment component here */
  </style>
  