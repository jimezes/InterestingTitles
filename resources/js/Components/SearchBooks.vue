<template>
    <div class="search-container">
      <h2>Search books in category: {{ category }}</h2>
      <input
        type="text"
        v-model="searchTerm"
        @input="onInput"
        placeholder="Type a book title..."
        class="search-input"
      />
      
      <div v-if="loading" class="spinner-wrapper">
        <div class="spinner"></div>
      </div>
      <div class="results">
        <Book
          v-for="book in books"
          :key="book.id"
          :book="book"
        />
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Book from '@/Components/Book.vue';
  
  export default {
    components: { Book },
    props: {
      category: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        searchTerm: '',
        books: [],
        timeoutId: null,
        loading:false
      };
    },
    methods: {
      onInput() {
        clearTimeout(this.timeoutId);
        //if idle for more than 2 seconds, then search
        this.timeoutId = setTimeout(() => {
          if (this.searchTerm.trim() !== '') {
            this.searchBooks();
          }
        }, 2000);
      },
  
      async searchBooks() {
            this.loading = true;
            try {
                const response = await axios.post(
                route('search', { category: this.category, title: this.searchTerm }),
                {}, // Request body (empty here)
                {
                    headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json', // Explicitly request JSON response
                    },
                }
                );
                console.log(response.data);
                this.books = response.data.titles;
            } catch (error) {
                console.error('Search failed:', error);
                if (error.response && error.response.data) {
                console.error('Server responded with:', error.response.data);
                }
            }
            finally {
              this.loading = false;
            }
      }

    },
  };
  </script>
  
  <style scoped>
  .search-container {
    max-width: 700px;
    margin: 2rem auto;
    padding: 0 1rem;
  }
  .search-input {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    margin-bottom: 1.5rem;
    border: 1px solid #ccc;
    border-radius: 6px;
  }
  .results {
    display: flex;
    flex-direction: column;
  }


.spinner-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 2rem;
}

.spinner {
  width: 36px;
  height: 36px;
  border: 3px solid #dcdcdc;
  border-top: 3px solid #888;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

</style>
  