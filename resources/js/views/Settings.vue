<template>
  <div class="settings-page">
    <h1>Настройки интеграции</h1>

    <div class="card">
      <label class="label">Укажите ссылку на Яндекс, пример https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</label>
      <input
        v-model="url"
        type="text"
        placeholder="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/"
        class="input"
      >

      <button
        class="btn-primary"
        @click="save"
      >
        Сохранить
      </button>
    </div>

    <div
      v-if="integration"
      class="card stats-card"
    >
      <h2>Текущие данные</h2>

      <div class="stats">
        <div class="stat">
          <span class="label">Рейтинг</span>
          <span class="value">{{ integration.rating || '–' }}</span>
        </div>
        <div class="stat">
          <span class="label">Отзывы</span>
          <span class="value">{{ integration.reviews_count }}</span>
        </div>
        <div class="stat">
          <span class="label">Последний синхрон</span>
          <span class="value">{{ integration.last_synced_at }}</span>
        </div>
      </div>

      <button
        class="btn-secondary"
        @click="syncNow"
      >
        Обновить отзывы
      </button>
    </div>
  </div>
</template>

<script>
import notifications from './../notifications'
import http from './../services/http'

export default {
  name: 'Settings',
  data () {
    return {
      url: '',
      integration: null,
      syncing: false
    }
  },
  mounted () {
    this.load()
  },
  methods: {
    load () {
      http.getIntegration()
        .then(res => {
          this.integration = res.data
          if (res.data) {
            this.url = res.data.url
          }
        })
    },
    save () {
      http.postIntegration(this.url)
        .then(res => {
          notifications.success(res.data.message)
          this.load()
        }).catch(err => {
          notifications.error(err.response.data.message)
        })
    },
    async syncNow () {
      if (!this.integration || this.syncing) return

      this.syncing = true

      try {
        const res = await http.syncIntegration()
        notifications.success(res.data.message || 'Синхронизация запущена')
        this.load()
      } catch (err) {
        notifications.error(err.response?.data?.message || 'Ошибка синхронизации')
      } finally {
        this.syncing = false
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import "./../../css/variables";

.settings-page {
  padding: $space-lg;
  font-family: $primary-font;
  color: $color-text;

  h1 {
    font-size: $font-lg;
    margin-bottom: $space-md;
  }

  .card {
    background: $color-card;
    padding: $space-lg;
    border-radius: $radius;
    border: 1px solid $color-border;
    margin-top: $space-md;

    .label {
      display: block;
      font-weight: 600;
      margin-bottom: $space-sm;
    }

    .input {
      width: 100%;
      padding: $space-sm;
      border: 1px solid $color-border;
      border-radius: $radius;
      font-size: $font-sm;
      margin-bottom: $space-md;

      &:focus {
        border-color: $color-primary;
      }
    }

    .btn-primary {
      padding: $space-sm $space-md;
      background: $color-primary;
      color: white;
      border: none;
      border-radius: $radius;
      cursor: pointer;
    }

    .btn-secondary {
      margin-top: $space-md;
      background: $color-text-muted;
      color: white;
      padding: $space-sm $space-md;
      border: none;
      border-radius: $radius;
      cursor: pointer;
    }

    &.stats-card {
      .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: $space-md;
        margin-top: $space-md;

        .stat {
          text-align: center;

          .value {
            font-size: $font-lg;
            font-weight: bold;
          }
        }
      }
    }
  }
}
</style>
