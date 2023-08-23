<template>
  <div class="container my-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="infinite-list">
      <template v-if="products.length">
        <div class="col" v-for="product in products">
          <div class="card h-100 text-decoration-none text-body">
            <img :src="getThumbnailUrl(product.thumbnail)" class="card-img-top" alt="..." role="button">
            <div class="card-body h6 m-0">
              <p class="card-text text-truncate">{{ product.name }}</p>
              <span class="text-success mx-2 text-nowrap">PKR {{ product.price }}</span>
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
    <div class="container text-center" v-show="!isLoading && canLoadMore">
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
        canLoadMore: true,
        page: 1,
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
        let url = useRuntimeConfig().public.API_URL + '/getProducts?page=' + this.page;
        this.isLoading = true;

        fetch(url)
        .then(response => response.json())
        .then(data =>
          {
            this.products.push(...data.data.data);
            this.isLoading = false;
            this.page++;

            if(this.page > data.data.last_page)
            {
              this.canLoadMore = false;
            }
          }
        );
      },

      addToCart()
      {
        alert('addToCart()');
      },

      getThumbnailUrl(thumbnail)
      {
        return useRuntimeConfig().public.API_URL.replace(/\/api$/, '') + '/storage/' + thumbnail;
      },
    }
  }
</script>