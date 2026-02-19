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

    // Отключаем копирование файлов из папки public
    config.plugin('copy').tap(options => {
      return [[/* пустой массив */]]
    })

    // const svgRule = config.module.rule('svg')
    //
    // const fileLoader = svgRule.use('file-loader').get('loader')
    // const fileLoaderOptions = svgRule.use('file-loader').get('options')
    //
    // svgRule.uses.clear()
    //
    // svgRule
    //   .oneOf('svg-import')
    //   .resourceQuery(/inline/)
    //   .use('vue-svg-loader')
    //   .loader('vue-svg-loader')
    //   .end()
    //   .end()
    //   .oneOf('svg')
    //   .use('file-loader')
    //   .loader(fileLoader)
    //   .options(fileLoaderOptions)
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
