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
              <p class="card-text text-truncate">{{ product.name }}</p>
              <span class="text-success mx-2 text-nowrap">PKR {{ product.price }}</span>

              <table class="table">
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
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
    
    methods:
    {
      getThumbnailUrl(thumbnail)
      {
        return useRuntimeConfig().public.API_URL.replace(/\/api$/, '') + '/storage/' + thumbnail;
      },
    }
  }
</script>