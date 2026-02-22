<template>
  <div class="app-wrapper">
    <the-sidebar
      :account-name="user && user.name"
    />
    <div class="right-side">
      <the-header />
      <main>
        <login-modal
          v-if="!user"
          @logged-in="fetchUser"
        />
        <router-view v-else />
      </main>
    </div>
  </div>
</template>

<script>
import http from './services/http'
import LoginModal from './views/components/ui/LoginModal.vue'
import TheHeader from './views/components/layout/TheHeader.vue'
import TheSidebar from './views/components/layout/TheSidebar.vue'

export default {
  name: 'App',
  components: {
    LoginModal,
    TheHeader,
    TheSidebar
  },
  data () {
    return {
      user: null
    }
  },
  mounted () {
    this.fetchUser()
  },
  methods: {
    async fetchUser () {
      try {
        const res = await http.getUser()
        this.user = res.data
      } catch {
        this.user = null
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  main {
    flex-grow: 1;
    overflow-y: auto; /* Прокрутка только для контента */
  }
  .app-wrapper {
    display: flex;
    height: 100%;
  }
  .main-sidebar {
    width: 280px;
    flex-shrink: 0;
    overflow-y: auto; /* Прокрутка, если меню длинное */
  }
  /* Правая часть: Header + Main */
  .right-side {
    display: flex;
    flex-direction: column;
    flex-grow: 1; /* Занимает всю оставшуюся ширину */
    overflow: hidden;
  }
</style>
