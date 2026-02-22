module.exports = {
  assetsDir: 'build',
  configureWebpack: {
    plugins: []
  },
  chainWebpack: config => {
    config.plugin('html').tap(args => {
      args[0].template = './public-template.html'
      args[0].title = 'yandex-reviews-demo-app'
      return args
    })

    // Полностью удаляем copy plugin
    config.plugins.delete('copy')
  },
  devServer: {
    proxy: {
      '^/api': {
        target: 'http://nginx',
        changeOrigin: true
      }
    },
    disableHostCheck: true,
    port: 9000
  }
}
