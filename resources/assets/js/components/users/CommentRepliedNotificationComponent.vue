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
               @click.prevent="markedAsRead"
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
            <CommentComponent
                    v-if="comment"
                    :comment="comment">
            </CommentComponent>
            <CommentComponent
                    class="pl-4"
                    v-if="repliedComment"
                    :comment="repliedComment">
            </CommentComponent>
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
        showDetail: false,
        read: false,
      };
    },
    components: {
      CommentComponent,
    },
    mounted() {
      this.notificationClone = this.notification;
    },
    computed: {
      createdAt() {
        return moment(this.notificationClone.created_at).fromNow()
      }
    },
    methods: {
      toggleDetail() {
        this.showDetail = !this.showDetail;
        this.loadDetail();
      },
      loadDetail() {
        axios.get(`/comments/${this.notificationClone.data.comment_id}`).then(response => {
          this.comment = response.data;
        });

        axios.get(`/comments/${this.notificationClone.data.replied_comment_id}`).then(response => {
          this.repliedComment = response.data;
        });
      },
      markedAsRead() {
        let confirmed = confirm('Do you really want to mark as read?');
        if (!confirmed) {
          return;
        }
        axios.post(`/notifications/${this.notificationClone.id}/read`).then(response => {
          this.read = true;
        });
      }
    }
  }
</script>