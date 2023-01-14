<template>
  <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <template v-if="isLoading">
        <div class="col" v-for="n in 4">
          <div class="card" aria-hidden="true">
            <svg width="100%" height="300">
              <rect width="100%" height="100%" fill="#adb5bd"></rect>
            </svg>
            <div class="card-body">
              <h5 class="card-title placeholder-glow">
                <span class="placeholder col-6"></span>
              </h5>
              <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-8"></span>
              </p>
              <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="col" v-for="product in products">
          <div class="card">
            <img :src="product.url" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">{{ product.title }}</h5>
              <p class="card-text">{{ product.title }}</p>
            </div>
          </div>
        </div>
      </template>
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
        products: null,
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

        fetch('https://jsonplaceholder.typicode.com/photos?_limit=2')
        .then(response => response.json())
        .then(json =>
          {
            this.products = json;
            this.isLoading = false;
          }
        );
      }
    }
  }
</script>