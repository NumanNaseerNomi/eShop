<template>
  <div class="container my-4">
    <h1>My Store</h1>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button class="btn btn-success" type="button">Add Item</button>
    </div>

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
    <!-- <template v-if="isLoading">
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
    </template> -->
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
