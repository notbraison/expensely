<template>
    <!-- This component handles the comment threads for each expense, allowing users to discuss specific expenses. -->
  <div class="expense-comments">
    <h4>Comments</h4>
    <div class="comments-list">
      <div v-for="(comment, index) in expense.comments" :key="index" class="comment">
        <p><strong>{{ comment.user }}</strong>: {{ comment.text }}</p>
      </div>
    </div>
    <textarea v-model="newComment" placeholder="Add a comment"></textarea>
    <button @click="addComment">Add Comment</button>
  </div>
</template>

<script>
export default {
  props: {
    expense: Object,
    userRole: String
  },
  data() {
    return {
      newComment: ''
    };
  },
  methods: {
    addComment() {
      if (this.newComment.trim()) {
        this.expense.comments.push({
          user: 'Current User',  // Replace with actual user name
          text: this.newComment
        });
        this.newComment = '';
      }
    }
  }
};
</script>

<style scoped>
.expense-comments {
  margin-top: 10px;
}

.comments-list {
  margin-bottom: 15px;
}

.comment {
  padding: 5px;
  background-color: #f9f9f9;
  border-radius: 5px;
  margin-bottom: 5px;
}

textarea {
  width: 100%;
  height: 60px;
  padding: 10px;
  margin-bottom: 10px;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>
