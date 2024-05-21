<template>
    <v-container>
      <v-form @submit.prevent="submit">
        <v-text-field
          v-model="form.email"
          label="Email"
          type="email"
          required
        ></v-text-field>
  
        <v-text-field
          v-model="form.password"
          label="Password"
          type="password"
          required
        ></v-text-field>
  
        <v-btn type="submit" color="primary">Login</v-btn>
      </v-form>
    </v-container>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3'
  
  // Initialize the form with default values
  const form = useForm({
    email: '',
    password: '',
  })
  
  // Function to handle form submission
  const submit = () => {
  form.post('/login', {
    onSuccess: (response) => {
      console.log('Response:', response)
      // Extract the token from the response object
      const token = response.props.token
      // Store the token in local storage
      localStorage.setItem('token', token)
      // Reset the form
      form.reset()
      Inertia.visit('/')
    },
    // Handle error case if needed
    onError: (error) => {
      console.error('Error:', error)
      // Reset the form
      form.reset()
    }
  })
}

  </script>
  
  