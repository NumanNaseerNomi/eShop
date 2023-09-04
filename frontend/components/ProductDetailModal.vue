<template>
  <div class="modal fade" :id="modalId" tabindex="-1" :aria-labelledby="modalId + 'Label'" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" :id="modalId + 'Label'">Product Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card h-100 text-decoration-none text-body">
            <img :src="getThumbnailUrl(product.thumbnail)" class="card-img-top" alt="...">
            <div class="card-body h6 m-0">
              <table class="table">
                <tbody>
                  <tr>
                    <th scope="row">Name</th>
                    <td>{{ product.name }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Description</th>
                    <td>{{ product.description }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Price</th>
                    <td>PKR {{ product.price }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Stock</th>
                    <td>{{ product.quantity }}</td>
                  </tr>
                </tbody>
              </table>
              <div class="d-grid gap-2 m-2">
                <button class="btn btn-success" type="button" @click="addToCart(product.id)">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default
  {
    props:
    {
      modalId:
      {
        type: String,
        default: 'exampleModal',
      },

      product:
      {
        type: Object,
        required: true,
      },
    },

    data()
    {
      let data =
      {
        message: '',
      }

      return data;
    },
    
    methods:
    {
      getThumbnailUrl(thumbnail)
      {
        return useRuntimeConfig().public.API_URL.replace(/\/api$/, '') + '/storage/' + thumbnail;
      },

      addToCart(product_id)
      {
        let url = useRuntimeConfig().public.API_URL + '/cart/add';
        let payload =
        {
          method: "POST",
          headers: { "Content-Type": "application/json", 'Authorization': 'Bearer ' + localStorage.getItem('accessToken'), },
          body: JSON.stringify({ product_id: product_id, quantity: 1 })
        };

        fetch(url, payload)
        .then((response) => response.json())
        .then((data) =>
          {
            this.message = data.message;
          }
        )
        .catch((error) => { console.error("Error:", error); });
      },
    }
  }
</script>