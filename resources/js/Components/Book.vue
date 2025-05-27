<template>
    <div class="book-card">
      <h4 class="book-title">{{ book.title }}</h4>
      <p class="book-author">by {{ book.authors }}</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      book: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  
  <style scoped>
  .book-card {
    background-color: #f9f9f9;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
  }
  .book-title {
    font-size: 1.1rem;
    font-weight: 600;
  }
  .book-author {
    font-size: 0.9rem;
    color: #666;
  }
  </style>
  