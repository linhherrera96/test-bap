<template>
  <div class="wrap-admin">
    <div class="wrap-admin-main">
      <!-- header -->
      <div class="wrap-admin-header">
        <span class="wrap-admin-header-name">User1</span>
        <div class="wrap-admin-header-icon" v-on:click="setShowSettings">
          <img src="~/assets/images/avatar.png" alt />
        </div>
        <div v-show="showSetting" class="wrap-admin-header-setting">
          <div class="wrap-admin-header-setting-logout">
            <button v-on:click="logoutBtn">Logout</button>
          </div>
        </div>
      </div>
      <!-- content -->
      <div class="wrap-admin-content">
        <div
          class="wrap-admin-content-sidebar"
          v-bind:class="{ showsidebar: sidebar }"
        >
          <div class="wrap-admin-content-sidebar-header">
            <span
              class="w-100 h-100 d-flex align-items-center justify-content-center mt-4"
            >
              <b-img
                src="https://bap-software.net/wp-content/uploads/2020/03/logo-bap-software-1.png"
                class="w-75"
                alt="Responsive image"
              ></b-img>
            </span>
            <button class="_btnShowSidebar" v-on:click="toggleSidebar">
              <Icon icon="Bars" />
            </button>
          </div>
          <ul class="wrap-admin-content-sidebar-content">
            <li class="sidebar-content-item">
              <NuxtLink to="/jobs/list">
                <div class="sidebar-content-item-icon">
                  <Icon icon="FileText" />
                </div>
                ToDo
              </NuxtLink>
            </li>
          </ul>
          <div class="wrap-admin-content-sidebar-footer">
            <button v-on:click="toggleSidebar">
              <Icon class="sidebar-footer-icon" icon="ChevronLeft" />
            </button>
          </div>
        </div>
        <main
          class="wrap-admin-content-mainNuxt"
          v-bind:class="{ _fullWidthMainNuxt: !sidebar }"
        >
          <Nuxt />
        </main>
      </div>

      <!-- footter -->
      <section class="wrap-admin-footer">
        <div class="copyright">Copyright© 2023 BAP</div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  auth: false,
  data() {
    return {
      showSetting: false,
      sidebar: true,
    };
  },
  created() {
    if (window.innerWidth <= 1200) {
      this.sidebar = false;
    } else {
      this.sidebar = true;
    }
    window.addEventListener("resize", () => {
      if (window.innerWidth <= 1200) {
        this.sidebar = false;
      } else {
        this.sidebar = true;
      }
    });
  },
  methods: {
    setShowSettings() {
      this.showSetting = !this.showSetting;
    },
    logoutBtn() {},
    toggleSidebar() {
      this.sidebar = !this.sidebar;
    },
  },
};
</script>
<style lang="scss" scoped>
.wrap-admin {
  width: 100%;
  display: flex;
  justify-content: space-between;
  flex-direction: row;
  &-main {
    width: 100%;
    font-size: 14px;
  }
  &-header {
    width: 100%;
    height: 64px;
    display: flex;
    align-items: center;
    background-color: #423931;
    justify-content: flex-end;
    position: fixed;
    top: 0;
    z-index: 999;
    &-name {
      margin-right: 5px;
      color: #fff;
    }
    &-icon {
      width: 40px;
      height: 40px;
      overflow: hidden;
      border-radius: 50%;
      margin-right: 1rem;
      position: relative;
      cursor: pointer;
      background-color: #b8b8b8;
      img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }
    &-setting {
      background-color: #423931;
      position: absolute;
      top: 72px;
      padding: 10px 30px;
      right: 4px;
      border-radius: 5px;
      border: 1px solid #fff;
      box-shadow: 1px 1px 4px 1px #717171;
      color: #fff;
      &::after {
        content: "";
        width: 0;
        height: 0;
        border-left: 12px solid transparent;
        border-right: 13px solid transparent;
        position: absolute;
        border-top: 11px solid #423931;
        top: -11px;
        right: 33px;
        transform: rotate(180deg);
      }
      &-logout {
        background-color: transparent;
        width: 100%;
        button {
          width: 100%;
          background-color: transparent;
          color: #fff;
          border: none;
        }
      }
    }
  }
  &-content {
    min-height: 100vh;
    display: flex;
    flex-direction: row;
    &-sidebar {
      width: 0px;
      background-color: #fff;
      transform: translateX(-270px);
      transition: all 0.2s linear;
      height: 100%;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      bottom: 0;
      &-header {
        width: 270px;
        position: relative;
        height: 64px;
        display: flex;
        align-items: center;
        @include screen(767) {
          width: 300px;
        }
        ._logo {
          margin-left: 1rem;
          transition: all 0.2s linear;
        }
        ._btnShowSidebar {
          color: #fff;
          font-size: 25px;
          background-color: transparent;
          border: none;
          position: absolute;
          right: -50px;
          top: 16px;
          transition: all 0.2s linear;
          @include screen(767) {
            right: -15px;
          }
        }
      }
      &-content {
        height: calc(100% - 130px);
        padding-top: 20px;
        padding-left: 0;
        .sidebar-content-item {
          background-color: transparent;
          padding: 10px;
          margin: 10px;
          display: flex;
          align-items: center;
          justify-content: flex-start;
          padding: 0;
          a {
            color: #423931;
            z-index: 1;
            font-size: 16px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            font-weight: 500;
            text-decoration: none;

            &:hover {
              background-color: #423931;
              opacity: 0.9;
              color: #fff;
            }
          }
          &-icon {
            width: 25px;
            height: 25px;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
          }
        }
      }
      &-footer {
        width: 100%;
        background-color: #d9d9d9;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        button {
          width: 100%;
          height: 100%;
          display: flex;
          justify-content: flex-end;
          align-items: center;
          border: none;
        }
        .sidebar-footer-icon {
          color: #838c9a;
          margin-right: 1rem;
        }
      }
    }
    .showsidebar {
      transform: translateX(0);
      transition: all 0.2s linear;
      width: 270px;
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      height: 100%;
      @include screen(767) {
        &::before {
          content: "";
          width: calc(100vw - 270px);
          position: absolute;
          background-color: #000;
          opacity: 0.15;
          height: 100%;
          left: 100%;
          top: 0;
        }
      }
    }
    &-mainNuxt {
      width: calc(100% - 270px);
      margin-top: 64px;
      margin-left: 270px;
      transition: all 0.2s linear;
      min-height: 85vh;
      background-color: #ebedef;
      @include screen(767) {
        width: 100%;
        margin-left: 0;
      }
    }
    ._fullWidthMainNuxt {
      transition: all 0.2s linear;
      width: 100%;
      margin-left: 0;
    }
  }

  &-footer {
    width: 100%;
    height: 50px;
    background-color: #888888;
    color: #fff;
    display: flex;
    align-items: center;
    .copyright {
      font-size: 18px;
      font-weight: 500;
      position: relative;
      left: 50%;
      transform: translateX(-50%);
    }
  }

  a.nuxt-link-exact-active {
    color: #fff !important;
    width: 100%;
    height: 100%;
    display: flex;
    background-color: #423931;
  }
  @keyframes slide-right {
    0% {
      -webkit-transform: translateX(0);
      transform: translateX(0);
    }
    100% {
      -webkit-transform: translateX(0px);
      transform: translateX(0px);
    }
  }
}
</style>
