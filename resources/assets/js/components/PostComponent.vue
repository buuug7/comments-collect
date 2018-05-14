<template>
    <div class="post bg-white p-3 mb-4">
        <p>Created by <a href="#">{{ post.user.name }}</a></p>
        <p>{{ post.contents }}</p>
        <p>Reference: {{ post.reference}}</p>
        <p>Last updated: {{ post.updated_at}}</p>
        <p class="mb-0">
            <a href="#" @click="collect(post.id)"
               class="btn btn-success">collect ({{ post.collected_users.length}})</a>
        </p>
    </div>
</template>

<script>
  export default {
    props: ['id'],
    data() {
      return {
        errors: [],
        post: {
          user: {},
          collected_users: []
        },
      };
    },
    mounted() {
      axios.get(`/posts/${this.id}`).then(response => {
        this.post = response.data;
        console.log(response.data);
      })
    },
    methods: {
      collect(id) {
        axios.post(`/posts/${id}/collect`).then(response => {
          console.log(response.data);
          this.post = response.data;
        }).catch(error => {
          console.log(error.response);
        });

      }
    }

  }

</script>