<template>
    <div class="post-create">
        <!-- Errors -->
        <div class="alert alert-danger" v-if="errors.length > 0">
            <ul class="mb-0">
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>
        <!-- Message -->
        <div class="alert alert-success" v-if="message">
            <p class="mb-0">{{ message }}</p>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="reference">Reference</label>
                <input type="text"
                       name="reference"
                       id="reference"
                       class="form-control"
                       v-model="createForm.reference">
            </div>
            <div class="form-group">
                <label for="contents">Contents</label>
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
        errors: [],
        message: '',
        createForm: {
          reference: '',
          contents: '',
          tagsArray: [],
        }
      };
    },
    methods: {
      create() {
        axios.post('/posts', this.createForm).then(response => {
          console.log(response.data);
          this.message = response.data.message;
          this.clear();
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.errors = ['something went wrong, please try again.'];
          }
        });
      },
      clear() {
        this.createForm.reference = '';
        this.createForm.contents = '';
        this.createForm.tagsArray = [];
        this.errors = [];
      }
    },
    components: {
      InputTag
    }
  }
</script>