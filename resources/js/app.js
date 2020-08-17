require('./bootstrap');

window.Vue = require('vue');

Vue.component('tasks-app-panel', require('./components/TasksAppPanel.vue').default);

Vue.filter('titleFromCamel', function (str) {
    let toUppercase = str => str.toUpperCase();
    return str.replace(/[A-Z]/g, ' $&').replace(/^./, toUppercase)
});

const app = new Vue({
    el: '#app',
});
