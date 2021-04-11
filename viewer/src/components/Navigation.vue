<template>
  <div class="navigation">
    <h1 class="font-allura">Expenses</h1>
    <nav class="nav">
      <ul>
        <li><router-link to="/user">User</router-link></li>
        <li><router-link to="/about">About</router-link></li>
      </ul>
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

.nav li a {
  padding: 4px 7px;
}

.nav li {
  display: inline-block;
}

.nav li:nth-of-type(n + 2) {
  border-left: 1px solid #534a3c;
}
</style>
