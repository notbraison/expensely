<template>
  <div>
    <h2>Edit Comment</h2>
    <form @submit.prevent="submitEdit">
      <textarea v-model="logNoteText" required></textarea>
      <button type="submit">Update</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      logNoteText: '',
      noteId: this.$route.params.noteId,
    };
  },
  created() {
    this.fetchLogNote();
  },
  methods: {
    async fetchLogNote() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/log-notes/${this.noteId}`);
        this.logNoteText = response.data.log_note_text;
      } catch (error) {
        console.error('Error fetching log note:', error);
      }
    },
    async submitEdit() {
      try {
        await axios.put(`http://127.0.0.1:8000/api/log-notes/${this.noteId}`, {
          log_note_text: this.logNoteText,
        });
        this.$router.push('/testimonials');
      } catch (error) {
        console.error('Error updating comment:', error);
      }
    },
  },
};
</script>
