export default function ({$axios, redirect}) {
    $axios.onRequest(config => {
  
      $axios.defaults.headers.common['Content-Type'] ='application/json'
      $axios.defaults.headers.common.Authorization = localStorage.getItem(
        'auth._token.local'
      )
      return config
    })
  }
  