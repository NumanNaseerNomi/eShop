<template>
  <div>
    <Navbar />
    <br/><br/>
    <slot />
  </div>
</template>
<script>
  import 'bootstrap/dist/css/bootstrap.min.css';

  export default
  {
    mounted()
    {
      import('bootstrap/dist/js/bootstrap.bundle.min.js');
    }
  }
</script>