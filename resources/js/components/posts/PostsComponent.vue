<template>
    <div class="posts">
        <PostComponent
                v-for="post in posts"
                :post="post"
                :key="post.id">
        </PostComponent>
        <div class="more d-flex justify-content-center">
            <a href="#"
               @click.prevent="more"
               ref="moreButton"
               class="btn btn-outline-primary">
                Load More
            </a>
        </div>
    </div>
</template>

<script>
  import PostComponent from './PostComponent.vue';

  export default {
    props:['requestUrl','requestMethod'],
    data() {
      return {
        posts: [],
        nextPageUrl: null,
      };
    },

    mounted() {
      axios[this.requestMethod](this.requestUrl).then(response => {
        this.posts = response.data.data;
        this.nextPageUrl = response.data.next_page_url;
      });
    },
    methods: {
      more(e) {
        let moreButton = this.$refs.moreButton;
        moreButton.textContent = 'loading...';

        if (!this.nextPageUrl) {
          moreButton.classList.add('disabled');
          moreButton.setAttribute('disabled', 'disabled');
          moreButton.textContent = 'No more';
          return;
        }

        axios[this.requestMethod](this.nextPageUrl).then(response => {
          this.posts = this.posts.concat(response.data.data);
          if (response.data.next_page_url) {
            this.nextPageUrl = response.data.next_page_url;
            moreButton.textContent = 'Load More';
          } else {
            this.nextPageUrl = null;
            moreButton.classList.add('disabled');
            moreButton.setAttribute('disabled', 'disabled');
            moreButton.textContent = 'No more';
          }
        }).catch(error => {
          console.log(error);
        });
      }
    },
    components: {
      PostComponent,
    }
  }
</script>