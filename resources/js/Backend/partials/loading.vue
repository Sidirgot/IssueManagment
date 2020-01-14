<template>
    <div class="text-center" :key="loading">
        <div class="loader" v-if="loading"></div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'Loading',

    computed: {
        ...mapGetters(['loading'])
    }
}
</script>

<style scoped>
.loader {
  display: inline-block;
  width: 80px;
  height: 80px;
}
.loader:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid #00b1b3;
  border-color: #00b1b3 transparent #00b1b3 transparent;
  animation: loaders 1.2s linear infinite;
}
@keyframes loaders {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>