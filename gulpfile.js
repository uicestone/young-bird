var gulp = require('gulp')
var order = require('gulp-order')
var sass = require('gulp-sass')
var postcss = require('gulp-postcss')
var autoprefixer = require('autoprefixer')
var concat = require('gulp-concat')
var browserSync = require('browser-sync').create()


gulp.task('serve', function() {
  browserSync.init({
    server: './'
  })

  gulp.watch('styles/*.scss', [ 'sass' ])
  gulp.watch("*.html").on('change', browserSync.reload);
})

gulp.task('sass', function() {
  return gulp.src([
      'styles/main.scss',
      'styles/fontawesome.scss',
    ])
    .pipe(sass())
    // .pipe(sass({ outputStyle: 'compressed' }))
    .pipe(postcss([autoprefixer('last 2 versions', 'ie 9')]))
    .pipe(gulp.dest('css'))
    .pipe(browserSync.stream());
})


gulp.task('default', [ 'sass', 'serve' ])
