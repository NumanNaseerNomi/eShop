<template>
  <div class="container my-4">
    <h1>My Store</h1>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Item</button>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeButton"></button>
          </div>
          <form @submit.prevent="saveItem()">
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="inputID" class="form-label">ID</label>
                  <input type="number" class="form-control" id="inputID" v-model="currentItem.id" disabled>
                </div>
                <div class="col-md-6">
                  <label for="inputName" class="form-label">Name</label>
                  <input type="text" class="form-control" id="inputName" v-model="currentItem.name" required>
                </div>
                <div class="col-md-12">
                  <label for="inputDescription" class="form-label">Description</label>
                  <input type="text" class="form-control" id="inputDescription" v-model="currentItem.description" required>
                </div>
                <div class="col-md-6">
                  <label for="inputPrice" class="form-label">Price</label>
                  <input type="number" class="form-control" id="inputPrice" v-model="currentItem.price" required>
                </div>
                <div class="col-md-6">
                  <label for="inputQuantity" class="form-label">Quantity</label>
                  <input type="number" class="form-control" id="inputQuantity" v-model="currentItem.quantity" required>
                </div>
                <div class="col-md-6">
                  <label for="formThumbnail" class="form-label">Thumbnail</label>
                  <input class="form-control" type="file" id="formThumbnail" ref="thumbnailInput" accept="image/*" @change="($event) => { this.currentItem.thumbnail = $event.target.files[0]; }" required>
                </div>
                <div class="col-md-6">
                  <label for="inputStatus" class="form-label">Status</label>
                  <select id="inputStatus" class="form-select" v-model="currentItem.isActive" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" :class="{'disabled': isSaving}">
                <div class="spinner-border spinner-border-sm" role="status" v-if="isSaving">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <span v-else>Save</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
          <th scope="col">Status</th>
          <th scope="col">Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items">
          <th scope="row">{{ ++index }}</th>
          <td>{{ item.id }}</td>
          <td><img :src="getThumbnailUrl(item.thumbnail)" class="img-thumbnail" alt="Thumbnail" style="max-width: 4rem;"></td>
          <td>{{ item.name }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.price }}</td>
          <td>{{ item.quantity }}</td>
          <td>{{ item.isActive ? 'Active' : 'Inactive' }}</td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-primary" @click="editItem(item.id)" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
              <button type="button" class="btn btn-danger" @click="deleteItem(item.id)">Delete</button>
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
      this.getStoreItems();
    },
    
    methods:
    {
      getStoreItems()
      {
        let url = useRuntimeConfig().public.API_URL + '/getProducts';
        this.isLoading = true;

        fetch(url)
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
            this.items.push(data.data);
            this.currentItem = {};
            this.$refs.thumbnailInput.value = '';
            this.isSaving = false;
          }
        )
        .catch((error) => { console.error("Error:", error); });
      },

      editItem(id)
      {
        this.currentItem = this.items.find((item) => item.id === id);
      },

      deleteItem(id)
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
