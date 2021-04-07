<template>
  <div>
    <Navigation />
    <img alt="Vue logo" src="./assets/logo.png" />
    <Read :msg="message" />
    {{ data }}
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive } from "vue";
import { BaseRepository } from "./axios/Api";
import Read from "./components/Read.vue";
import Navigation from "./components/Navigation.vue";

export default defineComponent({
  name: "App",
  components: {
    Read,
    Navigation,
  },

  setup() {
    const data: any = reactive({
      userData: [],
    });
    // グローバル変数 axios の代わりに先述の設定の色々追加された AxiosInstance を BaseRepository 経由で使用する
    async function getUserInfo() {
      try {
        await BaseRepository.get("/user/read?id=5").then((res) => {
          data.userData = res.data;
          console.log(data.userData);
        });
      } catch (error) {
        console.error(error);
      }
    }

    onMounted(() => {
      getUserInfo();
      console.log(data);
    });

    const message = "Welcome to Your Vue.js + TypeScript App";
    return {
      message,
      data,
    };
  },
});
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
