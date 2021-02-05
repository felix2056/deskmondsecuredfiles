<template>
  <table class="table table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">School Name</th>
        <th scope="col">FQDN</th>
        <th scope="col">Database</th>
        <th scope="col">Registered</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(school, index) in schools" :key="index">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ school.name }}</td>
        <td>
          <a :href="`${school.fqdn}`" target="_blank">{{ school.fqdn }}</a>
        </td>
        <td>{{ school.database }}</td>
        <td>{{ school.created_at }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ['schools']
}
</script>

<style>

</style>