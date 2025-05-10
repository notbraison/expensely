    <template>
    <div>
      <h1 class="text-3xl font-bold mb-6">Your Friends</h1>
      <Friends/>


<br>
      <h1 class="text-3xl font-bold mb-6">Your Groups</h1>
      
      <!-- Create Group Button (Visible only if user is logged in) -->
      <div class="mb-4">
        <button 
          v-if="isLoggedIn"
          @click="openCreateGroupForm" 
          class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 transition"
        >
          Create Group
        </button>
        <p v-if="!isLoggedIn" class="text-gray-500">Please log in to create a group.</p>
      </div>
  
      <!-- Display Groups -->
      <div v-if="groups.length > 0">
        <div v-for="group in groups" :key="group.id" class="bg-white p-4 rounded-lg shadow-md mb-4">
          <h2 class="text-xl font-semibold">{{ group.name }}</h2>
          <div class="flex items-center space-x-4">
            <router-link :to="`/groups/${group.id}`" class="text-blue-500 hover:underline">View Group</router-link>
            <button 
              @click="openManageMembers(group)"
              class="text-green-500 hover:underline"
            >
              Manage Members
            </button>
          </div>
        </div>
      </div>
  
      <!-- No Groups Message -->
      <div v-else>
        <p>No groups found. Create a new group to get started!</p>
      </div>
  
      <!-- Create Group Form Modal -->
      <div v-if="showCreateGroupForm" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg w-1/3">
          <h2 class="text-2xl font-semibold mb-4">Create New Group</h2>
          <group-form @close="closeCreateGroupForm" @created="fetchGroups" />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import GroupForm from '../components/GroupForm.vue';  // Import the GroupForm component
  import Friends from '../components/Friends.vue';
  
  export default {
    name: 'Groups',
    components: {
      GroupForm,
      Friends
    },
    data() {
      return {
        groups: [],
        showCreateGroupForm: false,
        isLoggedIn: false,
        userId: localStorage.getItem('userId') || null // Get userId from localStorage
      };
    },
    mounted() {
      if (this.userId) {
        this.fetchGroups(); // Fetch groups if user is logged in
      }
      this.isLoggedIn = !!this.userId; // Check if user is logged in
    },
    methods: {
      fetchGroups() {
        // Fetch groups for the logged-in user
        axios.get(`/api/groups/user/${this.userId}`)
          .then(response => {
            this.groups = response.data.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
      openCreateGroupForm() {
        this.showCreateGroupForm = true;
      },
      closeCreateGroupForm() {
        this.showCreateGroupForm = false;
      },
      openManageMembers(group) {
        this.$router.push({ name: 'manageMembers', params: { groupId: group.id } });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Scoped styles for this component */
  </style>
  