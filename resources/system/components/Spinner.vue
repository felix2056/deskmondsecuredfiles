<template>
  <div class="spinner-container">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>  
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.spinner-container {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 20;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.4);
  display: flex;

  .spinner-border {
    height: 6rem;
    width: 6rem;
    margin: auto;
  }

}
</style>