<template>
    <div>
      <h1 class="text-3xl font-bold mb-6">Manage Group Members</h1>
  
      <!-- List of Members -->
      <div v-if="members.length > 0">
        <div v-for="member in members" :key="member.id" class="bg-white p-4 rounded-lg shadow-md mb-4">
          <h3 class="text-xl font-semibold">{{ member.user.name }}</h3>
          <p>Role: {{ member.role }}</p>
          
          <!-- Update Role (Only for owner/admin) -->
          <div v-if="isOwnerOrAdmin" class="mt-4">
            <select v-model="member.role" @change="updateRole(member)" class="p-2 border rounded-md">
              <option value="owner">Owner</option>
              <option value="member">Member</option>
              <option value="viewer">Viewer</option>
            </select>
          </div>
  
          <!-- Remove Member (Only for owner) -->
          <div v-if="isOwnerOrAdmin && member.role !== 'owner'" class="mt-4">
            <button @click="removeMember(member)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
              Remove Member
            </button>
          </div>
        </div>
      </div>
  
      <!-- No Members Message -->
      <div v-else>
        <p>No members found for this group.</p>
      </div>
  
      <!-- Add Member Form -->
      <div v-if="isOwnerOrAdmin" class="mt-6">
        <h2 class="text-xl font-semibold">Add Member</h2>
        <form @submit.prevent="addMember">
          <input v-model="newMemberEmail" type="email" placeholder="Enter email to add" class="p-2 border rounded-md w-full" required />
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 hover:bg-blue-600 transition">
            Add Member
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        groupId: this.$route.params.groupId, // Group ID from the route
        members: [], // List of members in the group
        newMemberEmail: '', // Email for adding new members
        isOwnerOrAdmin: false, // Flag to check if the user is an owner or admin
      };
    },
    mounted() {
      // Fetch the members of the group when the component is mounted
      this.fetchGroupMembers();
    },
    methods: {
      // Fetch group members from the API
      fetchGroupMembers() {
        axios.get(`/api/groups/${this.groupId}/members`)
          .then(response => {
            this.members = response.data.data;
            this.isOwnerOrAdmin = this.members.some(member => member.user_id === this.$store.state.user.id && (member.role === 'owner' || member.role === 'admin'));
          })
          .catch(error => {
            console.error(error);
          });
      },
  
      // Add a new member to the group
      addMember() {
        axios.post(`/api/groups/${this.groupId}/members`, { email: this.newMemberEmail })
          .then(response => {
            this.fetchGroupMembers(); // Refresh the member list after adding a new member
            this.newMemberEmail = ''; // Clear the input field
          })
          .catch(error => {
            console.error(error);
          });
      },
  
      // Update the role of a group member
      updateRole(member) {
        axios.put(`/api/groups/${this.groupId}/members/${member.id}`, { role: member.role })
          .then(response => {
            this.fetchGroupMembers(); // Refresh the member list after updating a role
          })
          .catch(error => {
            console.error(error);
          });
      },
  
      // Remove a member from the group
      removeMember(member) {
        if (confirm(`Are you sure you want to remove ${member.user.name}?`)) {
          axios.delete(`/api/groups/${this.groupId}/members/${member.id}`)
            .then(() => {
              this.fetchGroupMembers(); // Refresh the member list after removal
            })
            .catch(error => {
              console.error(error);
            });
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Scoped styles for this component */
  </style>
<!-- 
Fetching Members: On mount (mounted()), we fetch the group members using the fetchGroupMembers() method.

This method calls an API to get all the members of a group.

It also checks if the current user is the owner or admin by looking at the user's role in the group.

List Members: All members of the group are displayed in a list.

For each member, their name and role are displayed.

If the user is the owner or admin, they can update roles or remove members.

Add Member:

The owner/admin can add a new member to the group by entering their email address in the input field and clicking the Add Member button.

This sends a POST request to the backend API to add the new member.

Update Role: The owner/admin can update the role of each member using a select dropdown. The roles include owner, member, and viewer. This sends a PUT request to the backend API.

Remove Member: The owner/admin can remove any member (except the owner). This sends a DELETE request to the backend API.
-->  