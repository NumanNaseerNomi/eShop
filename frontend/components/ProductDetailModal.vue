<template>
  <div class="modal fade" :id="modalId" tabindex="-1" :aria-labelledby="modalId + 'Label'" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" :id="modalId + 'Label'">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
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