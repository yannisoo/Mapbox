// Requis
var gulp = require('gulp');

// Include plugins
var plugins = require('gulp-load-plugins')(); // tous les plugins de package.json

var sass = require('gulp-sass');
// Variables de chemins
var source = './src'; // dossier de travail
var destination = './dist'; // dossier à livrer

// Tâche "build" = LESS + autoprefixer + CSScomb + beautify (source -> destination)
gulp.task('css', function () {
  return gulp.src(source + '/assets/css/styles.less')
    .pipe(plugins.less())
    .pipe(plugins.csscomb())
    .pipe(plugins.cssbeautify({indent: '  '}))
    .pipe(plugins.autoprefixer())
    .pipe(gulp.dest(destination + '/assets/css/'));
});

// Tâche "minify" = minification CSS (destination -> destination)
gulp.task('minify', function () {
  return gulp.src(destination + '/assets/css/*.css')
    .pipe(plugins.csso())
    .pipe(plugins.rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(destination + '/assets/css/'));
});

gulp.task('sass', function () {
  return gulp.src('src/scss/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('php-map'));
});

/*gulp.task('css', function () {
   return gulp.src('src/scss/style.scss')
   .pipe(sass().on('error', sass.logError))
   .pipe(prefix({
     browsers: ['last 4 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4']
   }))
   .pipe(cssbeautify())
   .pipe(gulp.dest('css'))
   .pipe(cssnano())
   .pipe(rename({ suffix: '.min' }))
   .pipe(header(banner, { package : package }))
   .pipe(gulp.dest('css'));
});*/

// Tâche "build"
gulp.task('build', ['css', 'sass']);

// Tâche "prod" = Build + minify
gulp.task('prod', ['build',  'minify']);

// Tâche "watch" = je surveille *less
gulp.task('watch', function () {
  gulp.watch(source + '/assets/css/*.less', ['build']);
});

gulp.task('default', ['build'], function () {
   gulp.watch("src/scss/*/*.scss", ['css']);
   gulp.watch("src/scss/*/*.scss", ['sass']);
   gulp.watch("src/scss/*.scss", ['sass']);
});

