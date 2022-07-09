/////////////////////////////////////////////////////////
// DEPENDENCIES
/////////////////////////////////////////////////////////
const { src, dest, watch, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');
const cache = require('gulp-cache');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const imagemin = require('gulp-imagemin');
const notify = require('gulp-notify');
const clean = require('gulp-clean');
const webp = require('gulp-webp');
const avif = require('gulp-avif');
const terser = require('gulp-terser-js');
/////////////////////////////////////////////////////////
// FUNCTIONS
/////////////////////////////////////////////////////////
const paths = {
  scss: 'src/scss/**/*.scss',
  js: 'src/js/**/*.js',
  images: 'src/images/**/*',
  videos: 'src/videos/**/*',
  sounds: 'src/sounds/**/*'
}
function css() {
  return src(paths.scss)
  .pipe(sourcemaps.init())
  .pipe(plumber())
  .pipe(sass())
  .pipe(postcss([ autoprefixer(), cssnano() ]))
  .pipe(sourcemaps.write('.'))
  .pipe(dest('public/build/css'));
}
function javascript() {
  return src(paths.js)
  .pipe(terser())
  .pipe(sourcemaps.write('.'))
  .pipe(dest('public/build/js'));
}
function images() {
  return src(paths.images)
  .pipe(cache(imagemin({ optimizationLevel: 3 })))
  .pipe(dest('public/build/images'))
  .pipe(notify({ message: 'Images task complete' }));
}
function versionWebp() {
  return src(paths.images)
  .pipe(webp())
  .pipe(dest('public/build/images'))
  .pipe(notify({ message: 'Images task complete' }));
}
function versionAvif() {
  return src(paths.images)
  .pipe(avif())
  .pipe(dest('public/build/images'))
  .pipe(notify({ message: 'Images task complete' }));
}
function videos() {
  return src(paths.videos)
  .pipe(dest('public/build/videos'));
}
function sounds() {
  return src(paths.sounds)
  .pipe(dest('public/build/sounds'));
}
function watchRecords() {
  watch(paths.scss, css);
  watch(paths.js, javascript);
  watch(paths.images, images);
  watch(paths.images, versionWebp);
  watch(paths.images, versionAvif);
  watch(paths.videos, videos);
  watch(paths.sounds, sounds);
}
/////////////////////////////////////////////////////////
// COMMANDS
/////////////////////////////////////////////////////////
exports.css = css;
exports.watchRecords = watchRecords;
exports.default = parallel(
  css,
  javascript,
  images,
  versionWebp,
  versionAvif,
  videos,
  sounds,
  watchRecords
);