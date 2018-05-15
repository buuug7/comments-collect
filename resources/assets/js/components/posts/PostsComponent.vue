<template>
    <div class="posts">
        <PostComponent
                v-for="post in posts"
                :post="post"
                :key="post.id">
        </PostComponent>
    </div>
</template>

<script>
  import PostComponent from './PostComponent.vue';

  export default {
    data() {
      return {
        posts: [],
      };
    },
    mounted() {
      axios.get('/posts').then(response => {
        this.posts = response.data;
      });

    },
    components: {
      PostComponent,
    }
  }
</script>