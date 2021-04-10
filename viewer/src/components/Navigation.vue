<template>
  <div class="navigation">
    <h1 class="font-allura">Expenses</h1>
    <nav class="nav">
      <router-link to="/user">User</router-link> |
      <router-link to="/about">About</router-link>
    </nav>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({});
</script>

<style>
.navigation h1 {
  color: #e9e8e6;
  background-color: #534a3c;
  padding: 0.3em;
}

.nav {
  margin: 0.8em auto 0.6em;
  padding: 0.25em;
  font-size: 1.25em;
  /* #F5D1CA
#B0C9D2 */
}
</style>
