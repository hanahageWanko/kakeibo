<template>
  <div class="user">
    <div class="user-info">
      <dl>
        <dt>ユーザー名：</dt>
        <dd>{{ userData.data.user_name }}</dd>
      </dl>
      <dl>
        <dt>Email：</dt>
        <dd>{{ userData.data.email }}</dd>
      </dl>
      <dl>
        <dt>権限：</dt>
        <dd>
          {{ userData.data.is_auth !== "1" ? "一般ユーザー" : "管理者" }}
        </dd>
      </dl>
      <dl>
        <dt>登録日：</dt>
        <dd>{{ userData.data.created_at }}</dd>
      </dl>
      <dl>
        <dt>更新日：</dt>
        <dd>{{ userData.data.updated_at }}</dd>
      </dl>
    </div>
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
    const userData: any = reactive({
      data: [],
    });
    // グローバル変数 axios の代わりに先述の設定の色々追加された AxiosInstance を BaseRepository 経由で使用する
    async function getUserInfo() {
      try {
        await BaseRepository.get("/user/read?id=5").then((res) => {
          userData.data = res.data;
        });
      } catch (error) {
        console.error(error);
      }
    }

    onMounted(() => {
      getUserInfo();
    });

    return {
      userData,
    };
  },
});
</script>

<style scoped>
.user {
  display: flex;
  align-content: center;
}

.user-info {
  margin: 0 auto;
}

.user-info dl {
  display: flex;
}
</style>
