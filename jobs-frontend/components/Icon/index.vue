<template>
  <fa-icon v-bind:icon="fas['fa'+icon]" />
</template>

<script>
import { fas } from '@fortawesome/free-solid-svg-icons'

export default {
  name: 'Icon',
  props: {
    icon: {
      type: String,
      default() {
        return ''
      }
    },
  },
  computed: {
    fas() {
      return fas
    },
  },
}
</script>

<style>
</style>
