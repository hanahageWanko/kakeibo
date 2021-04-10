<template>
  <div class="user">
    {{ data }}
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive } from "vue";
import { BaseRepository } from "../axios/Api";
// import HelloWorld from '@/components/HelloWorld.vue' // @ is an alias to /src

export default defineComponent({
  name: "User",
  components: {
    // HelloWorld,
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
        });
      } catch (error) {
        console.error(error);
      }
    }

    onMounted(() => {
      getUserInfo();
    });

    return {
      data,
    };
  },
});
</script>
