<template>
  <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-5 border shadow px-3 py-4 mb-3">
            <h3 class ="d-flex justify-content-center mb-3">Profile Settings</h3>
            <div class="alert alert-danger" role="alert" v-if="errors">
              <span v-for="error in errors">
                <li v-for="item in error">{{ item }}</li>
              </span>
            </div>
            <form class="row g-3" @submit.prevent="updateProfile()">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" v-model="name" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" v-model="email" required>
                </div>
                <!-- <div class="col-md-6">
                    <label for="contactNumber" class="form-label">Contact Number</label>
                    <input type="number" name="contactNumber" class="form-control" v-model="contactNumber" required>
                </div> -->
                <div class="col-md-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" v-model="address" required>
                </div>
                <!-- <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" v-model="password" required>
                </div> 
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" v-model="password_confirmation" required>
                </div> -->
                <div class="col-12 mb-3">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success" :disabled="isLoading">
                          <span v-if="isLoading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </span>
                          <span v-else>Update</span>
                        </button>
                    </div>
                </div>
                <hr/>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <NuxtLink class="btn btn-outline-success" to="/changePassword">Change Password</NuxtLink>
                </div>
            </form>
        </div>
    </div>
  </div>
</template>
<script>
  definePageMeta(
    {
      middleware: ["auth"]
    }
  );

  export default
  {
    data()
    {
      let data =
      {
        authUser: useAuthUserState(),
        name: useAuthUserState().value.name,
        email: useAuthUserState().value.email,
        contactNumber: '',
        address: useAuthUserState().value.address,
        password: '',
        password_confirmation: '',

        isLoading: false,
        errors: null
      }

      return data;
    },
    
    methods:
    {
      updateProfile()
      {
        let url = useRuntimeConfig().public.API_URL + '/register';
        let payload =
        {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify(
            {
              name: this.name,
              email: this.email,
              address: this.address,
              password: this.password,
              password_confirmation: this.password_confirmation,
            }
          )
        };
        
        this.isLoading = true;
        this.clearData();
        
        fetch(url, payload)
        .then((response) => response.json())
        .then((data) =>
          {
            data.errors ? this.errors = data.errors : null;
            this.isLoading = false;
          }
        )
        .catch((error) => { console.error("Error:", error); });
      },

      clearData()
      {
        this.errors = null;
      }
    }
  }
</script>
