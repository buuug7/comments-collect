<template>
    <div class="notifications">

        <div class="list-group mb-5" v-for="(v,k) in notifications">
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ k }}</h5>
                </div>

                <div class="mb-4" v-for="item in v">
                    <p class="mb-0">{{ item.data }}</p>
                    <small>{{ item.created_at }}</small>
                </div>
            </a>
        </div>
    </div>
</template>


<script>

  export default {
    props: ['requestUrl'],
    components: {

    },
    data() {

      return {
        notifications: [],
      };
    },
    mounted() {
      axios.get(this.requestUrl).then(response => {
        this.notifications = response.data;
        console.log(response.data);
      });
    },
    methods: {

    }
  }
</script>