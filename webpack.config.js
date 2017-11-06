'use strict';

const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    .autoProvideVariables({
        'window.jQuery': 'jquery',
    })
    .enableSassLoader()
    .enableVersioning(false)
    .createSharedEntry('js/common', ['jquery'])
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', ['./assets/scss/app.scss'])
;

module.exports = Encore.getWebpackConfig();
