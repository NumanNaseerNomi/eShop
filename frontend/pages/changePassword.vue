<template>
  <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-5 border shadow px-3 py-4 mb-3">
            <h3 class ="d-flex justify-content-center mb-3">Change Password</h3>
            <div class="alert alert-info" role="alert" v-if="message.length">{{ message }}</div>
            <div class="alert alert-danger" role="alert" v-if="errors">
              <span v-for="error in errors">
                <li v-for="item in error">{{ item }}</li>
              </span>
            </div>
            <form class="row g-3" @submit.prevent="changePassword()">
                <div class="col-md-12">
                    <label for="password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" v-model="current_password" required>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" v-model="password" required>
                </div> 
                <div class="col-md-12">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" v-model="password_confirmation" required>
                </div>
                <div class="col-12 mb-3">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success" :disabled="isLoading">
                          <span v-if="isLoading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </span>
                          <span v-else>Change Password</span>
                        </button>
                    </div>
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
        current_password: '',
        password: '',
        password_confirmation: '',

        isLoading: false,
        message: '',
        errors: null
      }

      return data;
    },
    
    methods:
    {
      changePassword()
      {
        let url = useRuntimeConfig().public.API_URL + '/changePassword';
        let payload =
        {
          method: "POST",
          headers:
          {
            "Content-Type": "application/json",
            'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
          },
          body: JSON.stringify(
            {
              current_password: this.current_password,
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

            if(data.status == 'success')
            {
              data.message ? this.message = data.message : null;
            }
          }
        )
        .catch((error) => { console.error("Error:", error); });
      },

      clearData()
      {
        this.errors = null;
        this.message = '';
      }
    }
  }
</script>
