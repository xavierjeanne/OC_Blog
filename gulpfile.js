var {
    src,
    dest,
    watch
} = require('gulp');
var gulpSass = require('gulp-sass');

//sass compil
function sass() {
    return (
        src("public/css/sass/*.scss")
        .pipe(gulpSass())
        .pipe(dest("public/css"))
    )
}

function watcher() {
    watch("public/css/sass/*.scss", sass);
}

module.exports = {
    default: sass,
    watch: watcher
}