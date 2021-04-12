import { InjectionKey } from "vue";
import { createStore, Store, useStore as baseUseStore } from "vuex";
import * as MutationTypes from "./mutationTypes";

// stateの型定義
type userId = number;

type State = {
  userId: userId;
};
// storeをprovide/injectするためのキー
export const key: InjectionKey<Store<State>> = Symbol();

// useStoreを使う時にキーの指定を省略するためのラッパー関数
export const useStore = () => {
  return baseUseStore(key);
};

// store本体
export const store = createStore<State>({
  state: {
    userId: -1,
  },
  mutations: {
    [MutationTypes.updateUserId](state, userId: userId) {
      state.userId = userId
    }
  }
});
