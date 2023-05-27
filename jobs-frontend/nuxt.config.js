export default {
  target: 'static',

  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'TODO APP',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'
      },
      { hid: 'description', name: 'description', content: 'This is todo apps' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
    ]
  },

  publicRuntimeConfig: {
    baseURL: process.env.API_BASE
  },
  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    
    '~/assets/scss/main.scss'
  ],
  scss: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '@/plugins/axios.js',
    '@/plugins/vuelidate.js'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    '@nuxtjs/eslint-module',
    // moment
    '@nuxtjs/moment',
    // With options
    ['@nuxtjs/moment', { /* module options */ }],
    ['@nuxtjs/dotenv', {}],
    ['@nuxtjs/fontawesome', {
      component: 'fa',
      suffix: true,
    }],
    '@nuxtjs/style-resources',
  ],
  moment: {
    defaultTimezone: 'Asia/Tokyo'
  },
  styleResources: {
    scss: [
      './assets/scss/_variables.scss' // use underscore "_" & also file extension ".scss"
    ]
  },
  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    '@nuxt/http',
    '@nuxtjs/axios',
    '@nuxtjs/proxy',
    '@nuxtjs/dotenv',
    '@nuxtjs/toast'
  ],

  bootstrapVue: {
    icons: true
  },

  axios: {
    proxy: true,
    proxyHeaders: false,
    credentials: false
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    vendor: [
      'vue-cropper'
    ]
  },

  server: {
    host: '0.0.0.0'
  }
}
