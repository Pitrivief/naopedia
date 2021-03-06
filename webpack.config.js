var Encore = require('@symfony/webpack-encore');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)

    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
     .addEntry('js/app.min', './assets/js/app.js')
     .addEntry('js/autocomplete.min', './assets/js/autocomplete.js')
     .addEntry('js/datepicker.min', './assets/js/datepicker.js')
     .addEntry('js/naoajax.min', './assets/js/naoajax.js')
     .addEntry('js/map.min', './assets/js/map.js')
     .addEntry('js/owl.carousel.min', './assets/js/owl.carousel.min.js')
     .addStyleEntry('css/app.min', './assets/scss/app.scss')
     .addStyleEntry('css/owl.carousel.min', './assets/scss/owl/owl.carousel.min.css')
     
    // uncomment if you use Sass/SCSS files
     .enableSassLoader()
     .enablePostCssLoader((options) => {
        options.config = {
             path: 'webpackconfig/postcss.config.js'
         };
     })
     
    // uncomment for legacy applications that require $/jQuery as a global variable
     //.autoProvidejQuery()
;

if(!Encore.isProduction()){
    /*Encore.addPlugin(new BundleAnalyzerPlugin({
         openAnalyser:false
     }));*/
}
else{
    Encore.configureUglifyJsPlugin((options) => {
               options.comments = false;
           })
}
var config = Encore.getWebpackConfig();

config.externals = {
    jquery: 'jQuery',
    leaflet: 'L'
}

module.exports = config;
