<template>
    <!-- This modal will allow the Owner to add new members and assign roles like Owner, Member, or Viewer. -->
  <div class="role-modal">
    <div class="modal-content">
      <h3>Add Member</h3>
      <label for="memberName">Name</label>
      <input type="text" id="memberName" v-model="newMember.name" />

      <label for="role">Role</label>
      <select v-model="newMember.role">
        <option value="Owner">Owner</option>
        <option value="Member">Member</option>
        <option value="Viewer">Viewer</option>
      </select>

      <button @click="addMember">Add</button>
      <button @click="$emit('close')">Cancel</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    group: Object
  },
  data() {
    return {
      newMember: {
        name: '',
        role: 'Member'
      }
    };
  },
  methods: {
    addMember() {
      if (this.newMember.name && this.newMember.role) {
        this.group.members.push({ ...this.newMember });
        this.$emit('close');
      }
    }
  }
};
</script>

<style scoped>
.role-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  width: 300px;
}

input, select {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
}

button {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>
