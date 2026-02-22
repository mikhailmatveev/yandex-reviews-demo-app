<template>
  <div class="reviews-page">
    <h1>Отзывы</h1>

    <div
      v-if="!reviews.length"
      class="empty-text"
    >
      Нет отзывов для отображения
    </div>

    <div
      v-for="review in reviews"
      :key="review.id"
      class="card review-card"
    >
      <div class="review-header">
        <span class="review-author">{{ review.author_name }}</span>
        <span class="review-rating">{{ review.rating }} ★</span>
      </div>
      <p class="review-text">
        {{ review.text }}
      </p>
      <span class="review-date">{{ review.published_at }}</span>
    </div>

    <Pagination
      v-if="pagination"
      :current-page="pagination.current_page"
      :last-page="pagination.last_page"
      @change="fetchReviews"
    />
  </div>
</template>

<script>
import http from './../services/http'
import Pagination from './components/ui/Pagination.vue'

export default {
  name: 'Reviews',
  components: {
    Pagination
  },
  data () {
    return {
      reviews: [],
      pagination: null
    }
  },
  methods: {
    async fetchReviews (page = 1) {
      const res = await http.getReviews(page)
      this.reviews = res.data.data
      this.pagination = res.data.meta
    }
  }

}
</script>

<style lang="scss" scoped>
@import "./../../css/variables";

.reviews-page {
  padding: $space-lg;
  font-family: $primary-font;

  h1 {
    font-size: $font-lg;
    margin-bottom: $space-md;
  }

  .empty-text {
    text-align: center;
    color: $color-text-muted;
    margin-top: $space-lg;
  }

  .review-card {
    margin-bottom: $space-md;
    border: 1px solid $color-border;
    border-radius: $radius;
    padding: $space-md;
    background: $color-card;

    .review-header {
      display: flex;
      justify-content: space-between;
      font-weight: 600;
      margin-bottom: $space-sm;

      .review-author {
        color: $color-text;
      }

      .review-rating {
        color: $color-primary;
      }
    }

    .review-text {
      font-size: $font-sm;
      color: $color-text;
      margin-bottom: $space-sm;
    }

    .review-date {
      font-size: 12px;
      color: $color-text-muted;
    }
  }
}
</style>
