<template>
  <section>
    <div class="container">
      <div class="card">
        <div class="card-header">
          <div class="card-header-title">Register Teacher</div>
        </div>
        <form method="POST" :action="post">
          <div class="card-content">
              <b-field label="Name">
                <b-input name="name" />
              </b-field>
              <b-field label="E-mail">
                <b-input name="email" type="email" />
              </b-field>
          </div>
          <footer class="card-footer">
            <div class="card-footer-item">
              <b-button type="is-primary" tag="input" native-type="submit" value="Submit"/>
            </div>
          </footer>
        </form>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  data () {
    return {
      post: 'api/create'
    }
  }
}
</script>
<style lang="scss" scoped>
  .card {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
  }
</style>
