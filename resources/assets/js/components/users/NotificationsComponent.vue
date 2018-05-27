<template>
    <div class="notifications">
        <div v-for="notification in notifications">
            <CommentRepliedNotificationComponent
                    v-if="notification.type ==='App\\Notifications\\CommentRepliedNotify'"
                    :notification="notification"
                    :key="notification.id">
            </CommentRepliedNotificationComponent>

            <div v-else>
                TODO
            </div>
        </div>

        <div class="load-more d-flex justify-content-center">
            <a href="javascript:"
               ref="moreButton"
               @click.prevent="loadMore"
               class="btn btn-outline-primary">
                Load more
            </a>
        </div>
    </div>
</template>


<script>
  import CommentRepliedNotificationComponent from './CommentRepliedNotificationComponent.vue';

  export default {
    props: ['requestUrl','requestMethod'],
    components: {
      CommentRepliedNotificationComponent,
    },
    data() {
      return {
        notifications: [],
        nextPageUrl: null,
      };
    },
    mounted() {
      axios[this.requestMethod](this.requestUrl).then(response => {
        this.notifications = response.data.data;
        this.nextPageUrl = response.data.next_page_url;
      });
    },

    methods: {
      loadMore() {
        let moreButton = this.$refs.moreButton;
        moreButton.textContent = 'Loading...';
        if (!this.nextPageUrl) {
          this.disabledButton(moreButton);
          return;
        }
        axios[this.requestMethod](this.nextPageUrl).then(response => {
          this.notifications = this.notifications.concat(response.data.data);
          if (response.data.next_page_url) {
            this.nextPageUrl = response.data.next_page_url;
            moreButton.textContent = 'Load more';
          } else {
            this.nextPageUrl = null;
            this.disabledButton(moreButton);
          }
        });
      },
      disabledButton(moreButton) {
        moreButton.classList.add('disabled');
        moreButton.setAttribute('disabled', 'disabled');
        moreButton.textContent = 'No more';
      }
    }

  }
</script>