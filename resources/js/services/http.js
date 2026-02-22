import axios from 'axios'

class Http {
  constructor (config) {
    this.client = axios.create(config)
  }

  async getCookie () {
    return await this.client.get('/sanctum/csrf-cookie')
  }

  async getIntegration () {
    return await this.client.get('/api/integration')
  }

  async getReviews (page) {
    return await this.client.get('/api/reviews', {
      params: {
        page
      }
    })
  }

  async postIntegration (url) {
    return await this.client.post('/api/integration', {
      url
    })
  }

  async syncIntegration () {
    return await this.client.post('/api/integration/sync')
  }

  async getUser () {
    return await this.client.get('/api/user')
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
