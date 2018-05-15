<template>
    <div class="post-create bg-white p-3">
        <h2>Create Post</h2>
        <!-- Form Errors -->
        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
            <ul class="mb-0">
                <li v-for="error in createForm.errors">
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
                       v-model="createForm.reference">
            </div>
            <div class="form-group">
                <label for="contents">contents</label>
                <textarea
                        name="contents"
                        id="contents"
                        class="form-control"
                        v-model="createForm.contents"
                        rows="4">
                                </textarea>
            </div>

            <div class="form-group">
                <label>Tags</label>
                <input-tag
                        placeholder="Add tags to your post and make it more discoverable."
                        :tags.sync="createForm.tagsArray">
                </input-tag>
            </div>

            <div class="form-group">
                <a href="#"
                   @click.prevent="create"
                   class="btn btn-primary">Submit</a>
            </div>
        </form>
    </div>
</template>

<script>
  import InputTag from 'vue-input-tag';

  export default {
    data() {
      return {
        createForm: {
          reference: '',
          contents: '',
          tagsArray: [],
          errors: [],
        }
      };
    },
    methods: {
      create() {
        axios.post('/posts', this.createForm).then(response => {
          console.log(response);
          this.createForm.reference = '';
          this.createForm.contents = '';
          this.createForm.tagsArray = [];
          this.createForm.errors = [];
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.createForm.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.createForm.errors = ['something went wrong, please try again.'];
          }
        });
      }
    },
    components: {
      InputTag
    }
  }
</script>