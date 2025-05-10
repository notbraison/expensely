<template>
  <div>
    <h3>Add a Friend</h3>
    
    <!-- Add Friend by Email -->
    <div class="mb-4">
      <input v-model="email" type="email" class="form-control" placeholder="Enter friend email" />
      <button @click="sendFriendRequestByEmail" class="btn btn-primary mt-2">Send Friend Request</button>
    </div>

    <!-- Add Friend from Google Contacts -->
    <div class="mb-4">
      <button @click="connectWithGoogle" class="btn btn-outline-danger">Connect with Google</button>
    </div>

    <div v-if="googleContacts.length > 0">
      <h4>Google Contacts</h4>
      <ul>
        <li v-for="contact in googleContacts" :key="contact.email">
          {{ contact.name }} - {{ contact.email }}
          <button @click="sendFriendRequest(contact.email)" class="btn btn-outline-info btn-sm">Add Friend</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      googleContacts: [],
    };
  },
  methods: {
    sendFriendRequestByEmail() {
      axios
        .post('/api/friends/email', { email: this.email })
        .then((response) => {
          alert('Friend request sent');
        })
        .catch((error) => {
          console.error(error);
        });
    },
    connectWithGoogle() {
      // Handle Google OAuth to fetch contacts
      window.location.href = '/google/callback';
    },
    sendFriendRequest(email) {
      axios
        .post('/api/friends/email', { email })
        .then((response) => {
          alert('Friend request sent');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
