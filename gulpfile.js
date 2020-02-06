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
function css() {
  return gulp
    .src("./public/front/css/sass/*.scss")
    .pipe(plumber())
    .pipe(sass({
      outputStyle: "expanded",
      includePaths: "./node_modules",
    }))
    .on("error", sass.logError)
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest("./public/front/css"))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest("./public/front/css"));
}

// JS task
function js() {
  return gulp
    .src([
      './public/front/js/*.js',
    ])
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('.public/front/js'));
}

// Watch files
function watchFiles() {
  gulp.watch("./public/front/css/sass/*", css);
  gulp.watch(["./public/front/js/**/*", "!.public/front/js/**/*.min.js"], js);
}

const watch = gulp.series(watchFiles);

// Export tasks
exports.css = css;
exports.js = js;
exports.watch = watch;