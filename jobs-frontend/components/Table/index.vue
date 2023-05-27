<template>
  <div>
    <b-table
      v-bind:items="items"
      v-bind:fields="fields"
      v-bind:no-items-view="noItemsPage"
      hover
      sorter
    >
      <template v-for="(x, slotName) in $scopedSlots" #[slotName]="context">
        <slot v-bind:name="slotName" v-bind="context" />
      </template>
    </b-table>
  </div>
</template>

<script>
export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Tables',
  props: {
    items: {
      type: Array,
      default() {
        return []
      }
    },
    fields: {
      type: Array,
      default() {
        return []
      }
    },
    clickableRows: {
      type: Boolean,
      default: false
    },
    noItemsPage: {
      type: Object,
      default() {
        return {
          noResults: '絞り込みの結果がありません。',
          noItems: '既存の項目がありません。'
        }
      }
    },
    filterTable: {
      type: Object,
      default() {
        return { label: '絞り込み:', placeholder: '文字を入力...' }
      }
    }
  }
}
</script>
<style lang="scss">
.table {
  h2 {
    font-size: 20px !important;
    font-weight: 500 !important;
  }
}
</style>
