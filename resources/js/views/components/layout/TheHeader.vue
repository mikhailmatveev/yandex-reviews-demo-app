<template>
  <header class="main-header">
    <span class="logout-container">
      <a
        href="#"
        @click.prevent="logout"
      ><img
        src="../../../../img/header/logout.svg"
        alt="logout"
      ></a>
    </span>
  </header>
</template>

<script>
import http from '../../../services/http'

export default {
  name: 'TheHeader',
  methods: {
    /**
     * Разлогинивает пользователя
     */
    async logout () {
      try {
        await http.logout()
        window.location.href = '/'
      } catch (e) {
        console.error(e)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .main-header {
    width: 100%;
    height: 75px;
    border-bottom: 1px #DCE4EA solid;
  }
  .logout-container {
    position: relative;
    top: 15px;
    left: -15px;
    float: right;
  }
</style>
