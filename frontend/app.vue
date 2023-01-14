<template>
  <div>
    <h1>Hi NOMi</h1>
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