"use strict";

// Load plugins
const autoprefixer = require("gulp-autoprefixer");
const cleanCSS = require("gulp-clean-css");
const gulp = require("gulp");
const plumber = require("gulp-plumber");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const uglify = require("gulp-uglify");


// CSS task
function cssFront() {
  return gulp
    .src(
      "./public/front/css/sass/*.scss",
    )
    .pipe(plumber())
    .pipe(sass({
      outputStyle: "expanded",
      includePaths: "./node_modules",
    }))
    .on("error", sass.logError)
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest(
      "./public/front/css",
    ))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest(
      "./public/front/css",
    ));
}

function cssBack() {
  return gulp
    .src(
      "./public/back/css/sass/*.scss",
    )
    .pipe(plumber())
    .pipe(sass({
      outputStyle: "expanded",
      includePaths: "./node_modules",
    }))
    .on("error", sass.logError)
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest(
      "./public/back/css",
    ))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest(
      "./public/back/css",
    ));
}
// JS task
function jsFront() {
  return gulp
    .src(
      './public/front/js/*.js'
    )
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./public/front/js'));
}

function jsBack() {
  return gulp
    .src(
      './public/back/js/*.js'
    )
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./public/back/js'));
}
// Watch files
function watchFiles() {
  gulp.watch("./public/front/css/sass/*", cssFront);
  gulp.watch("./public/back/css/sass/*", cssBack);
  gulp.watch(["./public/front/css/js/*", "!./public/front/css/js/*.min.js"], jsFront);
  gulp.watch(["./public/back/css/js/*", "!./public/back/css/js/*.min.js"], cssFront);
}


const watch = gulp.series(watchFiles);

// Export tasks
exports.cssFront = cssFront;
exports.cssBack = cssBack;
exports.jsFront = jsFront;
exports.jsBack = jsBack;
exports.watch = watch;