<template>
  <div class="container my-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="infinite-list">
      <template v-if="products.length">
        <div class="col" v-for="product in products">
          <div class="card h-100 text-decoration-none text-body" to="/product/detail">
            <NuxtLink to="/product/detail">
              <img :src="product.url" class="card-img-top" alt="...">
            </NuxtLink>
            <div class="card-body h6 m-0">
              <p class="card-text text-truncate">{{ product.title }}</p>
              <span class="text-success mx-2 text-nowrap">PKR 500</span>
              <del class="text-danger mx-2 text-nowrap">PKR 500</del>
              <span class="text-success mx-2 text-nowrap">20% OFF</span>
              <div class="d-grid gap-2 m-2">
                <button class="btn btn-success" type="button" @click="addToCart()">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-if="isLoading">
        <div class="col" v-for="n in 4">
          <div class="card" aria-hidden="true">
            <svg class="w-100" height="300">
              <rect class="w-100 h-100" fill="#adb5bd"></rect>
            </svg>
            <div class="card-body placeholder-glow">
              <h6 class="placeholder col-10"></h6>
              <p>
                <span class="placeholder mx-2 col-3"></span>
                <span class="placeholder mx-2 col-3"></span>
                <span class="placeholder mx-2 col-3"></span>
              </p>
              <a href="#" tabindex="-1" class="btn btn-secondary disabled placeholder col-12"></a>
            </div>
          </div>
        </div>
      </template>
    </div>
    <div class="container text-center" v-show="!isLoading">
        <button class="btn btn-outline-success m-4" type="button" @click="getProducts()">Load More</button>
    </div>
  </div>
</template>
<script>
  export default
  {
    data()
    {
      let data =
      {
        products: [],
        isLoading: false,
      }

      return data;
    },

    created()
    {
      this.getProducts();
    },
    
    methods:
    {
      getProducts()
      {
        this.isLoading = true;

        fetch('https://jsonplaceholder.typicode.com/photos?_limit=4')
        .then(response => response.json())
        .then(json =>
          {
            this.products.push(...json);
            this.isLoading = false;
          }
        );
      },

      addToCart()
      {
        alert('addToCart()');
      }
    }
  }
</script>