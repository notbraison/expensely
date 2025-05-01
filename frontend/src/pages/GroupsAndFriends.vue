<template>
    <div class="groups-friends">
      <div class="header">
        <h1>{{ group.name }} - Groups & Friends</h1>
        <p>{{ group.description }}</p>
      </div>
  
      <!-- Group Role Management -->
      <div class="roles-section">
        <h2>Manage Group Roles</h2>
        <div v-if="userRole === 'Owner'">
          <button @click="showRoleModal = true">Add Member</button>
          <RoleModal v-if="showRoleModal" :group="group" @close="showRoleModal = false" />
        </div>
        <div v-for="(member, index) in group.members" :key="index" class="role">
          <p>{{ member.name }} - {{ member.role }}</p>
          <span v-if="userRole === 'Owner'">
            <button @click="editRole(member)">Edit Role</button>
          </span>
        </div>
      </div>
  
      <!-- Expense List & Comment Threads -->
      <div class="expenses-section">
        <h2>Expenses</h2>
        <div v-for="(expense, index) in group.expenses" :key="expense.id" class="expense-item">
          <div class="expense-info">
            <h3>{{ expense.name }}</h3>
            <p>Amount: {{ expense.amount }}</p>
            <p>Split: {{ expense.splitRule }}</p>
          </div>
          <!-- Comments Section -->
          <ExpenseComments :expense="expense" :user-role="userRole" />
        </div>
      </div>
  
      <!-- Group Splitting Rules -->
      <div class="splitting-rules">
        <h2>Group Splitting Rules</h2>
        <p>Select preset splitting rules for this group’s recurring expenses:</p>
        <ul>
          <li @click="selectSplitRule('Equal Split')">Equal Split</li>
          <li @click="selectSplitRule('Percentage Split')">Percentage Split</li>
          <li @click="selectSplitRule('One Pays All')">One Pays All</li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import RoleModal from '../components/RoleModal.vue';
  import ExpenseComments from '../components/ExpenseComments.vue';
  
  export default {
    name: 'GroupsAndFriends',
    components: {
      RoleModal,
      ExpenseComments
    },
    data() {
      return {
        showRoleModal: false, // Control visibility of the role assignment modal
        userRole: 'Owner', // The role of the current user (Owner, Member, Viewer)
        group: {
          name: 'Family Budget',
          description: 'Manage your family group expenses',
          members: [
            { name: 'Alice', role: 'Owner' },
            { name: 'Bob', role: 'Member' },
            { name: 'Charlie', role: 'Viewer' }
          ],
          expenses: [
            { id: 1, name: 'Groceries', amount: 120, splitRule: 'Equal Split' },
            { id: 2, name: 'Utilities', amount: 150, splitRule: 'Percentage Split' }
          ]
        }
      };
    },
    methods: {
      editRole(member) {
        console.log(`Editing role for ${member.name}`);
        // Implement role editing logic here
      },
      selectSplitRule(rule) {
        console.log(`Selected split rule: ${rule}`);
        // Implement rule selection logic here
      }
    }
  };
  </script>
  
  <style scoped>
  .groups-friends {
    padding: 20px;
  }
  
  .header {
    margin-bottom: 20px;
  }
  
  .roles-section {
    margin-bottom: 20px;
  }
  
  .expenses-section {
    margin-bottom: 20px;
  }
  
  .splitting-rules {
    margin-bottom: 20px;
  }
  
  .role {
    margin-bottom: 10px;
  }
  
  button {
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  </style>
  