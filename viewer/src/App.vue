<template>
  <div>
    <Navigation />
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

    // TODO: userIDをAPIから取得する
    const setUserId = () => {
      store.commit(MutationTypes.updateUserId, 5);
    };

    // // グローバル変数 axios の代わりに先述の設定の色々追加された AxiosInstance を BaseRepository 経由で使用する
    // async function getUserInfo() {
    //   try {
    //     await BaseRepository.get("/user/read?id=5").then((res) => {
    //       console.log(res);
    //       data.userData = res.data;
    //     });
    //   } catch (error) {
    //     console.error(error);
    //   }
    // }

    onMounted(() => {
      if (store.state.userId === -1) setUserId();
      // getUserInfo();
    });

    return {
      data,
      userId,
    };
  },
});
</script>

<style lang="scss">
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
h6,
dl,
dt,
dd,
div {
  margin: 0;
}

dl,
dt,
dd {
  margin: 0;
}

input,
textarea {
  border: none;
}

span,
strong,
b,
small,
input,
textarea {
  font-family: inherit;
  font-size: inherit;
  font-style: inherit;
  background: inherit;
  box-shadow: inherit;
  color: inherit;
}

.icons {
  width: 100%;
  display: block;
}

.icon-box {
  &.small {
    width: 18px !important;
    height: 18px;
  }
  &.medium {
    width: 24px !important;
    height: 24px;
  }
  &.large {
    width: 28px !important;
    height: 28px;
  }
}

div,
dl,
dt,
dd,
ul,
ol,
li,
span,
strong,
b,
small,
input,
textarea,
p,
h1,
h2,
h3,
h4,
h5,
h6 {
  box-sizing: border-box;
}

input {
  display: block;
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
  font-size: 16px;
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

.form .type-text {
  border-bottom: 1px solid #534a3c;
}

.form input[type="text"],
.form textarea {
  width: 100%;
}
</style>
