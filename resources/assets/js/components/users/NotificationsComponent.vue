<template>
    <div class="notifications">


        <div class="card text-center mb-5" v-for="(v,k) in notifications">
            <div class="card-header">{{ k }}</div>
            <div class="card-body">
                <div v-for="item in v">
                    {{ item.data }} <br>
                    {{ item.created_at }}
                </div>
            </div>
            <div class="card-footer">
                lol
            </div>
        </div>
    </div>
</template>


<script>
  export default {
    props: ['requestUrl'],
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
    }
  }
</script>