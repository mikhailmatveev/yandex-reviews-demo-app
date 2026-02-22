import { Notification } from 'uiv'

function notify (message, type) {
  // eslint-disable-next-line no-void
  void Notification.notify({
    content: message,
    type,
    duration: 3000
  })
}

export default {
  success (message) {
    notify(message, 'success')
  },
  error (message) {
    notify(message, 'danger')
  },
  warning (message) {
    notify(message, 'warning')
  },
  info (message) {
    notify(message, 'info')
  }
}
