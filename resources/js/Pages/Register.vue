<template>
   
      <v-container>
        <v-form @submit.prevent="register">
          <v-text-field
            label="Name"
            v-model="form.name"
            :error-messages="errors.name"
            required
          ></v-text-field>
          <v-text-field
            label="Email"
            v-model="form.email"
            :error-messages="errors.email"
            required
          ></v-text-field>
          <v-text-field
            label="Password"
            v-model="form.password"
            type="password"
            :error-messages="errors.password"
            required
          ></v-text-field>
         
          <v-text-field
            label="Role"
            v-model="form.role"
            :error-messages="errors.role"
            required
          ></v-text-field>
          <v-btn type="submit" color="primary">Register</v-btn>
        </v-form>
      </v-container>
    
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { usePage } from '@inertiajs/vue3'
  import { Inertia } from '@inertiajs/inertia'
  
  const form = ref({
    name: '',
    email: '',
    password: '',
   
    role: ''
  })
  
  const { errors } = usePage().props
  
  const register = () => {
    Inertia.post('/api/auth/register', form.value)
  }
  </script>
  