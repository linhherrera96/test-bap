<template>
  <b-button
    v-bind:color="color"
    v-bind:size="size"
    class="fd-btn"
    v-bind:disabled="isLoading || disabled"
    v-on:click="clickBtn"
  >
    <!--  -->
    <b-spinner v-if="isLoading" variant="light" class="fd-loading mr-2" v-bind:class="spinnerClass"></b-spinner>
    <slot />
  </b-button>
</template>

<script>
export default {
  name: 'Button',
  props: {
    color: {
      type: String,
      default() {
        return 'secondary'
      }
    },
    size: {
      type: String,
      default() {
        return ''
      }
    },
    isLoading: {
      type: Boolean,
      default() {
        return false
      }
    },
    disabled: {
      type: Boolean,
      default() {
        return false
      }
    },
    spinnerClass: {
      type: String,
      default() {
        return ''
      }
    }
  },
  methods: {
    clickBtn() {
      this.$emit('click')
    }
  }
}
</script>
<style lang="scss">
.fd-btn {
  border-radius: 10px;
  border: unset;
  .fd-loading {
    width: 16px;
    height: 16px;
  }
}
</style>
