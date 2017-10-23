<template>
  <div :class="type" class="alert" role="alert" v-show="show">
    <strong>{{ title }}</strong> {{ body }}
  </div>
</template>

<script>
  export default {
    name: 'Flash',
    props: ['message'],
    data() {
      return {
        type: 'success',
        title: 'Success',
        body: this.message,
        show: false
      };
    },
    mounted () {
      this.$bus.$on('showNotification', (info) => {
        this.show = true;
        this.title = info.title;
        this.body = info.message;
        this.type = `alert-${info.type}`;

        setTimeout(() => {
          this.show = false;
        }, 5000);
      });
    }
  };
</script>

<style lang="css" scoped>
  div {
    position: fixed;
    top: 60px;
    right: 20px;
  }
</style>