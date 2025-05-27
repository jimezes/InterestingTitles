<template>
    <section class="category-list">
      <h2 class="list-title">Categories</h2>
      <div class="categories-grid">
        <Category
          v-for="category in categories"
          :key="category.id || category.key"
          :category="category"
        />
      </div>
    </section>
  </template>
  
  <script>
  import Category from '@/Components/Category.vue'
  
  export default {
    components: { Category },
    props: {
      categories: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
   
      };
    },
  };
  </script>
  
  <style scoped>
  .category-list {
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
  }
  
  .list-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #222;
    text-align: center;
  }
  
  .categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(200px,1fr));
    gap: 1.5rem;
  }
  </style>
  