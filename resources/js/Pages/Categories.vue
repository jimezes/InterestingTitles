<template>
  <section class="category-list">
    <h2 class="list-title">Categories</h2>

    <div v-if="selectedCategory || !showCategories" class="selected-category">
      <p v-if="selectedCategory">You selected: <strong>{{ selectedCategory.name }}</strong></p>
      <button style="margin-top:10px;" class="back-button" @click="clearSelection">All categories</button>
    </div>

    <!-- If no category is selected, show grid -->
    <div v-if="showCategories" class="categories-grid">
      <Category
        v-for="category in categories"
        :key="category.id || category.key"
        :category="category"
        @category-selected="selectCategory"
      />
    </div>

    <div v-if="selectedCategory">
      <SearchBooks :category="selectedCategory.name"/>
    </div>

    <div style="width:100%;font-size:22px;color:coral;text-align: end;" class="star-icon" @click="toggleFavorites">
        ☆ <span style="color:#4a4844"> Favorites </span>
    </div>

    <div v-if="favoritesClicked">
       <Favorites/>
    </div>
  </section>
</template>

<script>
import Category from '@/Components/Category.vue'
import SearchBooks from '@/Components/SearchBooks.vue';
import Favorites from '@/Components/Favorites.vue';

export default {
  components: { Category,SearchBooks,Favorites},
  props: {
    categories: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selectedCategory: null,
      showCategories:true,
      favoritesClicked:false
    };
  },
  methods: {
    selectCategory(category) {
      //alert(category);
      category = JSON.parse(category);
      this.selectedCategory = category;
      this.showCategories = false
    },
    clearSelection() {
      this.selectedCategory = null;
      this.favoritesClicked = false;
      this.showCategories = true;
    },
    toggleFavorites(){
      this.favoritesClicked = true;
      this.showCategories = false;
    }
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
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1.5rem;
}

.selected-category {
  text-align: center;
  font-size: 1.2rem;
}


.back-button {
  background: none;
  border: 1px solid #ccc;
  color: #333;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.back-button:hover {
  border-color: #999;
  background-color: #f7f7f7;
}

.back-button:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.star-icon:hover{
  cursor:pointer;
}
</style>
