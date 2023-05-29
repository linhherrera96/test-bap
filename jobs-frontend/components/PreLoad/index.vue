<template>
  <div v-if="preload" class="preload">
    <div class="snippet" data-title=".dot-flashing">
      <div class="stage">
        <div class="dot-flashing"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Preload",
  props: {
    preload: {
      type: Boolean,
      default() {
        return false;
      },
    },
  },
};
</script>

<style lang="scss" scoped>
.preload {
  position: fixed;
  justify-content: center;
  display: flex;
  align-items: center;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  background: #fff;
  .dot-flashing {
    position: relative;
    width: 10px;
    height: 10px;
    border-radius: 5px;
    background-color: #fd8857;
    color: #fd8857;
    animation: dotFlashing 1s infinite linear alternate;
    animation-delay: 0.5s;
    &::after {
      content: "";
      display: inline-block;
      position: absolute;
      top: 0;
      left: 15px;
      width: 10px;
      height: 10px;
      border-radius: 5px;
      background-color: #fd8857;
      color: #fd8857;
      animation: dotFlashing 1s infinite alternate;
      animation-delay: 1s;
    }
    &::before {
      content: "";
      display: inline-block;
      position: absolute;
      top: 0;
      left: -15px;
      width: 10px;
      height: 10px;
      border-radius: 5px;
      background-color: #fd8857;
      color: #fd8857;
      animation: dotFlashing 1s infinite alternate;
      animation-delay: 0s;
    }
  }

  @keyframes dotFlashing {
    0% {
      background-color: #fd8857;
    }
    50%,
    100% {
      background-color: #e1ffe1;
    }
  }
}
</style>
