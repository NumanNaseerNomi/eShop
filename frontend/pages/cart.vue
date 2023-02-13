<template>
  <div class="container my-4">
    <h1>My Cart Items</h1>
    <template v-if="isLoading">
      <template v-for="n in 2">
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-2">
              <svg class="w-100 h-100">
                <rect class="w-100 h-100" fill="#adb5bd"></rect>
              </svg>
            </div>
            <div class="col-md-10">
              <div class="card-body placeholder-glow">
                <h6 class="placeholder col-5"></h6>
                <p>
                  <span class="placeholder mx-2 col-3"></span>
                  <span class="placeholder mx-2 col-3"></span>
                  <span class="placeholder mx-2 col-3"></span>
                </p>
                <a href="#" tabindex="-1" class="btn btn-secondary disabled placeholder col-12"></a>
              </div>
            </div>
          </div>
        </div>
      </template>
    </template>
    <template v-else>
      <template v-for="item in items">
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-2">
              <NuxtLink to="/product/detail">
                <img :src="item.url" class="img-fluid rounded-start" alt="...">
              </NuxtLink>
            </div>
            <div class="col-md-10">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </div>
          </div>
        </div>
      </template>
    </template>
  </div>
</template>
<script>
  export default
  {
    data()
    {
      let data =
      {
        items: null,
        isLoading: false,
      }

      return data;
    },

    created()
    {
      this.getCartItems();
    },
    
    methods:
    {
      getCartItems()
      {
        this.isLoading = true;

        fetch('https://jsonplaceholder.typicode.com/photos?_limit=2')
        .then(response => response.json())
        .then(json =>
          {
            this.items = json;
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
