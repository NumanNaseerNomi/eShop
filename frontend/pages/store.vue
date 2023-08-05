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
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form @submit.prevent="saveItem()">
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="inputID" class="form-label">ID</label>
                  <input type="number" class="form-control" id="inputID" :value="currentItem?.id" disabled>
                </div>
                <div class="col-md-6">
                  <label for="inputName" class="form-label">Name</label>
                  <input type="text" class="form-control" id="inputName" :value="currentItem?.name" required>
                </div>
                <div class="col-md-12">
                  <label for="inputDescription" class="form-label">Description</label>
                  <input type="text" class="form-control" id="inputDescription" :value="currentItem?.description" required>
                </div>
                <div class="col-md-6">
                  <label for="inputPrice" class="form-label">Price</label>
                  <input type="number" class="form-control" id="inputPrice" :value="currentItem?.price" required>
                </div>
                <div class="col-md-6">
                  <label for="inputQuantity" class="form-label">Quantity</label>
                  <input type="number" class="form-control" id="inputQuantity" :value="currentItem?.quantity" required>
                </div>
                <div class="col-md-6">
                  <label for="formThumbnail" class="form-label">Thumbnail</label>
                  <input class="form-control" type="file" id="formThumbnail" accept="image/*" :value="currentItem?.thumbnail" required>
                </div>
                <div class="col-md-6">
                  <label for="inputStatus" class="form-label">Status</label>
                  <select id="inputStatus" class="form-select" :value="currentItem?.status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th scope="col">#</th>
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
        <tr v-for="item in items">
          <th scope="row">1</th>
          <td><img :src="item.thumbnailUrl" class="img-thumbnail" alt="Thumbnail" style="max-width: 4rem;"></td>
          <td>Shirt</td>
          <td>Black Shirt</td>
          <td>PKR 1000</td>
          <td>12</td>
          <td>Active</td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
              <button type="button" class="btn btn-danger">Delete</button>
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
    <h2 class="text-center" v-if="!items && !isLoading">Store is Empty</h2>
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
        currentItem: null,
        isLoading: false,
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
        this.isLoading = true;

        fetch('http://localhost:8000/api/getProducts')
        .then(response => response.json())
        .then(json =>
          {
            this.items = json;
            this.isLoading = false;
          }
        );
      },

      saveItem()
      {
        alert(this.currentItem);
      }
    }
  }
</script>
