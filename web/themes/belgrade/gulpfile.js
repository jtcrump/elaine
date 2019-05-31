/*
  gulpfile.js
  ===========
  Rather than manage one giant configuration file responsible
  for creating multiple tasks, each task has been broken out into
  its own file in gulpfile.js/tasks. Any files in that directory get
  automatically required below.

*/



"use strict";

// Load plugins
const autoprefixer = require("autoprefixer");
const browsersync = require("browser-sync").create();
const cp = require("child_process");
// const cssnano = require("cssnano");
const eslint = require("gulp-eslint");
const gulp = require("gulp");
const imagemin = require("gulp-imagemin");
const newer = require("gulp-newer");
const plumber = require("gulp-plumber");
const postcss = require("gulp-postcss");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
// const webpack = require("webpack");
// const webpackconfig = require("./webpack.config.js");
// const webpackstream = require("webpack-stream");

// BrowserSync
function browserSync(done) {
//  browsersync.init({
//    server: {
//      baseDir: "./"
//    },
//    port: 3000
//  });
  done();
}

// Clean assets
function clean() {
  return del(["./assets/"]);
}


// Optimize Images
function images() {
  return gulp
    .src("./assets/img/**/*")
    .pipe(newer("./assets/images"))
    .pipe(
      imagemin([
        imagemin.gifsicle({ interlaced: true }),
        imagemin.jpegtran({ progressive: true }),
        imagemin.optipng({ optimizationLevel: 5 }),
        imagemin.svgo({
          plugins: [
            {
              removeViewBox: false,
              collapseGroups: true
            }
          ]
        })
      ])
    )
    .pipe(gulp.dest("./_site/assets/img"));
}

// CSS task
function css() {
  return gulp
    .src("./assets/scss/**/*.scss")
    .pipe(plumber())
    .pipe(sass({ outputStyle: "expanded" }))
    .pipe(gulp.dest("./assets/css/"))
  //  .pipe(rename({ suffix: ".min" }))
  //  .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest("./assets/css/"))
    .pipe(browsersync.stream());
}

// Lint scripts
function scriptsLint() {
  return gulp
    .src(["./assets/js/**/*", "./gulpfile.js"])
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

// Transpile, concatenate and minify scripts
function scripts() {
  return (
    gulp
      .src(["./assets/js/**/*"])
      .pipe(plumber())
    //  .pipe(webpackstream(webpackconfig, webpack))
      // folder only, filename is specified in webpack config
      .pipe(gulp.dest("./assets/js/"))
      .pipe(browsersync.stream())
  );
}

// Jekyll
function jekyll() {
  return cp.spawn("bundle", ["exec", "jekyll", "build"], { stdio: "inherit" });
}

// Watch files
function watchFiles() {
  gulp.watch("./assets/scss/**/*", css);
  gulp.watch("./assets/js/**/*", gulp.series(scriptsLint, scripts));
  gulp.watch(
    [
      "./commerce/**/*",
      "./component/**/*",
      "./pages/**/*",
      "./regions/**/*",
      "./utilities/**/*"
    ],
  //  gulp.series(jekyll, browserSyncReload)
  );
  gulp.watch("./assets/img/**/*", images);
}

// define complex tasks
const js = gulp.series(scriptsLint, scripts);
const build = gulp.series(clean, gulp.parallel(css, images, jekyll, js));
const watch = gulp.parallel(watchFiles, browserSync);

// export tasks
exports.images = images;
exports.css = css;
exports.js = js;
exports.jekyll = jekyll;
exports.clean = clean;
exports.build = build;
exports.watch = watch;
exports.default = build;
