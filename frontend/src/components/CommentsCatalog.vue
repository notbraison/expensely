<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">User Comments</h2>

    <div v-if="userComments.length > 0">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Comment ID</th>
            <th scope="col">User ID</th>
            <th scope="col">Room ID</th>
            <th scope="col">Payment ID</th>
            <th scope="col">Comment Text</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="comment in userComments" :key="comment.comment_id">
            <td>{{ comment.comment_id }}</td>
            <td>{{ comment.user_id }}</td>
            <td>{{ comment.room_id }}</td>
            <td>{{ comment.payment_id }}</td>
            <td>{{ comment.comment_text }}</td>
            <td>{{ formatDate(comment.created_at) }}</td>
            <td>
              <button class="btn btn-danger btn-sm" @click="deleteComment(comment.comment_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <br><br>
    <h2 class="text-center mb-4">Admin Comments</h2>

    <div v-if="adminComments.length > 0">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Comment ID</th>
            <th scope="col">Admin ID</th>
            <th scope="col">Room ID</th>
            <th scope="col">Comment Text</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="comment in adminComments" :key="comment.comment_id">
            <td>{{ comment.comment_id }}</td>
            <td>{{ comment.admin_id }}</td>
            <td>{{ comment.room_id }}</td>
            <td>{{ comment.comment_text }}</td>
            <td>{{ formatDate(comment.created_at) }}</td>
            <td>
              <button class="btn btn-danger btn-sm" @click="deleteComment(comment.comment_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else>
      <p class="text-center">No comments available.</p>
    </div>
  </div>
  <Backbutton />
</template>

<script>
import axios from 'axios';
import Backbutton from './Backbutton.vue';

export default {
  components: {
    Backbutton
  },
  data() {
    return {
      userComments: [], // List of user comments
      adminComments: [] // List of admin comments
    };
  },
  created() {
    this.fetchUserComments(); // Fetch user comments when component is created
    this.fetchAdminComments(); // Fetch admin comments when component is created
  },
  methods: {
    async fetchUserComments() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/comments');
        this.userComments = response.data; // Assign response to user comments
      } catch (error) {
        console.error('Error fetching user comments:', error);
      }
    },
    async fetchAdminComments() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/admin-comments');
        this.adminComments = response.data; // Assign response to admin comments
      } catch (error) {
        console.error('Error fetching admin comments:', error);
      }
    },
    async deleteComment(commentId) {
      try {
        const response = await axios.delete(`http://127.0.0.1:8000/api/comments/${commentId}`);
        if (response.status === 200) {
          alert('Comment deleted successfully');
          this.fetchUserComments(); // Refresh the user comments list
          this.fetchAdminComments(); // Refresh the admin comments list
        }
      } catch (error) {
        console.error('Error deleting comment:', error);
        alert('Failed to delete comment. Please try again later.');
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    }
  }
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}

.table th,
.table td {
  vertical-align: middle;
}
</style>
