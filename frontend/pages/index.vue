<template>
  <ProductsCard/>
<div class="container my-4 p-5">
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
                isLoading: false,
            }

            return data;
        },
    }
</script>