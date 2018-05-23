<template>

    <div class="comments">
        <hr v-if="postId">
        <h3 class="mb-4">Comments ({{ comments.length }})</h3>
        <!-- show created comment form if exists postId -->
        <div class="create-comment mb-4" v-if="postId">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                <ul class="mb-0">
                    <li v-for="error in createForm.errors">
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
                            @input="clearError"
                            v-model="createForm.contents">
                    </textarea>
                </div>
                <a href="javascript:"
                   class="btn btn-primary"
                   @click.prevent="addNewComment"
                >Add comment</a>
            </form>
        </div>
        <CommentComponent
                @replied="applied"
                v-for="comment in comments"
                :comment="comment"
                :key="comment.id">
        </CommentComponent>
        <div class="more-comments text-center">
            <a href="javascript:"
               @click.prevent="loadMoreComments"
               ref="moreComments"
               class="btn btn-outline-primary">
                Load more comments
            </a>
        </div>
    </div>

</template>

<script>
  import CommentComponent from './CommentComponent.vue';

  export default {
    props: ['postId', 'requestUrl'],
    data() {
      return {
        comments: [],
        nextCommentsUrl: null,
        createForm: {
          errors: [],
          contents: '',
          post_id: null,
          // user_id: null,
          target_user_id: null,
          target_comment_id: null,
        }
      };
    },
    components: {
      CommentComponent
    },
    mounted() {
      this.loadComments();
    },
    methods: {
      loadComments() {
        axios.get(this.requestUrl).then(response => {
          this.comments = response.data.data;
          this.nextCommentsUrl = response.data.next_page_url;
          console.log(response.data.data);
        });
      },
      loadMoreComments() {
        let moreCommentsBtn = this.$refs.moreComments;
        moreCommentsBtn.textContent = 'loading...';
        if (!this.nextCommentsUrl) {
          moreCommentsBtn.classList.add('disabled');
          moreCommentsBtn.setAttribute('disabled', 'disabled');
          moreCommentsBtn.textContent = 'No more';
        }
        axios.get(this.nextCommentsUrl).then(response => {
          this.comments = this.comments.concat(response.data.data);
          if (response.data.next_page_url) {
            this.nextCommentsUrl = response.data.next_page_url;
            moreCommentsBtn.textContent = 'Load more comments';
          } else {
            this.nextCommentsUrl = null;
            moreCommentsBtn.classList.add('disabled');
            moreCommentsBtn.setAttribute('disabled', 'disabled');
            moreCommentsBtn.textContent = 'No more';
          }
        });
      },

      clearError() {
        this.createForm.errors = [];
      },

      addNewComment() {
        this.createForm.post_id = this.postId;
        axios.post('/comments', this.createForm).then(response => {
          this.createForm.contents = '';
          this.createForm.post_id = null;
          //this.createForm.user_id = null;
          this.createForm.target_user_id = null;
          this.createForm.target_comment_id = null;
          this.comments.unshift(response.data);
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.createForm.errors = _.flatten(_.toArray(error.response.data.errors));
            this.createForm.errors.push(error.response.data.message);
          } else {
            this.createForm.errors = ['something went wrong, please try again.'];
          }
        });
      },
      applied(comment) {
        console.log('applied!');
        this.comments.unshift(comment);
      }

    }
  }
</script>