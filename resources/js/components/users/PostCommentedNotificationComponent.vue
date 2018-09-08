<template>
    <div class="notification mb-5" v-if="notificationClone">
        <div class="notification__type mb-2">
            <h5>{{ notificationClone.type }}</h5>
        </div>
        <div class="notification__message mb-2">
            {{ notification.data.message }}
        </div>
        <div class="notification__time mb-2">
            <small>{{ createdAt }}</small>
        </div>
        <div class="notification__action mb-4">
            <a href="javascript:"
               @click.prevent="toggleDetail"
               class="btn btn-outline-primary btn-sm">Detail</a>
            <a href="javascript:"
               v-if="!read"
               @click.prevent="markAsRead"
               class="btn btn-outline-primary btn-sm">
                Mark as read <i class="fa fa-check"></i>
            </a>
            <a href="javascript:"
               v-else
               class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i>
            </a>
        </div>

        <div class="notification__detail" v-if="showDetail">
            <PostComponent
                    v-if="post"
                    :post="post">
            </PostComponent>
            <CommentComponent
                    v-if="comment"
                    :comment="comment">
            </CommentComponent>
        </div>
    </div>
</template>


<script>
  import PostComponent from '../posts/PostComponent.vue';
  import CommentComponent from '../posts/CommentComponent.vue';

  export default {
    props: ['notification'],
    data() {
      return {
        notificationClone: null,
        showDetail: false,
        read: false,
        post: null,
        comment: null,
      };
    },
    components: {
      PostComponent,
      CommentComponent,
    },
    mounted() {
      this.notificationClone = this.notification;
    },
    computed: {
      createdAt() {
        return moment(this.notificationClone.created_at).fromNow();
      }
    },
    methods: {
      toggleDetail() {
        this.showDetail = !this.showDetail;
        this.loadDetail();
      },
      loadDetail() {
        axios.get(`/api/posts/${this.notificationClone.data.post_id}`).then(response => {
          this.post = response.data;
        });

        axios.get(`/api/comments/${this.notificationClone.data.comment_id }`).then(response => {
          this.comment = response.data;
        });
      },
      markAsRead() {
        let confirmed = confirm('Do you really want to mark this as read?');
        if (!confirmed) {
          return;
        }
        axios.post(`/api/notifications/${this.notificationClone.id}/read`).then(response => {
          this.read = true;
        });
      }
    }
  }
</script>