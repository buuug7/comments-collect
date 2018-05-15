<template>
    <div class="post bg-white p-3 mb-4" v-if="postClone">
        <p>Created by <a href="#">{{ postClone.user.name }}</a></p>
        <p>{{ postClone.contents }}</p>
        <p>Reference: {{ postClone.reference}}</p>
        <p>Last updated: {{ postClone.updated_at }}</p>
        <p class="mb-0">
            <a href="javascript:"
               v-if="postClone.has_collected_by_request_user"
               @click="collect"
               class="btn btn-success">
                Cancel Collected ({{ postClone.collected_users.length}})
            </a>
            <a href="javascript:"
               v-else
               @click="collect"
               class="btn btn-primary">
                Collect ({{ postClone.collected_users.length}})
            </a>
            <a href="javascript:"
               v-if="postClone.has_owned_by_request_user"
               @click="deletePost"
               class="btn btn-danger">delete</a>
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
</template>

<script>
  export default {
    props: ['post'],
    data() {
      return {
        errors: [],
        postClone: this.post,
      };
    },
    /*mounted() {
      axios.get(`/posts/${this.id}`).then(response => {
        this.post = response.data;
      });
    },*/
    methods: {
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
      }
    }
  }

</script>