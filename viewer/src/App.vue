<template>
  <div>
    <Navigation />
    ああああああ
    <div>ユーザID:{{ userId }}</div>
    <router-view />
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, computed } from "vue";
// import { defineComponent, computed } from "@vue/runtime-core";
import { useStore } from "./store/store"; // store/store.tsのものを利用
import { BaseRepository } from "./axios/Api";
import Navigation from "./components/Navigation.vue";
import * as MutationTypes from "./store/mutationTypes";

export default defineComponent({
  name: "App",
  components: {
    Navigation,
  },

  setup() {
    const data: any = reactive({
      userData: [],
    });
    const store = useStore();
    const userId = computed(() => store.state.userId);

    const setUserId = () => {
      store.commit(MutationTypes.updateUserId, 5);
    };

    // グローバル変数 axios の代わりに先述の設定の色々追加された AxiosInstance を BaseRepository 経由で使用する
    async function getUserInfo() {
      try {
        await BaseRepository.get("/user/read?id=5").then((res) => {
          data.userData = res.data;
        });
      } catch (error) {
        console.error(error);
      }
    }

    onMounted(() => {
      if (store.state.userId === -1) setUserId();
      getUserInfo();
    });

    return {
      data,
      userId,
    };
  },
});
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Allura&display=swap");
html,
body {
  padding: 0;
  margin: 0;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  margin: 0;
}

span,
strong,
b,
small {
  font-family: inherit;
  font-size: inherit;
  font-style: inherit;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  height: 100vh;
  width: 100%;
  color: #534a3c;
  background-color: #e9e8e6;
}

ul {
  padding: 0;
}

li {
  list-style: none;
}

.font-allura {
  font-family: "Allura", cursive;
}

a,
a:visited {
  color: inherit;
  text-decoration: none;
}
</style>
