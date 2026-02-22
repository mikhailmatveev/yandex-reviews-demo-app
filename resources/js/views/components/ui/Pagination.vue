<template>
  <div
    v-if="lastPage > 1"
    class="pagination"
  >
    <button
      :disabled="currentPage === 1"
      class="pagination-btn"
      @click="changePage(currentPage - 1)"
    >
      Prev
    </button>

    <button
      v-if="showFirst"
      :class="buttonClass(1)"
      @click="changePage(1)"
    >
      1
    </button>

    <span
      v-if="showLeftDots"
      class="dots"
    >
      …
    </span>

    <button
      v-for="page in visiblePages"
      :key="page"
      :class="buttonClass(page)"
      @click="changePage(page)"
    >
      {{ page }}
    </button>

    <span
      v-if="showRightDots"
      class="dots"
    >
      …
    </span>

    <button
      v-if="showLast"
      :class="buttonClass(lastPage)"
      @click="changePage(lastPage)"
    >
      {{ lastPage }}
    </button>

    <button
      :disabled="currentPage === lastPage"
      class="pagination-btn"
      @click="changePage(currentPage + 1)"
    >
      Next
    </button>
  </div>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    },
    delta: {
      type: Number,
      default: 2 // сколько страниц показывать вокруг текущей
    }
  },
  computed: {
    visiblePages () {
      const pages = []
      const start = Math.max(2, this.currentPage - this.delta)
      const end = Math.min(this.lastPage - 1, this.currentPage + this.delta)
      for (let i = start; i <= end; i++) {
        pages.push(i)
      }
      return pages
    },
    showFirst () {
      return this.currentPage - this.delta > 2
    },
    showLast () {
      return this.currentPage + this.delta < this.lastPage - 1
    },
    showLeftDots () {
      return this.currentPage - this.delta > 3
    },
    showRightDots () {
      return this.currentPage + this.delta < this.lastPage - 2
    }
  },
  methods: {
    changePage (page) {
      if (page === this.currentPage) return
      this.$emit('change', page)
    },
    buttonClass (page) {
      return [
        'pagination-page',
        { 'pagination-page--active': page === this.currentPage }
      ]
    }
  }
}
</script>

<style lang="scss" scoped>
@import "./../../../../css/variables";

.pagination {
  display: flex;
  gap: $space-sm;
  justify-content: center;
  margin: $space-lg 0;
  font-size: $font-sm;

  .pagination-btn,
  .pagination-page {
    padding: $space-sm $space-md;
    border: 1px solid $color-border;
    background: $color-card;
    color: $color-text;
    border-radius: $radius;
    cursor: pointer;
    min-width: 40px;
    text-align: center;
    transition: background 0.2s;

    &:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    &:hover:not(.pagination-page--active) {
      background: #e0e7ff;
    }

    &.pagination-page--active {
      background: $color-primary;
      color: white;
      border-color: $color-accent;
    }
  }

  .dots {
    padding: $space-sm $space-md;
    color: $color-text-muted;
  }
}
</style>
