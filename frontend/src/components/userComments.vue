<template>
    <PageBar /> <br> <br>
  <div class="container my-5">
    <h2 class="text-center mb-4">Comments</h2>

    <div v-if="comments.length > 0">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Comment </th>
            <th scope="col">Added On</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="comment in comments" :key="comment.comment_id">
            
            <td>{{ comment.comment_text }}</td>
            <td>{{ formatDate(comment.created_at) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else>
      <p class="text-center">No comments available.</p>
    </div>
    
    <BackButton />
  </div>
</template>

<script>
import axios from 'axios';
import BackButton from './Backbutton.vue';
import PageBar from '../components/pageBar.vue';


export default {
    name:'comments',
  components: {
    BackButton,
    PageBar
  },
  data() {
    return {
      comments: [] // List of comments
    };
  },
  created() {
    this.fetchComments(); // Fetch comments when component is created
  },
  methods: {
    async fetchComments() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/comments'); // Fetch all comments
        this.comments = response.data;
      } catch (error) {
        console.error('Error fetching comments:', error);
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
