
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// add
import VueContentPlaceholders from 'vue-content-placeholders';
Vue.use(VueContentPlaceholders);
// end add

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('post-component',require('./components/posts/PostComponent.vue'));
Vue.component('posts-component',require('./components/posts/PostsComponent.vue'));

Vue.component('post-create-component',require('./components/posts/PostCreateComponent.vue'));

Vue.component('comment-component',require('./components/posts/CommentComponent.vue'));
Vue.component('comments-component',require('./components/posts/CommentsComponent.vue'));


const app = new Vue({
    el: '#app'
});

