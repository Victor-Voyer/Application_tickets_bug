// webpack.config.js
const Encore = require("@symfony/webpack-encore");

Encore
  // directory where compiled assets will be stored
  .setOutputPath("public/build/")
  // public path used by the web server
  .setPublicPath(!Encore.isProduction() ? "/symfony-1/Application_tickets_bug/public/build" : "/build")
  // only needed for CDN or subdirectory deploys
  .setManifestKeyPrefix('build/')

  // main CSS/JS entry files
  .addEntry("app", "./assets/app.js")
  // .addStyleEntry("styles", "./assets/styles/app.css")

  .copyFiles({
    from: "./assets/images",
    to: "images/[path][name].[ext]",
  })

  // .enableSassLoader()
  .enablePostCssLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSingleRuntimeChunk();

module.exports = Encore.getWebpackConfig();
