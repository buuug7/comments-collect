<style lang="scss" scoped>
    .comment {
        display: flex;
        flex-direction: column;
    }

    .comment__header {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
    }

    .comment__header-avatar {
        width: 50px;
        height: 50px;
    }

    .comment__header-author {
        display: flex;
        flex-direction: column;
    }

    .comment__body {
        p:last-child {
            margin-bottom: 0;
        }
    }

    .comment__actions {
        display: flex;
        flex-direction: row;
    }

    .comment__actions-likes {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .comment__replay {
        display: none;
    }

    .create-comment {

    }
</style>
<template>
    <div v-if="!deleted">
        <div v-if="commentClone" class="comment mb-4">
            <div class="comment__header mb-2">
                <img src="/images/avatar.jpg" class="comment__header-avatar mr-3" alt="">
                <div class="comment__header-author">
                    <span>{{ commentClone.user.name }}</span>
                    <span class="text-muted small">
                    {{ commentClone.created_at }}
                </span>
                </div>
            </div>
            <div class="comment__body mb-2">
                <div v-if="commentClone.target_comment">
                    <p>{{ commentClone.contents }}</p>
                    <blockquote class="blockquote blockquote-v1">
                        <a href="#">@{{ commentClone.target_user.name }}</a>
                        <p>{{ commentClone.target_comment.contents }}</p>
                    </blockquote>
                </div>
                <div v-else>
                    <p>{{ commentClone.contents }}</p>
                </div>
            </div>
            <div class="comment__actions mb-2">
                <div class="comment__action-likes mr-3">
                    <a href="javascript:"
                       @click.prevent="likeComment"
                       class="mr-1">
                        <i v-if="commentClone.has_liked_by_request_user" class="fa fa-thumbs-up"></i>
                        <i v-else class="fa fa-thumbs-o-up"></i>
                    </a>
                    <span class="like-counts small text-muted">
                    {{ commentClone.like_count}}
                </span>
                </div>
                <div class="comment__action-replay mr-3">
                    <a href="javascript:" @click.prevent="toggleReplyForm">
                        <i class="fa fa-reply"></i>
                    </a>
                </div>

                <div v-if="commentClone.has_owned_by_request_user"
                     class="comment__action-delete">
                    <a href="javascript:" @click.prevent="deleteComment">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
            <!-- display errors -->
            <div v-if="errors.length>0" class="alert alert-danger m-4">
                <ul class="mb-0">
                    <li v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <div class="comment__replay" :id="'comment-reply-'+commentClone.id">
                <form>
                    <div class="form-group">
                    <textarea class="form-control"
                              placeholder="add reply"
                              @input="clearError"
                              v-model="replyForm.contents"
                    ></textarea>
                    </div>
                    <a href="javascript:"
                       class="btn btn-primary"
                       @click.prevent="reply"
                    >reply</a>
                </form>
            </div>
        </div>
        <div v-else class="mb-5">
            <content-placeholders>
                <content-placeholders-heading :img="true"/>
                <content-placeholders-text :lines="2"/>
            </content-placeholders>
        </div>
    </div>

</template>

<script>
  export default {
    props: ['comment'],
    data() {
      return {
        commentClone: null,
        deleted: false,
        errors: [],
        replyForm: {
          contents: '',
          post_id: null,
          // user_id: null,
          target_user_id: null,
          target_comment_id: null,
        }
      };
    },
    mounted() {
      setTimeout(() => {
        this.commentClone = this.comment;
      }, 1000)
    },
    methods: {
      clearError() {
        this.errors = [];
      },
      resetReplyForm() {
        this.replyForm.contents = '';
        this.replyForm.post_id = null;
        this.replyForm.target_user_id = null;
        this.replyForm.target_comment_id = null;
      },
      toggleReplyForm() {
        this.clearError();

        let replyForm = document.querySelector(`#comment-reply-${this.commentClone.id}`);

        if (replyForm.style.display === 'none') {
          replyForm.style.display = 'block';
        } else {
          replyForm.style.display = 'none';
        }
      },
      likeComment() {
        axios.post(`/comments/${this.comment.id}/like`).then(response => {
          this.commentClone = response.data;
          this.clearError();
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.errors = _.flatten(_.toArray(error.response.data.errors));
            this.errors.push(error.response.data.message);
          } else {
            this.errors = ['something went wrong, please try again.'];
          }
        });
      },
      reply() {
        this.replyForm.post_id = this.commentClone.post_id;
        this.replyForm.target_user_id = this.commentClone.user_id;
        this.replyForm.target_comment_id = this.commentClone.id;
        axios.post(`/comments/${this.commentClone.id}/reply`, this.replyForm).then(response => {
          this.$emit('replied', response.data);
          this.resetReplyForm();
          this.toggleReplyForm();
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.errors = _.flatten(_.toArray(error.response.data.errors));
            this.errors.push(error.response.data.message);
          } else {
            this.errors = ['something went wrong, please try again.'];
          }
        });
      },
      deleteComment() {
        let confirmDelete = confirm('Do you really want delete?');
        if (!confirmDelete) {
          return;
        }
        axios.delete(`/comments/${this.comment.id}`).then(response => {
          console.log(response.data);
          this.commentClone = null;
          this.deleted = true;
        });
      }
    }
  }
</script>