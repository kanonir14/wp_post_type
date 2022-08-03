var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    cleanCSS = require('gulp-clean-css'),
    rename = require('gulp-rename'),
    browserSync = require('browser-sync'),
    pxtorem = require('gulp-pxtorem'),
    del = require('del'),
    imagemin = require("gulp-imagemin"),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify');

var sassOptions = {
    errLogConsole: false,
    outputStyle: 'expanded'
};

var pxtoremOptions = {
    rootValue: 16,
    propList: ['*'],
    selectorBlackList: [/^body$/]
};

 var path = {

    styles: {
        src: 'assets/css/scss/**/*.scss',
        src_css: 'assets/css/',
        dest: 'assets/css/'
    },
    scripts: {
        src: 'assets/app/js/common.js', // попробовать прописать путь app/js/**/*.js
        src_lib: 'assets/app/libs/*.js',
        dest: 'assets/dist/js/',
        dest_lib: 'assets/dist/libs/'
    },
    html: {
        src: 'assets/app/index.html',
        dest: 'assets/dist/'
    },
    fonts: {
        src: 'assets/fonts/**/*.*',
        dest: 'assets/dist/fonts/'
    },
    images: {
        src: 'assets/app/img/**/*.*',
        dest: 'assets/dist/img/'
    }
};

gulp.task('browser-sync', function() { 
    browserSync({
        files: ["assets/css/style.css", "assets/js/*.js", "*.php"],
        proxy: {
            target: "localhost/",
            // target: "http://store.com1",
        },
        // server: { 
        //     baseDir: 'app' 
        // },
        notify: false 
    });

    gulp.watch(path.html.src).on('change', browserSync.reload);
});

// function clean() {
//     // return del(['app/css/*.css', '!app/css/style.css', '!app/css/scss', 'dist/css/*.css', '!dist/css/style.css']);
//     return del(['dist']);
// }

// css
function styles() {
    return gulp.src(path.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions)).on('error', sass.logError)
        // .pipe(cleanCSS())
        // .pipe(rename({
        //     basename: 'style',
        //     suffix: '.min'
        // }))
        .pipe(pxtorem(pxtoremOptions))
        .pipe(autoprefixer({
            overrideBrowserslist: ['last 5 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.styles.src_css))
        .pipe(browserSync.stream());

}

// images
// function images() {
//     return gulp.src(path.images.src) 
//         .pipe(imagemin())
//         .pipe(gulp.dest(path.images.dest))
//         .pipe(browserSync.stream());
// }

// fonts
// function fonts() {
//     return gulp.src(path.src.fonts)
//         .pipe(gulp.dest(path.fonts.dest));
// }

// html
// function html(){
//     return gulp.src(path.html.src)
//     .pipe(browserSync.reload({stream:true}));
// }

// js
// function scripts() {
//     return gulp.src(path.scripts.src)
//         .pipe(browserSync.stream())
//         // .pipe(gulp.dest(path.scripts.dest));
// }

// build

function buildProject() {
    var build_css = gulp.src(path.styles.src_css)
        .pipe(gulp.dest(path.styles.dest));

    // var build_html = gulp.src(path.html.src)
    //     .pipe(gulp.dest(path.html.dest));

    // var build_js = gulp.src(path.scripts.src)
    //     .pipe(gulp.dest(path.scripts.dest));

    // var build_img = images();

    // var build_fonts = gulp.src(path.fonts.src)
    //     .pipe(gulp.dest(path.fonts.dest));

    return build_css;
}

var build = gulp.series(buildProject);

// clean
// var clean = gulp.series(clean);

// watch
function watchFiles(){
    gulp.watch(path.styles.src, styles);
    // gulp.watch(path.scripts.src, scripts);
    // gulp.watch(path.html.src, html);
    // gulp.watch(path.images.src, images);
}

var watch = gulp.parallel(watchFiles, ['browser-sync']);


// exports
// exports.clean = clean;
exports.styles = styles;
// exports.scripts = scripts;
// exports.html = html;
// exports.build = build;
// exports.images = images;

// default start 
exports.default = watch;


