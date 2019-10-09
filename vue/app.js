import Vue from 'vue';
import App from './Components/App.vue';

// Don't try and load Vue.js application where it's not needed
if (document.getElementById('app')) {
  new Vue({
    el: '#app',
    render: h => h(App)
  });
}
