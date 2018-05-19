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
        <div v-if="postClone">
            <div class="card post mb-5 rounded-0 border-0 box-shadow-3">
                <div class="card-header text-center">
                    Added by <a href="#">{{ postClone.user.name }}</a>
                </div>
                <div class="card-body">
                    <!-- display errors -->
                    <div v-if="errors.length>0" class="alert alert-warning m-4">
                        <ul class="mb-0">
                            <li v-for="error in errors">
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="post__content mb-4">{{ postClone.contents }}</div>

                    <div class="callout callout-warning post__reference">
                        <h4>Reference</h4>
                        <p>
                            {{ postClone.reference}}
                        </p>
                    </div>

                    <div class="callout callout-warning post__tags"
                         v-if="postClone.tags.length>0">
                        <h4>Tags</h4>
                        <a href="#"
                           v-for="tag in postClone.tags"
                           class="badge badge-secondary mr-1">
                            {{ tag.name }}
                        </a>
                    </div>

                    <div class="post__actions mb-4">
                        <a href="#"
                           v-if="postClone.has_stared_by_request_user"
                           @click.prevent="star"
                           class="btn btn-outline-primary mb-2">
                            Stared ({{ postClone.stared_users_count }})
                        </a>
                        <a href="#"
                           v-else
                           @click.prevent="star"
                           class="btn btn-outline-primary mb-2">
                            Star ({{ postClone.stared_users_count }})
                        </a>
                        <a href="#"
                           @click.prevent="toggleComments"
                           class="btn btn-outline-primary mb-2">
                            Comments ( 999 )
                        </a>
                        <a href="#"
                           v-if="postClone.has_owned_by_request_user"
                           @click.prevent="editPost"
                           class="btn btn-outline-primary mb-2">Edit</a>
                        <a href="#"
                           v-if="postClone.has_owned_by_request_user"
                           @click.prevent="deletePost"
                           class="btn btn-outline-danger mb-2">Delete</a>

                    </div>

                    <div class="comments" v-if="showComments">
                        <h3 class="mb-4">Comments ({{ comments.length }})</h3>
                        <div class="create-comment mb-4">
                            <!-- Form Errors -->
                            <div class="alert alert-danger" v-if="commentCreateForm.errors.length > 0">
                                <ul class="mb-0">
                                    <li v-for="error in commentCreateForm.errors">
                                        {{ error }}
                                    </li>
                                </ul>
                            </div>
                            <form>
                                <div class="form-group">
                                    <textarea
                                            class="form-control"
                                            name="newComment"
                                            placeholder="add new comment"
                                            v-model="commentCreateForm.contents"
                                    ></textarea>
                                </div>
                                <a href="javascript:"
                                   class="btn btn-primary"
                                   @click.prevent="addNewComment"
                                >comment</a>
                            </form>
                        </div>
                        <div v-if="comments.length >0" v-for="comment in comments"
                             class="comment mb-4">
                            <div class="comment__header mb-2">
                                <img src="https://avatars3.githubusercontent.com/u/12119289?s=50&v=4" class="comment__header-avatar mr-3" alt="">
                                <div class="comment__header-author">
                                    <span>{{ comment.user.name }}</span>
                                    <span class="text-muted small">{{ comment.created_at }}</span>
                                </div>
                            </div>
                            <div class="comment__body mb-2">
                                <p>{{ comment.contents }}</p>
                            </div>
                            <div class="comment__actions mb-2">
                                <div class="comment__action-likes mr-3">
                                    <a href="javascript:" class="mr-1">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </a>
                                    <span class="like-counts small text-muted">9999</span>
                                </div>
                                <div class="comment__action-replay">
                                    <a href="javascript:" @click.prevent="toggleReplyForm(comment)">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="comment__replay" :id="'comment-reply-'+comment.id">
                                <form action="">
                                    <div class="form-group">
                                        <textarea class="form-control" name="replay"></textarea>
                                    </div>
                                    <a href="javascript:" class="btn btn-primary">reply</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    Last updated : {{ postClone.updated_at }}
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Errors -->
                            <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                                <ul class="mb-0">
                                    <li v-for="error in editForm.errors">
                                        {{ error }}
                                    </li>
                                </ul>
                            </div>
                            <form method="post">
                                <div class="form-group">
                                    <label for="reference">reference</label>
                                    <input type="text"
                                           name="reference"
                                           id="reference"
                                           class="form-control"
                                           v-model="editForm.reference">
                                </div>
                                <div class="form-group">
                                    <label for="contents">contents</label>
                                    <textarea
                                            name="contents"
                                            id="contents"
                                            class="form-control"
                                            v-model="editForm.contents"
                                            rows="4">
                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label>Tags</label>
                                    <input-tag
                                            placeholder="Add tags to your post and make it more discoverable."
                                            :tags.sync="editForm.tagsArray">
                                    </input-tag>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="button"
                                    class="btn btn-primary"
                                    @click="update">Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="mb-5">
            <content-placeholders>
                <content-placeholders-img/>
                <content-placeholders-text :lines="2"/>
            </content-placeholders>
        </div>
    </div>
</template>

<script>
  import InputTag from 'vue-input-tag';

  import {ContentLoader} from 'vue-content-loader'

  export default {
    props: ['post'],
    data() {
      return {
        errors: [],
        postClone: null,
        deleted: false,
        editForm: {
          errors: [],
          reference: '',
          contents: '',
          tags: [],
          tagsArray: [],
        },
        comments: [],
        showComments: false,
        commentCreateForm: {
          errors: [],
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
        this.postClone = this.post;
      }, 1000)
    },
    methods: {

      star() {
        axios.post(`/posts/${this.post.id}/star`).then(response => {
          this.postClone = response.data;
        }).catch(error => {
          this.errors = [error.response.data.message, 'Maybe you need login first.'];
        });
      },
      deletePost() {
        let disStar = confirm('do you really want to delete it?');
        if (!disStar) {
          return;
        }
        axios.delete(`/posts/${this.post.id}`).then(response => {
          this.postClone = null;
          this.deleted = true;
        }).catch(error => {
          this.errors = [error.response.data.message];
        });
      },
      editPost() {
        this.editForm.id = this.postClone.id;
        this.editForm.reference = this.postClone.reference;
        this.editForm.contents = this.postClone.contents;

        this.postClone.tags.forEach(v => {
          this.editForm.tagsArray.push(v.name);
        });
        $('#editModal').modal('show');
      },
      update() {
        axios.put(`/posts/${this.editForm.id}`, this.editForm).then(response => {
          console.log(response);
          this.postClone = response.data;
          this.editForm.reference = '';
          this.editForm.contents = '';
          this.editForm.tagsArray = [];
          $('#editModal').modal('hide');
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.editForm.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.editForm.errors = ['something went wrong, please try again.'];
          }
        });
      },

      loadComments() {
        axios.get(`/posts/${this.postClone.id}/comments`).then(response => {
          this.comments = response.data;
          console.log('loaded finished');
        });

      },

      toggleComments() {
        if (!this.showComments) {
          this.loadComments();
          this.showComments = !this.showComments;
        } else {
          this.showComments = !this.showComments;
          this.comments = [];
        }

      },

      toggleReplyForm(comment) {
        let replyForm = document.querySelector(`#comment-reply-${comment.id}`);

        if (replyForm.style.display === 'none') {
          replyForm.style.display = 'block';
        } else {
          replyForm.style.display = 'none';
        }
      },

      addNewComment() {
        this.commentCreateForm.post_id = this.postClone.id;
        axios.post('/comments', this.commentCreateForm).then(response => {
          this.commentCreateForm.contents = '';
          this.commentCreateForm.post_id = null;
          //this.commentCreateForm.user_id = null;
          this.commentCreateForm.target_user_id = null;
          this.commentCreateForm.target_comment_id = null;
          console.log(response.data);

          this.comments.unshift(response.data);
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.commentCreateForm.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.commentCreateForm.errors = ['something went wrong, please try again.'];
          }
        });

      },
    },
    components: {
      InputTag,
    },
  }

</script>