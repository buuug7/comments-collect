<template>
    <div class="user-widget bg-white" v-if="user">
        <div class="user-widget__top bg-primary position-relative"
             style="height: 9rem;">
            <div style="bottom: -50px;left: 50%;transform:translate(-50%,0)"
                 class="user-widget__img position-absolute">
                <img class="rounded-circle"
                     :src="user.avatar_url"
                     style="width: 100px;height:100px;border:3px solid #fff;">
            </div>
        </div>
        <div class="text-center px-3 pt-4 mt-5">
            <h3 class="mb-3">{{ user.name }}</h3>
            <p class="text-muted">{{ user.profile.bio }}</p>
            <a href="#" class="btn btn-outline-primary btn-sm">Follow</a>
        </div>
        <div class="user-widget__down px-3 py-4 d-flex flex-row justify-content-around">
            <div class="d-flex flex-column align-items-center">
                <a href="#" class="small">{{ user.created_posts_count }}</a>
                <span>Posts</span>
            </div>
            <div class="d-flex flex-column align-items-center">
                <a href="#" class="small">{{ user.created_comments_count }}</a>
                <span>Comments</span>
            </div>
            <div class="d-flex flex-column align-items-center">
                <a href="#" class="small">86</a>
                <span>Flowers</span>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['email'],
    data() {
      return {
        user: null,
      };
    },
    mounted() {
      axios.get(`/api/users/${this.email}`).then(response => {
        this.user = response.data;
      });
    }
  }
</script>