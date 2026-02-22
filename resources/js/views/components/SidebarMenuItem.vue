<template>
  <router-link
    v-if="router && router.name"
    v-show="!hidden"
    tag="li"
    :to="router"
    :class="itemClasses"
  >
    <a
      :style="{ color, backgroundColor }"
      @click="handleRouterNavigation()"
    >
      <span
        class="text"
        v-html="text"
      />
    </a>
  </router-link>
</template>

<script>
export default {
  name: 'SidebarMenuItem',
  props: {
    /**
     * Цвет фона пункта меню (если не указан router)
     */
    backgroundColor: {
      type: String,
      default: ''
    },
    /**
     * Цвет текста элемента
     */
    color: {
      type: String,
      default: ''
    },
    /**
     * Скрыт или нет элемент
     */
    hidden: {
      type: Boolean,
      default: false
    },
    /**
     * Описание роута пункта меню
     */
    router: {
      type: Object,
      default () {
        return {
          name: ''
        }
      }
    },
    /**
     * Текст элемента (можно HTML)
     */
    text: {
      type: String,
      default: ''
    }
  },
  computed: {
    // /**
    //  * Классы элемента меню
    //  * @returns {string}
    //  */
    // itemClasses () {
    //   const classes = []
    //   if (this.router && this.router.name === this.$route.name) {
    //     classes.push('active')
    //   } else if (this.link === this.$route.path) {
    //     classes.push('active')
    //   }
    //   return classes.join(' ')
    // }
  },
  methods: {
    handleRouterNavigation () {
      this.$root.$emit('sidebarRouteNavigation')
    }
  }
}
</script>

<style scoped>
  li {
    padding: 0 15px;
    margin-bottom: 10px;
    &.router-link-exact-active {
      border-radius: 12px;
      background-color: #fff;
      box-shadow: 0 2px 1px 0 #00000005;
    }
    & > a {
      color: #363740;
      text-decoration: none;
      cursor: pointer;
      & > span {
        display: inline-block;
        padding: 10px 0;
      }
    }
  }
</style>
