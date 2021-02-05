<template>
    <aside class="sidebar">
        <div class="scrollbar-inner">
            <ul class="navigation">
                <!--ADMIN OPTIONS-->
                <li><router-link :to="{name: 'AdminIndex'}">Dashboard</router-link></li>
                <li><router-link :to="{name: 'manage-teachers'}">Teachers</router-link></li>
                <li><router-link :to="{name: 'manage-students'}">Students</router-link></li>
                <li><router-link :to="{name: 'settings'}">Settings</router-link></li>
                <li><a href="admin-logout.php">Logout</a></li>
            </ul>
        </div>
    </aside>
</template>

<script>
export default {};
</script>

<style></style>
