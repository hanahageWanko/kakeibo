<template>
  <div class="user-area">
    <div class="user">
      <form class="user-info form">
        <dl>
          <dt>ユーザー名</dt>
          <dd class="type-text">
            <input type="text" v-model="userData.data.user_name" />
            <span class="icon-box small">
              <fa icon="pen" class="icon"></fa>
            </span>
          </dd>
        </dl>
        <dl>
          <dt>Email</dt>
          <dd class="type-text">
            <input type="text" v-model="userData.data.email" />
            <span class="icon-box small">
              <fa icon="pen" class="icon"></fa>
            </span>
          </dd>
        </dl>
        <dl>
          <dt>権限</dt>
          <dd class="type-text">
            <span>{{
              userData.data.is_auth !== "1" ? "一般ユーザー" : "管理者"
            }}</span>
          </dd>
        </dl>
        <dl>
          <dt>登録日</dt>
          <dd class="type-text">
            <span>
              {{ userData.data.created_at }}
            </span>
          </dd>
        </dl>
        <dl>
          <dt>更新日</dt>
          <dd class="type-text">
            <span> {{ userData.data.updated_at }}</span>
          </dd>
        </dl>
      </form>
    </div>
    <div class="button-area">
      <Button class="button" @click="UpdateUserInfo()">更新する</Button>
      <Button class="button" color="#a1a1a1">削除する</Button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, computed } from "vue";
import { BaseRepository } from "@/axios/Api";
import { useStore } from "@/store/store"; // store/store.tsのものを利
import Button from "@/components/Button.vue";

// import HelloWorld from '@/components/HelloWorld.vue' // @ is an alias to /src

export default defineComponent({
  name: "User-index",
  components: {
    Button,
  },
  setup() {
    const userData: any = reactive({
      data: [],
    });
    const store = useStore();
    const userId = computed(() => store.state.userId);
    // グローバル変数 axios の代わりに先述の設定の色々追加された AxiosInstance を BaseRepository 経由で使用する
    async function getUserInfo() {
      try {
        await BaseRepository.get(`/user/read?id=${userId.value}`).then(
          (res) => {
            userData.data = res.data;
          }
        );
      } catch (error) {
        console.error(error);
      }
    }

    async function UpdateUserInfo() {
      try {
        console.log("x");
        await BaseRepository.post(`/user/update`, userData.data).then((res) => {
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
      userId,
      userData,
      UpdateUserInfo,
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
  min-width: 460px;
}

.user-info dl {
  display: flex;
  width: 100%;
}

.user-info dl + dl {
  margin-top: 0.6em;
}

.user-info dt,
.user-info dd {
  padding: 5px;
}

.user-info dt {
  width: 40%;
  text-align: left;
}

.user-info dd {
  width: 60%;
  display: flex;
}

.user-info dd span {
  display: block;
  width: 100%;
  text-align: left;
}

.button-area {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.button-area .button {
  margin: 1em;
  padding: 0.15em;
}
</style>
