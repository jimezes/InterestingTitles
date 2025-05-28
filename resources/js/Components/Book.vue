<template>
  <div class="book-card">
    <div class="book-header">
      <h4 class="book-title">{{ book.title }}</h4>
      <span class="star-icon" @click="toggleFavorite">
        <span v-if="favorited">★</span>
        <span v-else>☆</span>
      </span>
    </div>
    <p class="book-author">by {{ book.authors }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    book: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      favorited: false,
    };
  },
  methods: {
    async toggleFavorite() {
      this.favorited = !this.favorited;

      if (this.favorited) {
        try {
          await axios.post(route('favorites.add'), {
            title: this.book.title,
            authors: Array.isArray(this.book.authors)
              ? this.book.authors
              : this.book.authors.split(',').map(a => a.trim()),
            categories: this.book.categories || [],
          }, {
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
            }
          });
          console.log(`Book "${this.book.title}" favorited successfully.`);
        } catch (error) {
          this.favorited = false;
        }
      }

      this.$emit('favorite-toggled', {
        book: this.book,
        favorited: this.favorited,
      });
    },
  },
};
</script>

<style scoped>
.book-card {
  background-color: #f9f9f9;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 1rem;
}

.book-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.book-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin: 0;
}

.star-icon {
  font-size: 1.4rem;
  color: #aaa;
  cursor: pointer;
  transition: color 0.2s ease;
}

.star-icon:hover {
  color: #f0a500;
}

.star-icon span {
  user-select: none;
}

.book-author {
  font-size: 0.9rem;
  color: #666;
}
</style>
