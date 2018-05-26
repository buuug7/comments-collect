<template>
    <div class="notification" v-if="notificationClone">
        <div class="mb-4">
            <h5>Your comment has replied.</h5>
            <p>{{ notificationClone.id }}</p>
            <small>{{ notificationClone.created_at }}</small>
        </div>
        <div class="mb-4">
            <a href="javascript:"
               @click.prevent="loadDetail(notificationClone.data.comment_id,notificationClone.data.replied_comment_id)"
               class="btn btn-outline-primary btn-sm">View Detail</a>
            <a href="javascript:"
               @click.prevent="markedAsRead"
               class="btn btn-outline-primary btn-sm"
            >Marked as Read
            </a>
        </div>
        <CommentComponent
                v-if="comment"
                :comment="comment"
        ></CommentComponent>
        <div class="pl-4">
            <CommentComponent
                    v-if="repliedComment"
                    :comment="repliedComment"
            ></CommentComponent>
        </div>
    </div>
</template>


<script>
  import CommentComponent from '../posts/CommentComponent.vue';

  export default {
    props: ['notification'],
    data() {
      return {
        notificationClone: null,
        comment: null,
        repliedComment: null,
      };
    },
    components: {
      CommentComponent,
    },
    mounted() {
      this.notificationClone = this.notification;
    },
    methods: {
      loadDetail(commentId, repliedCommentId) {
        axios.get(`/comments/${commentId}`).then(response => {
          this.comment = response.data;
        });

        axios.get(`/comments/${repliedCommentId}`).then(response => {
          this.repliedComment = response.data;
        });
      },
      markedAsRead() {
        axios.post(`/notifications/${this.notificationClone.id}/read`).then(response => {
          this.notificationClone = null;
          console.log(response.data);
        });
      }
    }
  }
</script>