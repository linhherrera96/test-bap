<template>
  <div class="overflow-auto pagi-components" v-if="totalpage > 1">
    <b-pagination
      v-model="page"
      :total-rows="totalpage"
      :per-page="perPage"
      v-bind:align="align"
      first-text="First"
      prev-text="Back"
      next-text="Next"
      last-text="Last"
    ></b-pagination>
  </div>
</template>

<script>
export default {
  name: "SDPagination",
  props: {
    totalpage: {
      type: Number,
      default() {
        return 2;
      },
    },
    currentPage: {
      type: Number,
      default() {
        return 1;
      },
    },
    align: {
      type: String,
      default() {
        return "center";
      },
    },
  },
  data() {
    return {
      perPage: 1,
      page: 1,
    };
  },
  watch: {
    page() {
      this.$emit("update-page", this.page);
    },
    currentPage() {
      this.page = this.currentPage;
    },
  },
};
</script>

<style lang="scss">
.pagi-components {
  .page-item {
    font-size: 20px;
    .page-link {
      color: $gray-600;
      border: unset;
      background: unset;
      &:focus {
        box-shadow: unset;
      }
      @include screen(480) {
        font-size: 14px;
        padding: 8px;
      }
    }
    &.active {
      .page-link {
        background: unset;
        color: $orange;
        outline: unset;
        box-shadow: unset;
      }
    }
    &.disabled {
      .page-link {
        color: $gray-200;
      }
    }
  }
}
</style>