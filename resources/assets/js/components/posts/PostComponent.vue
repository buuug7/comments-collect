<template>
    <div v-if="postClone">
        <div class="post bg-white p-3 mb-4">
            <p>Contributed by <a href="#">{{ postClone.user.name }}</a></p>
            <p>{{ postClone.contents }}</p>
            <p>Reference: {{ postClone.reference}}</p>
            <p>Last updated: {{ postClone.updated_at }}</p>
            <p>
                Tags: <br/>
                <a href="#"
                   v-for="tag in postClone.tags"
                   class="badge badge-primary mr-1">
                    {{ tag.name }}
                </a>
            </p>
            <p class="mb-0">
                <a href="#"
                   v-if="postClone.has_collected_by_request_user"
                   @click.prevent="collect"
                   class="btn btn-outline-primary mb-2">
                    Cancel Collected ({{ postClone.collected_users_count }})
                </a>
                <a href="#"
                   v-else
                   @click.prevent="collect"
                   class="btn btn-outline-primary mb-2">
                    Collect ({{ postClone.collected_users_count }})
                </a>
                <a href="#"
                   @click.prevent="comment"
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

            </p>
            <!-- display errors -->
            <div v-if="errors.length>0" class="alert alert-warning m-4">
                <ul class="mb-0">
                    <li v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
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
</template>

<script>
  import InputTag from 'vue-input-tag';

  export default {
    props: ['post'],
    data() {
      return {
        errors: [],
        postClone: this.post,
        editForm: {
          errors: [],
          reference: '',
          contents: '',
          tags: [],
          tagsArray: [],
        },
      };
    },
    /*mounted() {
      axios.get(`/posts/${this.id}`).then(response => {
        this.post = response.data;
      });
    },*/
    methods: {
      comment() {
      },
      collect() {
        axios.post(`/posts/${this.post.id}/collect`).then(response => {
          this.postClone = response.data;
        }).catch(error => {
          this.errors = [error.response.data.message, 'Maybe you need login first.'];
        });
      },
      deletePost() {
        let disCollect = confirm('do you really want to delete it?');
        if (!disCollect) {
          return;
        }
        axios.delete(`/posts/${this.post.id}`).then(response => {
          this.postClone = null;
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
      }
    },
    components: {
      InputTag,
    },
  }

</script>