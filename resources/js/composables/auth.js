// auth.js

import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export function useJwt() {
  const isAuthenticated = ref(false)
  const router = useRouter()

  // Function to perform logout
  async function logout() {
    try {
      // Perform logout API request (e.g., invalidate JWT token)
      await axios.post('/logout')

      // Clear authentication status
      isAuthenticated.value = false

      // Redirect to the login page or any other appropriate page
      router.push('/login')
    } catch (error) {
      console.error('Logout failed:', error)
    }
  }

  // Function to check authentication status
  async function checkAuthentication() {
    try {
      // Perform API request to check if the user is authenticated
      const response = await axios.get('/me')

      // Update isAuthenticated based on the response
      isAuthenticated.value = response.status === 200
    } catch (error) {
      console.error('Authentication check failed:', error)
    }
  }

  // Automatically check authentication status when the composable is used
  checkAuthentication()

  // Return isAuthenticated and logout function
  return { isAuthenticated, logout }
}
