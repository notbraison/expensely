<template>
    <div class="container my-5">
      <h2 class="text-center mb-4">Add a Comment</h2>
      <form @submit.prevent="submitComment" class="text-center">
        <div class="mb-3">
          <textarea 
            v-model="commentText" 
            placeholder="Share your experience..." 
            required 
            class="form-control mx-auto" 
            rows="5"
            style="max-width: 900px;" 
          ></textarea>
        </div>
        <input type="hidden" v-model="paymentId" />
        <!-- <input type="hidden" v-model="roomId" /> -->
        <input type="hidden" v-model="userId" />
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
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
            commentText: '',
            paymentId: this.$route.query.paymentId, // Retrieve paymentId from query parameters
            roomId: this.$route.query.roomId, // Retrieve roomId from query parameters
            userId: '' // Will hold the logged-in user's ID
        };
    },
    created() {
        this.getUserIdFromLocalStorage(); // Retrieve userId
    },
    methods: {
        getUserIdFromLocalStorage() {
            const user = JSON.parse(localStorage.getItem('user'));
            if (user && user.user_id) {
                this.userId = user.user_id;
            }
        },
        async submitComment() {
    try {
        console.log(this.commentText); // Ensure you are logging the correct variable
        console.log(this.paymentId);
        console.log(this.roomId);
        console.log(this.userId);
        
        await axios.post('http://127.0.0.1:8000/api/comments', {
            comment_text: this.commentText, // Change this line to match the expected key
            payment_id: this.paymentId,
            room_id: this.roomId,
            user_id: this.userId,
        });
        this.$router.push('/testimonials');
    } catch (error) {
        console.error('Error adding comment:', error);
        alert('Failed to add comment. Please try again later.'); // Simple user feedback
    }
},
    },
};
</script>

<style scoped>
/* Add any styles for the Add Comment component here */
</style>
