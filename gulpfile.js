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
        .src("./front_asset/css/sass/*.scss")
        .pipe(plumber())
        .pipe(sass({
            outputStyle: "expanded",
            includePaths: "./node_modules",
        }))
        .on("error", sass.logError)
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(gulp.dest("./front_asset/css"))
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
            './front_asset/js/*.js',
        ])
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./public/front/js'));
}

// Watch files
function watchFiles() {
    gulp.watch("./front_asset/css/sass/*", css);
    gulp.watch("./front_asset/js/*", js);
}

const watch = gulp.series(watchFiles);

// Export tasks
exports.css = css;
exports.js = js;
exports.watch = watch;