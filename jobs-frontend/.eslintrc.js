// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
//
//  eslint (静的コード分析) 設定ファイル
//
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

module.exports = {
    root: true,
    env: {
        browser: true,
        node: true
    },
    parserOptions: {
        parser: 'babel-eslint'
    },

    extends: [
        '@nuxtjs',
        'prettier',
        'prettier/vue',
        'plugin:nuxt/recommended'
        // 'plugin:prettier/recommended', 非推奨のため削除 2021/9/18
    ],

    plugins: [
        // 'prettier' 非推奨のため削除 2021/9/18
    ],

    rules: {
        'vue/v-on-style': ['error', 'longform'], // v-on の省略形を認めない
        'vue/v-bind-style': ['error', 'longform'] // v-bind の省略形を認めない
    }
}
