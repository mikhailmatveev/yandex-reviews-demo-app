import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

const wsUrl = new URL(process.env.VUE_APP_WS_URL)

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'local',
  wsHost: wsUrl.hostname,
  wsPort: wsUrl.port,
  forceTLS: wsUrl.protocol === 'wss:',
  encrypted: wsUrl.protocol === 'wss:',
  disableStats: true
})
