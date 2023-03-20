<template>
  <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-4 border shadow px-3 py-4">
            <h2 class=" d-flex justify-content-center">Login</h2>
            <div class="alert alert-success" role="alert" v-if="verifyEmail.length">
              A verification email has been sent at <strong>{{ verifyEmail }}</strong>
            </div>
            <form class="row g-3" @submit.prevent="login()">
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" v-model="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" v-model="password" name="password" class="form-control" required>
                </div> 
                <div class="col-12">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </div>
                <NuxtLink class="text-decoration-none" to="/resetPassword">Forgot Password? Reset</NuxtLink>
                <hr/>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <NuxtLink class="btn btn-outline-success" to="/register">Register</NuxtLink>
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

        verifyEmail: 'numan.naseer.nomi@gmail.com',
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
