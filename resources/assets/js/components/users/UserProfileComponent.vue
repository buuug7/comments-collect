<template>
    <div class="user-profile">
        <div class="alert alert-danger" v-if="errors.length>0">
            <ul class="mb-0">
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>

        <div class="alert alert-success" v-if="message">
            <p class="mb-0">{{ message }}</p>
        </div>

        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"
                       v-on:focus="clear"
                       class="form-control"
                       id="name"
                       v-model="userForm.name">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text"
                       v-on:focus="clear"
                       class="form-control"
                       id="email"
                       v-model="userForm.email" disabled>
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="text"
                       v-on:focus="clear"
                       class="form-control"
                       id="website"
                       v-model="userForm.profile.website">
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea
                        v-on:focus="clear"
                        class="form-control"
                        id="bio"
                        v-model="userForm.profile.bio"
                ></textarea>
            </div>

            <button @click.prevent="update" class="btn btn-primary">update</button>
        </form>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        errors: [],
        message: '',

        userForm: {
          name: '',
          email: '',
          profile: {
            website: '',
            bio: '',
          },
        },
      };
    },
    mounted() {
      this.getUser();
    },
    methods: {
      getUser() {
        axios.get('/users/profile')
          .then(response => {
            this.userForm = response.data;
          })
      },
      update() {
        this.clear();
        axios.put('/users/profile', this.userForm)
          .then(response => {
            this.userForm = response.data.user;
            this.message = response.data.message;
          })
          .catch(error => {
            if (typeof error.response.data === 'object') {
              this.errors = _.flatten(_.toArray(error.response.data.errors));
            } else {
              this.errors = ['something went wrong, please try again.'];
            }
          })
      },
      clear() {
        this.message = '';
        this.errors = [];
      }
    },
  }
</script>