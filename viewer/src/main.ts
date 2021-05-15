import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import {key, store} from './store/store'
import { FontAwesomeIcon } from "@/plugins/font-awesome";

createApp(App)
.use(router)
.use(store, key)
.component("fa", FontAwesomeIcon)
.mount('#app')