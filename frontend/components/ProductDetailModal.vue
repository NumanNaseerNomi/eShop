<template>
  <div class="modal fade" :id="modalId" tabindex="-1" :aria-labelledby="modalId + 'Label'" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" :id="modalId + 'Label'">Product Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="clearData()"></button>
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
                <div class="alert alert-success" role="alert" v-show="message.length">{{ message }}</div>
                <button class="btn btn-success" type="button" v-show="!message.length" @click="addToCart(product.id)" :disabled="isLoading">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  Add to Cart
                </button>
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
        isLoading: false,
      }

      return data;
    },
    
    methods:
    {
      getThumbnailUrl(thumbnail)
      {
        return useRuntimeConfig().public.API_URL.replace(/\/api$/, '') + '/storage/' + thumbnail;
      },

      clearData()
      {
        this.message = '';
      },

      addToCart(product_id)
      {
        this.isLoading = true;
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
            this.isLoading = false;
          }
        )
        .catch((error) => { console.error("Error:", error); });
      },
    }
  }
</script>