<template>
  <div id="app" :class="{ 'admin-content': authenticated }">
    <notifications position="top right"/>
    <TheNavigation />
    <div class="container mt-5">
      <router-view/>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import TheNavigation from '@/components/TheNavigation'
  
  export default {
    components: {
      TheNavigation
    },
    computed: {
      ...mapGetters({
        authenticated: 'auth/authenticated'
      })
    }
  }
</script>