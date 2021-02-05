<template>
  <b-navbar>
    <template slot="brand">
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <span>Deskmond</span>
      </b-navbar-item>
    </template>
    <template slot="start">
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        Home
      </b-navbar-item>
      <b-navbar-item tag="router-link" :to="{ path: '/pricing' }">
        Pricing
      </b-navbar-item>
      <b-navbar-item tag="router-link" :to="{ path: '/about' }">
        About
      </b-navbar-item>
    </template>
    <template slot="end">
      <b-navbar-item tag="router-link" :to="{ path: '/register' }">
        Register
      </b-navbar-item>
    </template>
  </b-navbar>
</template>