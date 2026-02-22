<template>
  <aside class="main-sidebar">
    <div class="logo-wrapper">
      <router-link
        :to="{ name: 'Reviews' }"
        class="logo"
      >
        <img
          src="../../../../img/logo.svg"
          alt="logo"
        >
      </router-link>
    </div>
    <section class="account-name">
      <span>
        {{ accountName }}
      </span>
    </section>
    <section class="sidebar">
      <ul class="sidebar-menu">
        <sidebar-menu-item
          v-for="(item,index) in menuItems"
          :key="index"
          :background-color="item.backgroundColor"
          :color="item.color"
          :hidden="item.hidden"
          :router="item.router"
          :text="item.text"
        />
      </ul>
    </section>
  </aside>
</template>

<script>
import SidebarMenuItem from '../SidebarMenuItem'

export default {
  name: 'TheSidebar',
  components: {
    SidebarMenuItem
  },
  props: {
    accountName: {
      type: String,
      default: 'Вход не выполнен'
    }
  },
  computed: {
    /**
     * Элементы бокового меню
     * @returns []
     */
    menuItems () {
      return [
        {
          text: 'Отзывы',
          router: {
            name: 'Reviews'
          }
        }, {
          text: 'Настройки',
          router: {
            name: 'Settings'
          }
        }
      ]
    }
  }
}
</script>

<style scoped>
  .main-sidebar {
    padding: 15px;
    height: 100%;
    background-color: #F6F8FA;
    .logo-wrapper {
      padding: 15px;
    }
  }
  .account-name {
    padding: 15px 15px;
    margin-bottom: 40px;
    border-bottom: 1px #DCE4EA solid;
    & > span {
      font-size: 16px;
      color: #6C757D;
    }
  }
</style>
