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

//  Passport
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue')
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue')
);

// posts comments
Vue.component('posts-component', require('./components/posts/PostsComponent.vue'));
Vue.component('post-create-component', require('./components/posts/PostCreateComponent.vue'));
Vue.component('comments-component', require('./components/posts/CommentsComponent.vue'));

// users
Vue.component('user-widget-component', require('./components/users/UserWidgetComponent.vue'));
Vue.component('avatar-upload-cropper-component', require('./components/users/AvatarUploadCropperComponent.vue'));
Vue.component('user-profile-component', require('./components/users/UserProfileComponent.vue'));
Vue.component('user-notifications-component', require('./components/users/NotificationsComponent.vue'));


const app = new Vue({
  el: '#app'
});

