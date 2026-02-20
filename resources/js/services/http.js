import axios from 'axios'

class Http {
  constructor (config) {
    this.client = axios.create(config)
  }

  async getCookie () {
    return await this.client.get('/sanctum/csrf-cookie')
  }

  async login (email, password) {
    return await this.client.post('/login', {
      email,
      password
    })
  }

  async logout () {
    return await this.client.post('/logout')
  }
}

export default new Http({
  baseURL: `http://${process.env.VUE_APP_BACKEND_HOST}`,
  responseType: 'json',
  withCredentials: true
})
