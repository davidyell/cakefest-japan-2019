import Vue from 'vue';
import App from './Components/App.vue';
import { store } from './Store/Store.js';

// Don't try and load Vue.js application where it's not needed
if (document.getElementById('app')) {
  const app = new Vue({
    el: '#app',
    store: store,
    render: h => h(App)
  });
}
