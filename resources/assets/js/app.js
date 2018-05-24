
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// add
window.moment = require('moment');

import VueContentPlaceholders from 'vue-content-placeholders';
Vue.use(VueContentPlaceholders);
// end add

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// posts comments
Vue.component('post-component',require('./components/posts/PostComponent.vue'));
Vue.component('posts-component',require('./components/posts/PostsComponent.vue'));
Vue.component('post-create-component',require('./components/posts/PostCreateComponent.vue'));
Vue.component('comment-component',require('./components/posts/CommentComponent.vue'));
Vue.component('comments-component',require('./components/posts/CommentsComponent.vue'));

// users
Vue.component('avatar-upload-cropper-component',require('./components/users/AvatarUploadCropperComponent.vue'));
Vue.component('user-profile-component',require('./components/users/UserProfileComponent.vue'));
Vue.component('user-notifications-component',require('./components/users/NotificationsComponent.vue'));


const app = new Vue({
    el: '#app'
});

