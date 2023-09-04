<template>
  <div class="container my-4">
    <h1>My Cart</h1>
    <table class="table table-striped align-middle" v-if="items.length">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">ID</th>
          <th scope="col">Thumbnail</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
          <th scope="col">Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items">
          <th scope="row">{{ ++index }}</th>
          <td>{{ item.id }}</td>
          <td><img :src="getThumbnailUrl(item.product.thumbnail)" class="img-thumbnail" alt="Thumbnail" style="max-width: 4rem;"></td>
          <td>{{ item.product.name }}</td>
          <td>{{ item.product.description }}</td>
          <td>{{ item.product.price }}</td>
          <td>{{ item.quantity }}</td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-danger" @click="removeItem(item.id)">Remove</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex justify-content-center" v-if="isLoading">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <h2 class="text-center" v-if="!items.length && !isLoading">Store is Empty</h2>
  </div>
</template>
<script>
  export default
  {
    data()
    {
      let data =
      {
        items: [],
        currentItem: {},
        isLoading: false,
        isSaving: false,
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
        let url = useRuntimeConfig().public.API_URL + '/cart/items';
        let payload =
        {
          method: "POST",
          headers: { 'Authorization': 'Bearer ' + localStorage.getItem('accessToken'), },
        };
        this.isLoading = true;

        fetch(url, payload)
        .then(response => response.json())
        .then(json =>
          {
            this.items = json.data.data;
            this.isLoading = false;
          }
        );
      },

      saveItem()
      {
        let url = useRuntimeConfig().public.API_URL + '/saveProduct';

        let formData = new FormData();
  
        for(let field in this.currentItem)
        {
          formData.append(field, this.currentItem[field]);
        }

        let payload =
        {
          method: "POST",
          headers: { 'Authorization': 'Bearer ' + localStorage.getItem('accessToken'), },
          body: formData
        };
        
        this.isSaving = true;
        
        fetch(url, payload)
        .then((response) => response.json())
        .then((data) =>
          {
            this.$refs.closeButton.click();
            this.currentItem.id ?? this.items.push(data.data);
            this.currentItem = {};
            this.$refs.thumbnailInput.value = '';
            this.isSaving = false;
          }
        )
        .catch((error) => { console.error("Error:", error); });
      },

      removeItem(id)
      {
        let url = useRuntimeConfig().public.API_URL + '/deleteProduct';
        let payload =
        {
          method: "DELETE",
          headers:
          {
            "Content-Type": "application/json",
            'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
          },
          body: JSON.stringify({ id: id })
        };

        this.items = this.items.filter(item => item.id !== id);

        fetch(url, payload)
        .then((response) => response.json())
        .then((data) => {})
        .catch((error) => { console.error("Error:", error); });
      },

      getThumbnailUrl(thumbnail)
      {
        return useRuntimeConfig().public.API_URL.replace(/\/api$/, '') + '/storage/' + thumbnail;
      },
    }
  }
</script>
