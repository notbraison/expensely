<template>
  <div>
    <form @submit.prevent="createGroup">
      <div class="mb-4">
        <label for="groupName" class="block text-sm font-semibold">Group Name</label>
        <input
          v-model="name"
          id="groupName"
          type="text"
          class="w-full p-2 border border-gray-300 rounded mt-1"
          placeholder="Enter group name"
          required
        />
      </div>

      <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600 transition">
        Create Group
      </button>
    </form>

    <button @click="close" class="text-red-500 mt-4">Cancel</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: ''
    };
  },
  methods: {
    createGroup() {
      // Send a POST request to the backend to create the group
      axios.post('/api/groups', { name: this.name })
        .then(response => {
          this.$emit('created'); // Emit an event to notify Groups.vue to fetch groups again
          this.close(); // Close the form
        })
        .catch(error => {
          console.error(error);
        });
    },
    close() {
      this.$emit('close'); // Emit an event to close the form in Groups.vue
    }
  }
};
</script>

<style scoped>
/* Scoped styles for the form */
</style>
