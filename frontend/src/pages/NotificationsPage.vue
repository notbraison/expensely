<template>
  <div class="container py-5">
    <h2 class="text-center mb-4">Notifications</h2>

    <!-- Filter Notifications by Type -->
    <div class="d-flex justify-content-between mb-4">
      <div>
        <button @click="filterNotifications('all')" class="btn btn-outline-primary mr-2">
          All Notifications
        </button>
        <button @click="filterNotifications('upcoming')" class="btn btn-outline-warning mr-2">
          Upcoming Bills
        </button>
        <button @click="filterNotifications('overdue')" class="btn btn-outline-danger mr-2">
          Overdue Payments
        </button>
        <button @click="filterNotifications('friend_requests')" class="btn btn-outline-info">
          Friend Requests
        </button>
      </div>
      <div>
        <button @click="markAllAsRead" class="btn btn-success">Mark All as Read</button>
      </div>
    </div>

    <!-- Notifications List -->
    <div v-if="filteredNotifications.length > 0">
      <ul class="list-group">
        <li v-for="notification in filteredNotifications" :key="notification.id" class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ notification.title }}</strong>
            <p class="text-muted">{{ notification.message }}</p>
            <small class="text-muted">{{ notification.date }}</small>
          </div>
          <div>
            <button v-if="!notification.read" @click="markAsRead(notification.id)" class="btn btn-sm btn-outline-success">
              Mark as Read
            </button>
            <button @click="deleteNotification(notification.id)" class="btn btn-sm btn-outline-danger">
              Delete
            </button>
          </div>
        </li>
      </ul>
    </div>

    <!-- No Notifications Available -->
    <div v-else class="text-center text-muted">
      No notifications available.
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      notifications: [], // Store all notifications
      filteredNotifications: [], // Store filtered notifications based on type
    };
  },
  mounted() {
    this.fetchNotifications(); // Fetch notifications when the page is loaded
  },
  methods: {
    // Fetch notifications from the backend (for example, using an API call)
    fetchNotifications() {
      axios.get('/api/notifications')
        .then(response => {
          this.notifications = response.data;
          this.filteredNotifications = this.notifications; // By default show all notifications
        })
        .catch(error => {
          console.error('Error fetching notifications:', error);
        });
    },

    // Filter notifications based on the type
    filterNotifications(type) {
      if (type === 'all') {
        this.filteredNotifications = this.notifications;
      } else {
        this.filteredNotifications = this.notifications.filter(notification => notification.type === type);
      }
    },

    // Mark a notification as read
    markAsRead(notificationId) {
      axios.patch(`/api/notifications/${notificationId}/read`)
        .then(() => {
          // Update the notification state locally
          const notification = this.notifications.find(n => n.id === notificationId);
          if (notification) {
            notification.read = true;
          }
        })
        .catch(error => {
          console.error('Error marking notification as read:', error);
        });
    },

    // Mark all notifications as read
    markAllAsRead() {
      axios.patch('/api/notifications/mark-all-read')
        .then(() => {
          this.notifications.forEach(notification => {
            notification.read = true;
          });
        })
        .catch(error => {
          console.error('Error marking all notifications as read:', error);
        });
    },

    // Delete a notification
    deleteNotification(notificationId) {
      axios.delete(`/api/notifications/${notificationId}`)
        .then(() => {
          this.notifications = this.notifications.filter(notification => notification.id !== notificationId);
        })
        .catch(error => {
          console.error('Error deleting notification:', error);
        });
    },
  },
};
</script>

<style scoped>
/* Styling for the notifications page */
.container {
  max-width: 800px;
}

.list-group-item {
  padding: 15px;
  font-size: 1rem;
  border: 1px solid #ddd;
}

.list-group-item button {
  margin-left: 10px;
}

.btn-sm {
  font-size: 0.8rem;
}

.text-muted {
  font-size: 0.85rem;
}

h2 {
  font-size: 2rem;
  font-weight: 600;
}

h5 {
  font-size: 1.2rem;
}

h4 {
  font-size: 1.3rem;
}
</style>
