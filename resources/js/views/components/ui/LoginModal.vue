<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <h3>Вход в систему</h3>
      <form @submit.prevent="login">
        <div class="input-group">
          <label>Email</label>
          <input
            v-model="email"
            type="email"
            placeholder="Введите ваш Email"
            required
          >
        </div>
        <div class="input-group">
          <label>Пароль</label>
          <input
            v-model="password"
            type="password"
            placeholder="Введите Пароль"
            required
          >
        </div>
        <p
          v-if="error"
          style="color: #f00"
        >
          {{ error }}
        </p>
        <div class="actions">
          <button
            type="submit"
            class="btn-primary"
          >
            Войти
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import http from '../../../services/http'

export default {
  name: 'LoginModal',
  data () {
    return {
      email: '',
      password: '',
      error: null
    }
  },
  methods: {
    async login () {
      try {
        await http.getCookie()
        await http.login(
          this.email,
          this.password
        )
        this.$emit('logged-in')
      } catch (e) {
        if (e.response.data) {
          this.error = e.response.data.message
        } else {
          this.error = 'Ошибка входа'
        }
      }
    }
  }
}
</script>

<style lang="scss" scoped>
// Переменные для легкой настройки темы
$modal-bg: #ffffff;
$overlay-color: rgba(0, 0, 0, 0.5);
$primary-color: #3498db;
$primary-hover: darken($primary-color, 10%);
$secondary-color: #f1f2f6;
$text-color: #2c3e50;
$border-radius: 8px;
$transition: all 0.3s ease;

.modal-overlay {
  position: fixed;
  inset: 0; // Заменяет top, left, right, bottom: 0
  background: $overlay-color;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  backdrop-filter: blur(2px); // Легкое размытие фона

  .modal-content {
    background: $modal-bg;
    padding: 2.5rem;
    border-radius: $border-radius;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);

    h3 {
      margin: 0 0 1.5rem;
      color: $text-color;
      font-size: 1.5rem;
      text-align: center;
    }
  }

  .input-group {
    margin-bottom: 1.2rem;

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      font-size: 0.85rem;
      color: lighten($text-color, 20%);
    }

    input {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ddd;
      border-radius: calc($border-radius / 2);
      box-sizing: border-box;
      transition: $transition;

      &:focus {
        outline: none;
        border-color: $primary-color;
        box-shadow: 0 0 0 3px rgba($primary-color, 0.1);
      }
    }
  }

  .actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 2rem;

    button {
      padding: 0.8rem 1.8rem;
      border-radius: calc($border-radius / 2);
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: $transition;

      &.btn-primary {
        background: $primary-color;
        color: white;

        &:hover {
          background: $primary-hover;
          transform: translateY(-1px);
        }
      }

      &.btn-secondary {
        background: $secondary-color;
        color: $text-color;

        &:hover {
          background: darken($secondary-color, 5%);
        }
      }

      &:active {
        transform: translateY(0);
      }
    }
  }
}
</style>
