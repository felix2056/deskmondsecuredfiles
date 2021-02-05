<template>
  <div class="users-table">
    <users-table :schools="schools" />
  </div>
</template>

<script>
import UsersTable from '../components/Admin/UsersTable'

export default {
  components: {
    UsersTable
  },
  data () {
    return {
      schools: []
    }
  },
  methods: {
    async getTenants () {
      const { data } = await axios.get(API.tenants)
      this.schools = data.schools
    }
  },
  mounted () {
    this.getTenants()
  }
}
</script>

<style lang="scss" scoped>
  .users-table {
    width: 100%;
    max-width: 1000px;
    margin: 2em auto;
  }
</style>