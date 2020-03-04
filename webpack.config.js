const Encore = require('@symfony/webpack-encore')
const CopyPlugin = require('copy-webpack-plugin')

const staticPaths = [
    { from: './assets/template/images',  to: 'template/images' },
    { from: './assets/template/libs', to: 'template/libs' },
    { from: './assets/template/vendor', to: 'template/vendor' },
]

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .disableSingleRuntimeChunk()
    .enableSassLoader()
    .enableVueLoader()
    .addPlugin(new CopyPlugin(staticPaths))
    // .enableVersioning(Encore.isProduction())

module.exports = Encore.getWebpackConfig()