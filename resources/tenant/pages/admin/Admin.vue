<template>
<div class="admin">
    <sidebar></sidebar>

    <router-view></router-view>

    <footer></footer>
</div>
</template>

<script>
import Sidebar from './components/Sidebar';
import Footer from './components/Footer';

export default {
    components: { Sidebar, Footer },
};
</script>

<style></style>
