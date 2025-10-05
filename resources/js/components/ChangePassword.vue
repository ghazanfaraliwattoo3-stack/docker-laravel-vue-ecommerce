<template>
    <div class="change-password py-5">
      <h2>Change Password</h2>
  
      <div v-if="message" :class="{'alert': true, 'alert-success': isSuccess, 'alert-danger': !isSuccess}">
        {{ message }}
      </div>
  
      <input v-model="oldPassword" type="password" placeholder="Old Password" />
      <input v-model="newPassword" type="password" placeholder="New Password" />
      <input v-model="confirmPassword" type="password" placeholder="Confirm New Password" />
  
      <button @click="updatePassword">Update Password</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        oldPassword: '',
        newPassword: '',
        confirmPassword: '',
        message: '',
        isSuccess: false,
        customerToken: this.$store.getters["customer/token"],
      };
    },
    methods: {
      async updatePassword() {
        this.message = '';
  
        try {
          const response = await axios.post(
            '/api/edit-password',
            {
              old_password: this.oldPassword,
              new_password: this.newPassword,
              new_password_confirmation: this.confirmPassword,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          );
  
          this.isSuccess = true;
          this.message = response.data.message;
          this.oldPassword = '';
          this.newPassword = '';
          this.confirmPassword = '';
        } catch (error) {
          this.isSuccess = false;
  
          // Laravel se aane wali validation ya custom message
          if (error.response?.data?.errors) {
            const errors = Object.values(error.response.data.errors).flat();
            this.message = errors.join(' ');
          } else {
            this.message = error.response?.data?.message || 'Something went wrong!';
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .change-password {
    max-width: 400px;
    margin: auto;
  }
  input {
    display: block;
    margin: 10px 0;
    padding: 8px;
    width: 100%;
  }
  button {
    padding: 8px 16px;
    background-color: #38b2ac;
    color: white;
    border: none;
    cursor: pointer;
  }
  .alert {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 4px;
  }
  .alert-success {
    background-color: #d4edda;
    color: #155724;
  }
  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
  }
  </style>
  