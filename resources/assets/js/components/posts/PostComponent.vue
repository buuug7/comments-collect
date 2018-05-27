<style scoped lang="scss">
    .post__content {
        position: relative;
        overflow: hidden;
    }

    .post__content-more_overlay {
        position: absolute;
        display: none;
        flex-flow: row wrap;
        justify-content: center;
        bottom: 0;
        width: 100%;
        background-image: linear-gradient(
                        rgba(255, 255, 255, 0.2),
                        rgba(255, 255, 255, 0.4),
                        rgba(255, 255, 255, 0.6),
                        rgba(255, 255, 255, 0.8),
                        rgba(255, 255, 255, 1)
        );
        padding: 40px 0 0 0;
        > a {
            color: #616161;

        }
        > a:hover {
            text-decoration: none;
        }
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

                    <div class="post__content mb-4" ref="postContents">
                        <div>{{ postClone.contents }}</div>
                        <div class="post__content-more_overlay">
                            <a href="javascript:"
                               @click="showMore"
                               class="more-button-1">
                                view more <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>

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
                           v-if="postClone.has_star_by_request_user"
                           @click.prevent="star"
                           class="btn btn-primary mb-2">
                            Star ({{ postClone.star_users_count }})
                        </a>
                        <a href="#"
                           v-else
                           @click.prevent="star"
                           class="btn btn-outline-primary mb-2">
                            Star ({{ postClone.star_users_count }})
                        </a>
                        <a href="#"
                           @click.prevent="toggleComments"
                           class="btn btn-outline-primary mb-2">
                            Comments ( {{ postClone.comments_count }} )
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
                    <!-- display errors -->
                    <div v-if="errors.length>0" class="alert alert-danger m-4">
                        <ul class="mb-0">
                            <li v-for="error in errors">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <CommentsComponent
                            v-if="showComments"
                            :post-id="postClone.id"
                            :request-url="'/posts/'+postClone.id+'/comments'"
                            request-method="post">
                    </CommentsComponent>
                </div>

                <div class="card-footer text-muted">
                    Last updated : {{ updatedAt }}
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" :id="'editModal-'+postClone.id" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Post</h4>
                            <button type="button" class="close" data-dismiss="modal">
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
                                    <label for="reference">Reference</label>
                                    <input type="text"
                                           name="reference"
                                           id="reference"
                                           class="form-control"
                                           v-model="editForm.reference">
                                </div>
                                <div class="form-group">
                                    <label for="contents">Contents</label>
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
                                    @click="updatePost">Save Changes
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

  import CommentsComponent from './CommentsComponent.vue';

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
        showComments: false,
      };
    },
    mounted() {
      setTimeout(() => {
        this.postClone = this.post;
        this.$nextTick(() => {
          this.checkContentsHeight();
        })
      }, 1000);
    },
    components: {
      InputTag,
      CommentsComponent,
    },

    computed: {
      updatedAt() {
        return moment(this.postClone.updated_at).fromNow();
      }
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
      resetEditForm() {
        this.editForm.errors = [];
        this.editForm.reference = '';
        this.editForm.contents = '';
        this.editForm.tags = [];
        this.editForm.tagsArray = [];
      },
      editPost() {
        this.resetEditForm();
        this.editForm.id = this.postClone.id;
        this.editForm.reference = this.postClone.reference;
        this.editForm.contents = this.postClone.contents;
        this.postClone.tags.forEach(v => {
          this.editForm.tagsArray.push(v.name);
        });

        $("#editModal-"+this.postClone.id).modal('show');
      },
      updatePost() {
        axios.put(`/posts/${this.editForm.id}`, this.editForm).then(response => {
          this.postClone = response.data;
          this.resetEditForm();
          $("#editModal-"+this.postClone.id).modal('hide');
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.editForm.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.editForm.errors = ['something went wrong, please try again.'];
          }
        });
      },

      toggleComments() {
        if (!this.showComments) {
          this.showComments = !this.showComments;
        } else {
          this.showComments = !this.showComments;
        }
      },

      checkContentsHeight() {
        let postContentsDom = this.$refs.postContents;
        if (postContentsDom.clientHeight > 150) {
          postContentsDom.style.maxHeight = '150px';
          postContentsDom.lastElementChild.style.display = 'flex';
        }
      },

      showMore() {
        let postContentsDom = this.$refs.postContents;
        postContentsDom.style.maxHeight = 'none';
        postContentsDom.lastElementChild.style.display = 'none';
      }
    },
  }

</script>