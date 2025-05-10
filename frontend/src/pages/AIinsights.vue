<template>
    <div class="container py-5">
      <h2 class="text-center mb-4">Smart Money & AI Insights</h2>
  
      <!-- Chat Section -->
      <div class="chat-card card mb-4">
        <div class="card-body p-4">
          <!-- Chat Box -->
          <div class="chat-box">
            <div v-for="(message, index) in messages" :key="index" class="message">
              <div :class="message.sender === 'user' ? 'user-message' : 'ai-message'">
                <div class="message-content">
                  <p>{{ message.text }}</p>
                  <span v-if="message.sender === 'ai'" class="message-time">{{ message.time }}</span>
                </div>
              </div>
            </div>
          </div>
  
          <!-- User Input Section -->
          <div class="d-flex mt-4">
            <input 
              v-model="userQuery"
              @keyup.enter="sendMessage"
              type="text" 
              class="form-control input"
              placeholder="Ask me something about your expenses..."
              :disabled="isLoading"
            />
            <button @click="sendMessage" class="btn btn-submit ml-2" :disabled="isLoading">
              <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span v-else>Send</span>
            </button>
          </div>
        </div>
      </div>
  
      <!-- Suggestions or Additional Information -->
      <div v-if="aiResponse" class="card">
        <div class="card-body">
          <h5 class="card-title">AI Suggestions</h5>
          <p>{{ aiResponse }}</p>
        </div>
      </div>
  
      <!-- Additional Features/Buttons -->
      <div v-if="aiResponse" class="text-center mt-4">
        <button @click="clearChat" class="btn btn-clear">Clear Chat</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        userQuery: '',           // Store the user's input
        messages: [],            // Store the chat messages
        isLoading: false,        // Loading state while waiting for AI response
        aiResponse: '',          // Store AI's response
      };
    },
    methods: {
      // Send a message and get AI insights
      sendMessage() {
        if (this.userQuery.trim() === '') return; // Prevent empty messages
  
        // Add user's message to the chat
        const message = {
          text: this.userQuery,
          sender: 'user',
          time: this.getCurrentTime(),
        };
        this.messages.push(message);
        this.userQuery = ''; // Clear the input field
  
        this.isLoading = true; // Show loading state
  
        // Send the message to the backend
        axios.post('/api/ai-insights', { query: message.text })
          .then(response => {
            // Add AI response to the chat
            this.aiResponse = response.data.response;
            this.messages.push({
              text: this.aiResponse,
              sender: 'ai',
              time: this.getCurrentTime(),
            });
          })
          .catch(error => {
            console.error('Error fetching AI insights:', error);
            this.messages.push({
              text: 'Sorry, I could not process your request. Please try again.',
              sender: 'ai',
              time: this.getCurrentTime(),
            });
          })
          .finally(() => {
            this.isLoading = false; // Hide loading state
          });
      },
  
      // Helper function to get current time (for timestamps)
      getCurrentTime() {
        const date = new Date();
        const hours = date.getHours();
        const minutes = date.getMinutes();
        return `${hours}:${minutes < 10 ? '0' + minutes : minutes}`;
      },
  
      // Clear the chat history
      clearChat() {
        this.messages = [];
        this.aiResponse = '';
      },
    },
  };
  </script>
  
  <style scoped>
  /* Modern container background */
  .container {
    background: linear-gradient(135deg, #f8fafc 0%, #e3e9f3 100%);
    border-radius: 18px;
    box-shadow: 0 6px 32px rgba(0,0,0,0.08);
    padding: 40px 20px;
    max-width: 700px;
    margin: 40px auto;
  }
  
  h2 {
    font-weight: 700;
    color: #2a2e3b;
    letter-spacing: 1px;
  }
  
  /* Chatbox card */
  .chat-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    border: none;
    margin-bottom: 32px;
  }
  
  .card-body {
    padding: 28px 24px;
  }
  
  /* Chatbox scrolling */
  .chat-box {
    margin-bottom: 24px;
    padding: 16px;
    background: #f4f7fb;
    border-radius: 12px;
    max-height: 350px;
    overflow-y: auto;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  }
  
  /* Message bubbles */
  .message {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
  }
  
  .user-message {
    align-self: flex-end;
    background: linear-gradient(135deg, #4f8cff 0%, #3358e4 100%);
    color: #fff;
    border-radius: 18px 18px 4px 18px;
    padding: 14px 20px;
    margin-left: 60px;
    box-shadow: 0 2px 8px rgba(79,140,255,0.10);
    position: relative;
  }
  
  .ai-message {
    align-self: flex-start;
    background: linear-gradient(135deg, #e3f0ff 0%, #cbe6ff 100%);
    color: #2a2e3b;
    border-radius: 18px 18px 18px 4px;
    padding: 14px 20px;
    margin-right: 60px;
    box-shadow: 0 2px 8px rgba(79,140,255,0.06);
    position: relative;
  }
  
  /* Optional: Add avatars */
  .user-message::before {
    content: '';
    display: inline-block;
    width: 32px;
    height: 32px;
    background: url('https://api.dicebear.com/7.x/personas/svg?seed=user') no-repeat center/cover;
    border-radius: 50%;
    position: absolute;
    right: -40px;
    top: 8px;
  }
  
  .ai-message::before {
    content: '';
    display: inline-block;
    width: 32px;
    height: 32px;
    background: url('https://api.dicebear.com/7.x/bottts/svg?seed=ai') no-repeat center/cover;
    border-radius: 50%;
    position: absolute;
    left: -40px;
    top: 8px;
  }
  
  .message-content {
    max-width: 420px;
    word-break: break-word;
  }
  
  .message-time {
    font-size: 0.85rem;
    color: #8ca0b3;
    margin-top: 6px;
    display: block;
    text-align: right;
  }
  
  /* Input field and button */
  .input {
    width: 100%;
    padding: 14px 18px;
    border-radius: 25px;
    border: 1.5px solid #d1d9e6;
    font-size: 1.05rem;
    background: #f8fafc;
    transition: border 0.2s;
  }
  .input:focus {
    border: 1.5px solid #4f8cff;
    outline: none;
  }
  
  .d-flex {
    display: flex;
    gap: 12px;
  }
  
  button {
    min-width: 110px;
    border-radius: 25px;
    padding: 12px 0;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
    box-shadow: 0 2px 8px rgba(79,140,255,0.08);
  }
  
  button:disabled {
    background: #e3e9f3;
    color: #b0b8c9;
    cursor: not-allowed;
  }
  
  button.btn-submit {
    background: linear-gradient(135deg, #4f8cff 0%, #3358e4 100%);
    color: #fff;
    border: none;
  }
  button.btn-submit:hover:not(:disabled) {
    background: linear-gradient(135deg, #3358e4 0%, #4f8cff 100%);
    box-shadow: 0 4px 16px rgba(79,140,255,0.18);
  }
  
  button.btn-clear {
    background: linear-gradient(135deg, #f0ad4e 0%, #f7c873 100%);
    color: #fff;
    border: none;
    border-radius: 25px;
    padding: 10px 28px;
    font-size: 1rem;
    font-weight: 600;
    margin-top: 8px;
  }
  button.btn-clear:hover {
    background: linear-gradient(135deg, #ec971f 0%, #f0ad4e 100%);
  }
  
  /* AI Suggestions Card */
  .card {
    background: linear-gradient(135deg, #e3f0ff 0%, #f8fafc 100%);
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(79,140,255,0.08);
    border: none;
    margin-top: 18px;
  }
  .card-title {
    color: #3358e4;
    font-weight: 700;
    margin-bottom: 10px;
  }
  
  /* Loading spinner */
  .spinner-border {
    width: 1.2rem;
    height: 1.2rem;
    border-width: 3px;
    margin-right: 8px;
  }
  
  /* Responsive design */
  @media (max-width: 767px) {
    .container {
      padding: 16px 2px;
      margin: 0;
      max-width: 100vw;
    }
    .chat-card, .card {
      padding: 0;
      border-radius: 10px;
    }
    .chat-box {
      max-height: 220px;
      padding: 8px;
    }
    .user-message, .ai-message {
      margin-left: 0;
      margin-right: 0;
      padding: 10px 12px;
      font-size: 0.98rem;
    }
    .user-message::before, .ai-message::before {
      width: 24px;
      height: 24px;
      top: 4px;
      left: -28px;
      right: -28px;
    }
    .message-content {
      max-width: 90vw;
    }
    .d-flex {
      flex-direction: column;
      gap: 8px;
    }
    button {
      min-width: 100%;
      padding: 12px 0;
      font-size: 1rem;
    }
  }
  </style>
  