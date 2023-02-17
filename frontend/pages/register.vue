<template>
  <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-5 border shadow px-3 py-4 mb-3">
            <h3 class ="d-flex justify-content-center mb-3">Create New Account</h3>
            <form action="/register" method="post" class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="col-md-6">
                    <label for="contactNumber" class="form-label">Contact Number</label>
                    <input type="number" name="contactNumber" class="form-control" id="contactNumber" required>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div> 
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                </div>
                <div class="col-12  mb-3">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </div>
                <hr/>
                <!-- <span>Already Registered?</span> -->
                <div class="d-grid gap-2 col-6 mx-auto">
                    <NuxtLink class="btn btn-outline-success" to="/login">Login</NuxtLink>
                </div>
            </form>
        </div>
    </div>
  </div>
</template>
<script>
  export default
  {
    data()
    {
      let data =
      {
        email: '',
        password: '',
      }

      return data;
    },
    
    methods:
    {
      login()
      {
        alert(this.password + ' login() '+ this.email);
      }
    }
  }
</script>
