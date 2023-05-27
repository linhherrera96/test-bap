<template>
  <div class="fd-user-listjob">
    <div class="fd-user-listjob-card">
      <div class="fd-user-listjob-card-header">
        <div class="fd-user-listjob-card-select">
          <label for="filter-all">絞り込み:</label>
        </div>
      </div>
      <div class="fd-user-listjob-card-group">
        <div class="fd-user-listjob-card-filter">
          <input
            v-model="dataFilter.id"
            v-b-tooltip.hover
            title="ID"
            class="form-control"
            placeholder="ID"
            v-on:keyup.enter="search()"
          />
        </div>
        <div class="fd-user-listjob-card-filter">
          <b-form-input
            v-model="dataFilter.title"
            v-b-tooltip.hover
            title="タイトル"
            placeholder="タイトル"
            v-on:keyup.enter="search()"
          >
            ></b-form-input
          >
        </div>
        <div class="fd-user-listjob-card-filter">
          <b-form-input
            v-model="dataFilter.description"
            v-b-tooltip.hover
            title="説明"
            placeholder="説明"
            v-on:keyup.enter="search()"
          >
            ></b-form-input
          >
        </div>
        <div class="fd-user-listjob-card-filter">
          <b-form-select
            v-model="dataFilter.status_complete"
            v-b-tooltip.hover
            title="完了ステータス"
            v-bind:class="{
              'option-null': dataFilter.status_complete === '',
            }"
          >
            <b-form-select-option v-bind:value="''" style="color: #bebebe"
              >All</b-form-select-option
            >
            <b-form-select-option v-bind:value="1" style="color: #000"
              >Open</b-form-select-option
            >
            <b-form-select-option v-bind:value="0" style="color: #000"
              >Close</b-form-select-option
            >
          </b-form-select>
        </div>
      </div>
      <div class="custom-group">
        <div class="fd-user-listjob-card-group mb-custom-20">
          <div class="fd-user-listjob-card-filter">
            <FDButton class="search" v-on:click="search">
              <b-spinner
                v-if="loading"
                small
                label="Small Spinner"
                class="fd-loading"
              ></b-spinner>
              <Icon v-else icon="Search" />
            </FDButton>
          </div>
          <div class="fd-user-listjob-card-filter">
            <FDButton class="reset-search" v-on:click="resetSearch">
              <b-spinner
                v-if="loadingReset"
                small
                label="Small Spinner"
                class="fd-loading"
              ></b-spinner>
              <Icon v-else icon="SyncAlt" />
            </FDButton>
          </div>
        </div>
        <div class="fd-user-listjob-card-select">
          <label for="filter-all">ページごとに項目数:</label>
          <b-form-select
            v-model="selectPerPage"
            class="select-box"
            v-bind:options="options"
          ></b-form-select>
        </div>
      </div>
      <div class="fd-user-listjob-card-table">
        <b-table
          v-bind:items="dataTable"
          v-bind:fields="fields"
          hover
          responsive
          thead-class="header-custom"
          v-on:head-clicked="sort"
        >
          <template #head(id)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }} </span>
              <div class="d-flex flex-column">
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && !sortType,
                  }"
                >
                  <Icon icon="SortUp" />
                </div>
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && sortType,
                  }"
                >
                  <Icon icon="SortDown" />
                </div>
              </div>
            </div>
          </template>
          <template #head(title)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
              <div class="d-flex flex-column">
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && !sortType,
                  }"
                >
                  <Icon icon="SortUp" />
                </div>
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && sortType,
                  }"
                >
                  <Icon icon="SortDown" />
                </div>
              </div>
            </div>
          </template>
          <template #head(description)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
              <div class="d-flex flex-column">
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && !sortType,
                  }"
                >
                  <Icon icon="SortUp" />
                </div>
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && sortType,
                  }"
                >
                  <Icon icon="SortDown" />
                </div>
              </div>
            </div>
          </template>
          <template #head(status_complete)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
              <div class="d-flex flex-column">
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && !sortType,
                  }"
                >
                  <Icon icon="SortUp" />
                </div>
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && sortType,
                  }"
                >
                  <Icon icon="SortDown" />
                </div>
              </div>
            </div>
          </template>
          <template #cell(status_complete)="data">
            <h6 class="justify-content-center align-items-center"><b-badge variant="success" v-if="data.item.status_complete === '1'">
              Open
            </b-badge>
            <b-badge variant="secondary" v-else> Close </b-badge></h6>
          </template>
          <template #head(due_date)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
              <div class="d-flex flex-column">
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && !sortType,
                  }"
                >
                  <Icon icon="SortUp" />
                </div>
                <div
                  class="d-flex justify-content-center align-items-center sort-icon"
                  v-bind:class="{
                    active: sortCurrent === data.column && sortType,
                  }"
                >
                  <Icon icon="SortDown" />
                </div>
              </div>
            </div>
          </template>
          <template #cell(action)="{ item }">
            <div class="group-btn">
              <b-button
                v-b-tooltip.hover.top
                title="編集"
                variant="primary"
                class="btn-custom"
                square
                size="sm"
                v-on:click="toggleDetails(item.id)"
              >
                <Icon icon="Edit" />
              </b-button>
              <b-button
                v-b-tooltip.hover.top
                title="みなしログイン"
                variant="success"
                class="btn-custom"
                square
                size="sm"
                v-on:click="toggleMinashi(item.id)"
              >
                <Icon icon="SignInAlt" />
              </b-button>
              <b-button
                v-if="item.status === 'pending activation'"
                v-b-tooltip.hover.top
                title="本人確認"
                variant="info"
                class="btn-custom"
                square
                size="sm"
                v-on:click="
                  $router.push({ path: `/user/user/${item.id}/honnin` })
                "
              >
                <Icon icon="IdCard" />
              </b-button>
            </div>
          </template>
          <template #cell(status)="{ item }">
            <b-badge v-bind:variant="getBadge(item.status).status">{{
              getBadge(item.status).text
            }}</b-badge>
          </template>
          <template v-if="dataTable.length === 0" #top-row>
            <td v-bind:colspan="fields.length" class="message-no-item">
              Không có
            </td>
          </template>
        </b-table>
      </div>
      <div v-if="totalpage > 1">
        <FDPagination
          v-bind:totalpage="totalpage"
          v-bind:current-page="currentPage"
          align="center"
          v-on:update-page="updatePage"
        />
      </div>
    </div>
  </div>
</template>
 

<script>
import { mapActions, mapGetters } from "vuex";
import { tableFields } from "@/utils/table-fields";
import FDButton from "@/components/Button";
// import { Message } from '@/utils/message'

export default {
  auth: "user",
  components: {
    FDButton,
  },
  layout: "dashboard",
  data() {
    return {
      // messageTable: Message.DATA_TABLE,
      fields: tableFields.LIST_JOBS,
      dataTable: [
        {
          id: 1,
          title: "Tuyển Vuejs",
          description: "Lương upto 2000$",
          status_complete: "0",
          due_date: "30/5/2023",
        },
        {
          id: 2,
          title: "Tuyển ReactJS 2 năm kinh nghiệm",
          description: "Lương upto 1500$",
          status_complete: "1",
          due_date: "31/5/2023",
        },
        {
          id: 3,
          title: "Tuyển Python 3 năm kinh nghiệm, onsite tại Hà Nội",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "30/6/2023",
        },
        {
          id: 4,
          title: "Tuyển Junior Java Spring Boot",
          description: "Lương upto 1000$",
          status_complete: "1",
          due_date: "12/6/2023",
        },
        {
          id: 5,
          title: "Tuyển QA",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "30/6/2023",
        },
      ],
      person: null,
      options: [
        { value: 10, text: 10 },
        { value: 50, text: 50 },
        { value: 100, text: 100 },
      ],
      id: "",
      selectPerPage: 50,
      optionToast: {
        type: "error",
        position: "top-center",
        duration: 3000,
        keepOnHover: true,
        singleton: true,
        theme: "toasted-primary",
        iconPack: "material",
        fitToScreen: true,
      },
      dataFilter: {
        id: "",
        status_complete: "",
        description: "",
        title: "",
        due_date: "",
      },
      totalpage: 1,
      sortCurrent: null,
      sortType: false,
      currentPage: 1,
      loading: false,
      loadingReset: false,
    };
  },
  head: {
    title: "会員一覧",
  },
  computed: {
    ...mapGetters({
      listjob: "userUser/listjob",
      tokenUser: "userUser/tokenUser",
    }),
  },
  watch: {
    selectPerPage() {
      this.searchHandle();
    },
  },
  created() {},
  methods: {
    ...mapActions({
      getlistjob: "userUser/getlistjob",
      minashiLogin: "userUser/minashiLogin",
    }),

    sort(field) {
      if (this.sortCurrent !== field) {
        this.sortCurrent = field;
        this.sortType = false;
      } else {
        this.sortType = !this.sortType;
      }
      this.dataFilter = {
        ...this.dataFilter,
        sort: this.fields.findIndex((item) => item.key === this.sortCurrent),
        sort_type: this.sortType ? 2 : 1,
      };
      // this.getlistjob({
      //   data: {
      //     ...this.dataFilter,
      //     sort: this.fields.findIndex((item) => item.key === this.sortCurrent),
      //     sort_type: this.sortType ? 2 : 1,
      //   },
      //   perPage: this.selectPerPage,
      //   page: 1,
      // });
    },

    search() {
      this.loading = true;
      this.searchHandle();
    },

    searchHandle() {
      this.getlistjob({
        data: this.dataFilter,
        perPage: this.selectPerPage,
        page: 1,
      });
    },

    updatePage(page) {
      this.getlistjob({
        data: this.dataFilter,
        perPage: this.selectPerPage,
        page,
      });
    },

    getBadge(status) {
      switch (status) {
        case "actived":
          return {
            status: "success",
            text: "確認済み",
          };
        case "pending activation":
          return {
            status: "primary",
            text: "本人確認中",
          };
        default:
          return {
            status: "danger",
            text: "未確認",
          };
      }
    },

    resetSearch() {
      this.loadingReset = true;
      this.dataFilter = {
        id: "",
        name: "",
        nickname: "",
        email: "",
        address: "",
        tel: "",
        company_name: "",
        birth_year: "",
        sort: "",
        sort_type: "",
        class: "",
        identification_verify_status: "",
      };
      this.searchHandle();
    },

    toggleDetails(id) {
      this.$router.push(`/user/user/${id}/edit`);
    },

    toggleMinashi(id) {
      const data = {
        user_id: id.toString(),
      };
      this.minashiLogin(data);
    },
  },
};
</script>
<style lang="scss">
@import "~/assets/scss/jobs/list.scss";
</style>
