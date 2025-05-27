<template>
  <div @click="goToSearch()" class="category-card">
    <h3 class="category-name">{{ category.name }}</h3>
  </div>
</template>

<script>

export default {
  props: {
    category: {
      type: Object,
      required: true,
    },
  },
  methods:{
    goToSearch() {
      const url = route('search.books', { category: this.category.name });
      window.location.href = url;
    },
  }
};
</script>

<style scoped>
.category-card {
  background: #f5f7fa;
  border-radius: 8px;
  padding: 16px 24px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: transform 0.15s ease, box-shadow 0.15s ease;
  cursor: pointer;
}

.category-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.category-name {
  font-weight: 600;
  font-size: 1.25rem;
  margin-bottom: 8px;
  color: #333;
}

.category-works {
  font-size: 0.9rem;
  color: #666;
}
</style>
