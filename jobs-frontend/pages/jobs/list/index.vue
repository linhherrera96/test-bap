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
        <div class="fd-user-listjob-card-filter d-flex">
          <FDButton class="search mr-3" v-on:click="search">
            <b-spinner
              v-if="loading"
              small
              label="Small Spinner"
              class="fd-loading"
            ></b-spinner>
            <Icon v-else icon="Search" />
          </FDButton>
          <FDButton class="reset-search btn" v-on:click="resetSearch">
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
      <div class="custom-group">
        <div class="fd-user-listjob-card-group mb-custom-select">
          <div class="fd-user-listjob-card-select">
            <label for="filter-all">ページごとに項目数:</label>
            <b-form-select
              v-model="selectPerPage"
              class="select-box"
              v-bind:options="options"
            ></b-form-select>
          </div>
        </div>
        <div class="fd-user-listjob-card-group mb-custom-add">
          <div class="fd-user-listjob-card-filter">
            <FDButton v-on:click="addJob">
              <Icon icon="Add" />
            </FDButton>
          </div>
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
            </div>
          </template>
          <template #head(title)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
            </div>
          </template>
          <template #head(description)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
            </div>
          </template>
          <template #head(status_complete)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
            </div>
          </template>
          <template #cell(status_complete)="data">
            <h6 class="justify-content-center align-items-center">
              <b-badge
                variant="success"
                v-if="data.item.status_complete === '1'"
              >
                Open
              </b-badge>
              <b-badge variant="secondary" v-else> Close </b-badge>
            </h6>
          </template>
          <template #head(due_date)="data">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ data.label }}</span>
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
                v-on:click="editJob(item)"
              >
                <Icon icon="Edit" />
              </b-button>
              <b-button
                v-b-tooltip.hover.top
                title="削除"
                variant="danger"
                class="btn-custom"
                square
                size="sm"
                v-on:click="deleteJobModal(item.id)"
              >
                <Icon icon="Trash" />
              </b-button>
            </div>
          </template>
          <template v-if="dataTable.length === 0" #top-row>
            <td v-bind:colspan="fields.length" class="message-no-item">
              {{ MESSAGE.DATA_TABLE.NO_ITEM }}
            </td>
          </template>
        </b-table>
      </div>
      <b-modal
        id="modal-tag"
        ref="modal-tag"
        hide-header
        hide-footer
        v-model="showModalAddJob"
      >
        <div class="content-modal-detail">
          <div class="padding">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <strong>TODO</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="title">タイトル</label>
                          <div class="relative validate-form">
                            <input
                              class="form-control"
                              v-model.trim="$v.dataJob.title.$model"
                              placeholder="タイトルを入力してください"
                              v-bind:class="{
                                'is-invalid': $v.dataJob.title.$error,
                              }"
                            />
                            <div
                              v-if="$v.dataJob.title.$error"
                              class="error-text"
                            >
                              <p>{{ MESSAGE.JOBS.TITLE_REQUIRED }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="description">説明</label>
                          <div class="relative validate-form">
                            <b-form-textarea
                              class="form-control"
                              rows="2"
                              v-model.trim="$v.dataJob.description.$model"
                              placeholder="説明を入力してください"
                              v-bind:class="{
                                'is-invalid': $v.dataJob.description.$error,
                              }"
                            ></b-form-textarea>
                            <div
                              v-if="$v.dataJob.description.$error"
                              class="error-text"
                            >
                              <p>{{ MESSAGE.JOBS.DESCRIPTION_REQUIRED }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="status_complete">完了ステータス</label>
                          <b-form-select
                            v-model="$v.dataJob.status_complete.$model"
                            v-b-tooltip.hover
                            title="完了ステータス"
                          >
                            <b-form-select-option
                              v-bind:value="1"
                              style="color: #000"
                              >Open</b-form-select-option
                            >
                            <b-form-select-option
                              v-bind:value="0"
                              style="color: #000"
                              >Close</b-form-select-option
                            >
                          </b-form-select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="due_date">期日</label>
                          <div class="relative validate-form">
                            <b-form-datepicker
                              id="datepicker-invalid"
                              v-model.trim="$v.dataJob.due_date.$model"
                              class="mb-2"
                              locale="ja"
                              format="yyyy-MM-dd"
                              autoApply
                              closeOnScroll
                              v-bind:class="{
                                'is-invalid': $v.dataJob.due_date.$error,
                              }"
                            ></b-form-datepicker>
                            <div
                              v-if="$v.dataJob.due_date.$error"
                              class="error-text"
                            >
                              <p>{{ MESSAGE.JOBS.DUE_DATE_REQUIRED }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button
                      class="btn btn-sm btn-success float-right"
                      v-on:click="createJob"
                      v-if="!editFlag"
                    >
                      追加
                    </button>
                    <button
                      class="btn btn-sm btn-success float-right"
                      v-on:click="updateJob"
                      v-else
                    >
                      更新
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      v-on:click="closeModal"
                    >
                      リセット
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </b-modal>
      <b-modal ref="my-modal" hide-footer title="削除確認">
        <div class="d-block text-center mb-2">
          <h6>削除すると、元に戻せませんがよろしいですか？</h6>
        </div>
        <div class="d-flex justify-content-end">
          <b-button
            class="mt-2 w-25 fd-font-14"
            variant="light"
            block
            v-on:click="hideModalDeleteJob"
            >キャンセル</b-button
          >
          <b-button
            class="mt-2 w-25 ml-2"
            variant="danger"
            block
            v-on:click="deleteJob()"
          >
            <b-spinner v-if="loading" small></b-spinner>
            <span class="ml-2 fd-font-14">削除</span>
          </b-button>
        </div>
      </b-modal>

      <div v-if="totalRows > 1">
        <FDPagination
          class="wrap-list-pagination"
          v-bind:totalpage="totalRows"
          align="center"
          v-bind:current-page="currentPage"
          v-bind:per-page="selectPerPage"
          v-on:update-page="updatePage"
        />
      </div>
    </div>
  </div>
</template>
 

<script>
import { mapActions, mapGetters } from "vuex";
import { maxLength, required } from "vuelidate/lib/validators";
import { tableFields } from "@/utils/table-fields";
import FDButton from "@/components/Button";
import FDPagination from "@/components/Pagination";
import { Message } from "@/utils/message";

export default {
  auth: "user",
  components: {
    FDButton,
    FDPagination,
  },
  layout: "dashboard",
  data() {
    return {
      // messageTable: Message.DATA_TABLE,
      fields: tableFields.LIST_JOBS,
      MESSAGE: Message,
      dataTable: [
        {
          id: 1,
          title: "Tuyển Vuejs",
          description: "Lương upto 2000$",
          status_complete: "0",
          due_date: "2023-05-25",
        },
        {
          id: 2,
          title: "Tuyển ReactJS 2 năm kinh nghiệm",
          description: "Lương upto 1500$",
          status_complete: "1",
          due_date: "2023-06-12",
        },
        {
          id: 3,
          title: "Tuyển Python 3 năm kinh nghiệm, onsite tại Hà Nội",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "2023-06-30",
        },
        {
          id: 4,
          title: "Tuyển Junior Java Spring Boot",
          description: "Lương upto 1000$",
          status_complete: "1",
          due_date: "2023-06-04",
        },
        {
          id: 5,
          title: "Tuyển QA",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "2023-05-31",
        },
        {
          id: 1,
          title: "Tuyển Vuejs",
          description: "Lương upto 2000$",
          status_complete: "0",
          due_date: "2023-05-25",
        },
        {
          id: 2,
          title: "Tuyển ReactJS 2 năm kinh nghiệm",
          description: "Lương upto 1500$",
          status_complete: "1",
          due_date: "2023-06-12",
        },
        {
          id: 3,
          title: "Tuyển Python 3 năm kinh nghiệm, onsite tại Hà Nội",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "2023-06-30",
        },
        {
          id: 4,
          title: "Tuyển Junior Java Spring Boot",
          description: "Lương upto 1000$",
          status_complete: "1",
          due_date: "2023-06-04",
        },
        {
          id: 5,
          title: "Tuyển QA",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "2023-05-31",
        },
        {
          id: 1,
          title: "Tuyển Vuejs",
          description: "Lương upto 2000$",
          status_complete: "0",
          due_date: "2023-05-25",
        },
        {
          id: 2,
          title: "Tuyển ReactJS 2 năm kinh nghiệm",
          description: "Lương upto 1500$",
          status_complete: "1",
          due_date: "2023-06-12",
        },
        {
          id: 3,
          title: "Tuyển Python 3 năm kinh nghiệm, onsite tại Hà Nội",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "2023-06-30",
        },
        {
          id: 4,
          title: "Tuyển Junior Java Spring Boot",
          description: "Lương upto 1000$",
          status_complete: "1",
          due_date: "2023-06-04",
        },
        {
          id: 5,
          title: "Tuyển QA",
          description: "Lương upto 2000$",
          status_complete: "1",
          due_date: "2023-05-31",
        },
      ],
      person: null,
      options: [
        { value: 10, text: 10 },
        { value: 50, text: 50 },
        { value: 100, text: 100 },
      ],
      id: "",
      optionToast: {
        type: "error",
        position: "top-right",
        duration: 3000,
        keepOnHover: true,
        singleton: true,
        theme: "toasted-primary",
        iconPack: "material",
        fitToScreen: true,
      },
      dataJob: {
        id: "",
        status_complete: "1",
        description: "",
        title: "",
        due_date: new Date(),
      },
      dataFilter: {
        id: "",
        status_complete: "",
        description: "",
        title: "",
        due_date: new Date(),
      },
      totalpage: 1,
      sortCurrent: null,
      sortType: false,
      currentPage: 1,
      loading: false,
      loadingReset: false,
      showModalAddJob: false,
      editFlag: false,
      showModalDeleteJob: false,
      totalRows: 1,
      disabledButton: true,
      pageSize: 10,
      selectPerPage: 10,
    };
  },
  validations: {
    dataJob: {
      title: {
        required,
        maxLength: maxLength(100),
      },
      description: {
        required,
        maxLength: maxLength(100),
      },
      due_date: {
        required,
      },
      status_complete: {
        required,
      },
    },
  },

  head: {
    title: "ToDo",
  },
  computed: {
    ...mapGetters({
      listjob: "userUser/listjob",
      tokenUser: "userUser/tokenUser",
    }),
  },
  watch: {
    selectPerPage() {
      this.pageSize = this.selectPerPage;
      this.totalRows = Math.ceil(this.dataTable.length / this.selectPerPage);
      console.log(this.dataTable);
      this.currentPage = 1;
    },
  },
  created() {
    this.totalRows = Math.ceil(this.dataTable.length / this.selectPerPage);
  },
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
      this.dataJob = {
        ...this.dataJob,
        sort: this.fields.findIndex((item) => item.key === this.sortCurrent),
        sort_type: this.sortType ? 2 : 1,
      };
      // this.getlistjob({
      //   data: {
      //     ...this.dataJob,
      //     sort: this.fields.findIndex((item) => item.key === this.sortCurrent),
      //     sort_type: this.sortType ? 2 : 1,
      //   },
      //   perPage: this.selectPerPage,
      //   page: 1,
      // });
    },
    addJob() {
      this.dataJob = {
        id: "",
        status_complete: "1",
        description: "",
        title: "",
        due_date: new Date(),
      };
      this.$v.$reset();
      this.showModalAddJob = true;
      this.editFlag = false;
    },

    editJob(item) {
      this.editFlag = true;
      this.showModalAddJob = true;
      this.dataJob = {
        id: item.id,
        status_complete: item.status_complete,
        description: item.description,
        title: item.title,
        due_date: item.due_date,
      };
    },

    deleteJobModal() {
      this.$refs["my-modal"].show();
    },

    hideModalDeleteJob() {
      this.$refs["my-modal"].hide();
    },

    search() {
      this.loading = true;
      this.searchHandle();
    },

    deleteJob() {
      this.$refs["my-modal"].hide();
      this.$toasted.success(
        this.MESSAGE.JOBS.DELETE_JOB_SUCCESS,
        this.optionToast
      );
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
        data: this.dataJob,
        perPage: this.selectPerPage,
        page,
      });
    },

    createJob() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      if (!this.$v.$error) {
        this.showModalAddJob = false;
        this.$toasted.success(
          this.MESSAGE.JOBS.ADD_JOB_SUCCESS,
          this.optionToast
        );
      }
    },
    updateJob() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      if (!this.$v.$error) {
        console.log(this.dataJob);
        this.showModalAddJob = false;
        this.$toasted.success(
          this.MESSAGE.JOBS.UPDATE_JOB_SUCCESS,
          this.optionToast
        );
      }
    },
    closeModal() {
      this.dataJob = {
        id: "",
        status_complete: "1",
        description: "",
        title: "",
        due_date: new Date(),
      };
      this.$v.$reset();
      this.showModalAddJob = false;
    },
    resetSearch() {
      // this.loadingReset = true;
      this.dataFilter = {
        id: "",
        status_complete: "",
        description: "",
        title: "",
        due_date: new Date(),
      };
      this.searchHandle();
    },
  },
};
</script>
<style lang="scss">
@import "~/assets/scss/jobs/list.scss";
</style>
