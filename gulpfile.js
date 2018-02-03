// Gulp.js configuration
'use strict';

const

  // Gulp and plugins
  gulp          = require('gulp'),
  gutil         = require('gulp-util'),
  newer         = require('gulp-newer'),
  imagemin      = require('gulp-imagemin'),
  sass          = require('gulp-sass'),
  postcss       = require('gulp-postcss'),
  deporder      = require('gulp-deporder'),
  concat        = require('gulp-concat'),
  stripdebug    = require('gulp-strip-debug'),
  uglify        = require('gulp-uglify'),
  order         = require('gulp-order'),
  env           = require('gulp-env'),
  autoprefixer  = require('autoprefixer')
;

try {
  env({
    file: '.env.json',
  });
}
catch (err) {
  if (err.code === 'ENOENT') {
    console.error('Please create .env.json first from .env-example.json.');
    process.exit();
  }
  else {
    throw err;
  }
}


  // source and build folders
const dir = {
  src           : './',
  build         : process.env.DIR_BUILD
};

// Browser-sync
let browsersync = false;

// PHP settings
const php = {
  src           : dir.src + '**/*.php',
  build         : dir.build
};

// copy PHP files
gulp.task('php', () => {
  return gulp.src(php.src)
    .pipe(newer(php.build))
    .pipe(gulp.dest(php.build));
});

// image settings
const images = {
  src         : dir.src + 'images/**/*',
  build       : dir.build + 'images/'
};

// image processing
gulp.task('images', () => {
  return gulp.src(images.src)
    .pipe(newer(images.build))
    .pipe(imagemin())
    .pipe(gulp.dest(images.build));
});

// CSS settings
var css = {
  src         : [dir.src + 'styles/main.scss', dir.src + 'styles/fontawesome.scss', dir.src + 'style.css'],
  watch       : dir.src + 'styles/**/*',
  build       : dir.build + 'css/',
  sassOpts: {
    outputStyle     : 'nested',
    imagePath       : images.build,
    precision       : 3,
    errLogToConsole : true
  },
  processors: [
    require('postcss-assets')({
      loadPaths: ['images/'],
      basePath: dir.build,
      baseUrl: '/wp-content/themes/young-bird/'
    }),
    require('autoprefixer')({
      browsers: ['last 2 versions', '> 2%']
    }),
    require('css-mqpacker')
  ]
};

// CSS processing
gulp.task('css', ['images'], () => {
  return gulp.src(css.src)
    .pipe(sass(css.sassOpts))
    .pipe(postcss(css.processors))
    .pipe(gulp.dest(css.build))
    .pipe(browsersync ? browsersync.reload({ stream: true }) : gutil.noop());
});

const theme = {
  src        : [dir.src + 'style.css', dir.src + 'screenshot.png'],
  build      : dir.build
};

gulp.task('theme', () => {
  return gulp.src(theme.src)
    .pipe(gulp.dest(theme.build));
});

const fonts = {
  src        : dir.src + 'font/**/*',
  build      : dir.build + 'font'
};

gulp.task('fonts', () => {
  return gulp.src(fonts.src)
    .pipe(gulp.dest(fonts.build));
});

// JavaScript settings
const js = {
  src         : [dir.src + 'js/**/*', dir.src + 'bootstrap/js/**/*'],
  build       : dir.build + 'js/',
  filename    : 'scripts.js'
};

// JavaScript processing
gulp.task('js', () => {

  return gulp.src(js.src)
    // .pipe(deporder())
    // .pipe(concat(js.filename))
    // .pipe(stripdebug())
    // .pipe(uglify())
    .pipe(gulp.dest(js.build))
    .pipe(browsersync ? browsersync.reload({ stream: true }) : gutil.noop());

});

// run all tasks
gulp.task('build', ['theme', 'php', 'css', 'fonts', 'js']);

// Browsersync options
const syncOpts = {
  proxy       : process.env.PROXY_URL,
  files       : dir.build + '**/*',
  serveStatic : [dir.build, dir.src],
  open        : false,
  notify      : false,
  ghostMode   : false
};

// watch for file changes
gulp.task('watch', () => {

  // page changes
  gulp.watch(php.src, ['php'], browsersync ? browsersync.reload : {});

  // image changes
  gulp.watch(images.src, ['images']);

    // CSS changes
  gulp.watch(css.watch, ['css']);

  // JavaScript main changes
  gulp.watch(js.src, ['js']);

  // browser-sync
  if (browsersync === false) {
    browsersync = require('browser-sync').create();
    browsersync.init(syncOpts);
  }

});

// default task
gulp.task('default', ['build', 'watch']);

