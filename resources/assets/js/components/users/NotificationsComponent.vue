<template>
    <div class="notifications">

        <div class="card mb-5" v-for="(v,k) in notifications">
            <div class="card-header text-center">
                {{ k }}
            </div>
            <div class="card-body">
                <NotificationComponent v-for="notification in v"
                                       :notification="notification"
                                       :key="notification.id">
                </NotificationComponent>
            </div>
        </div>
    </div>
</template>


<script>
  import NotificationComponent from './NotificationComponent';

  export default {
    props: ['requestUrl'],
    components: {
      NotificationComponent,
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

  }
</script>