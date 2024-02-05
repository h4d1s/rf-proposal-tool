<template>
  <slot
    name="first-row"
    :onToggle="onToggle"
    :isActive="show"
  />

  <Transition name="slide">
    <div v-show="show">
      <slot name="second-row" />
    </div>
  </Transition>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      show: false,
    }
  },
  methods: {
    onToggle() {
      this.show = !this.show;
    }
  },
});
</script>

<style lang="scss" scoped>
  .slide-enter-active,
  .slide-leave-active {
    transition: all .3s ease-out;
    max-height: 100px;
  }
  .slide-enter-from,
  .slide-leave-to {
    max-height: 0;
    overflow: hidden;
    transition: all .3s ease-in;
  }
</style>
