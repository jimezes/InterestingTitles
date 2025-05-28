<template>
  <section class="favorites-list">
    <h2>My Favorite Books</h2>
    <ul>
      <li v-for="book in favoriteBooks" :key="book.id" class="book-item">
        <h3>{{ book.title }}</h3>
        <p>Authors: {{ book.authors.map(a => a.name).join(', ') }}</p>
      </li>
    </ul>
    <p v-if="loading">Loading favorites...</p>
    <p v-if="error" class="error">{{ error }}</p>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      favoriteBooks: [],
      loading: false,
      error: null,
    };
  },
  props: {},
  methods: {
    async fetchFavorites() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get(route('favorites'));
        this.favoriteBooks = response.data;
      } catch (err) {
        this.error = 'Failed to load favorites.';
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.fetchFavorites();
  },
};
</script>

<style scoped>
.favorites-list {
  max-width: 600px;
  margin: 2rem auto;
  padding: 1rem;
  background: #fafafa;
  border-radius: 8px;
}
.book-item {
  margin-bottom: 1.5rem;
  border-bottom: 1px solid #ddd;
  padding-bottom: 0.5rem;
}
.error {
  color: red;
  font-weight: bold;
}
</style>
