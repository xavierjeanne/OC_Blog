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
        .src("./front_asset/sass/*.scss")
        .pipe(plumber())
        .pipe(sass({
            outputStyle: "expanded",
            includePaths: "./node_modules",
        }))
        .on("error", sass.logError)
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(cleanCSS())
        .pipe(gulp.dest("./public/front/css"));
}

function cssBack() {
    return gulp
        .src("./back_asset/sass/*.scss")
        .pipe(plumber())
        .pipe(sass({
            outputStyle: "expanded",
            includePaths: "./node_modules",
        }))
        .on("error", sass.logError)
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(cleanCSS())
        .pipe(gulp.dest("./public/back/css"));
}

// JS task
function jsFront() {
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

function jsBack() {
    return gulp
        .src([
            './back_asset/js/*.js',
        ])
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./public/back/js'));
}

// Watch files
function watchFiles() {
    gulp.watch("./front_asset/sass/*", cssFront);
    gulp.watch("./back_asset/sass/*", cssBack);
    gulp.watch("./front_asset/js/*", jsFront);
    gulp.watch("./back_asset/js/*", jsFront);
}

const watch = gulp.series(watchFiles);

// Export tasks
exports.cssFront = cssFront;
exports.cssBack = cssBack;
exports.jsFront = jsFront;
exports.jsBack = jsBack;
exports.watch = watch;