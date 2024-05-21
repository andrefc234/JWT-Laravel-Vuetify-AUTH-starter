<template>
  <v-card>
    <v-layout>
      <v-app-bar color="secondary" prominent>
        <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>My files</v-toolbar-title>
        <v-spacer></v-spacer>
        <template v-if="$vuetify.display.mdAndUp">
          <v-btn icon="mdi-magnify" variant="text"></v-btn>
          <v-btn icon="mdi-filter" variant="text"></v-btn>
        </template>
        <v-btn icon="mdi-dots-vertical" variant="text"></v-btn>
        <!-- Show logout button if user is authenticated -->
        <v-btn v-if="isAuthenticated" @click="logout" icon="mdi-logout" variant="text">Logout</v-btn>
      </v-app-bar>

      <v-navigation-drawer
        v-model="drawer"
        :location="$vuetify.display.mobile ? 'bottom' : undefined"
        temporary
      >
        <v-list :items="items"></v-list>
      </v-navigation-drawer>

      <v-main>
        <v-card-text>
          <slot />
        </v-card-text>
      </v-main>
    </v-layout>
  </v-card>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import router from '../router'
const items = [
  { title: 'Foo', value: 'foo' },
  { title: 'Bar', value: 'bar' },
  { title: 'Fizz', value: 'fizz' },
  { title: 'Buzz', value: 'buzz' },
]

const drawer = ref(false)
const group = ref(null)

watch(group, () => {
  drawer.value = false
})

// Function to check if user is authenticated
const isAuthenticated = ref(false)
// Get the $page object from Inertia
const { props } = usePage()
console.log('props',props)
// Check if token exists in local storage
const token = localStorage.getItem('token')
console.log(token)
if (token) {
  // Make request to /me endpoint to verify token
  axios.get('/me', {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
  .then(() => {
    isAuthenticated.value = true
  })
  .catch(() => {
    // Handle error if token is invalid or expired
    isAuthenticated.value = false
    localStorage.removeItem('token') // Remove invalid token from local storage
  })
}

// Function to perform logout
const logout = () => {
  localStorage.removeItem('token'); // Remove token from local storage
  Inertia.visit('/logout', {
    method: 'post', // Use POST method for logout request
    preserveScroll: true, // Preserve scroll position after logout
    preserveState: false, // Do not preserve state after logout
    onSuccess: () => {
      // Redirect to login page after successful logout
      Inertia.visit('/login');
    },
    onError: (error) => {
      console.error('Logout error:', error);
    }
  });
  isAuthenticated.value = false; // Update authentication status
};


</script>
