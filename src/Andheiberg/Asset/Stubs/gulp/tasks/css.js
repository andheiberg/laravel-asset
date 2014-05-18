var gulp         = require('gulp');
var sass         = require('gulp-sass');
var notify       = require('gulp-notify');
var handleErrors = require('../util/handleErrors');
var prefix       = require('gulp-autoprefixer');

gulp.task('css', function() {
	return gulp.src('./app/assets/scss/*.scss')
		.pipe(sass({
			outputStyle: 'nested', // compressed
		}))
		.pipe(prefix(["last 1 version", "> 1%", "ie 8", "ie 7"], { cascade: true }))
		.on('error', handleErrors)
		.pipe(gulp.dest('./public/assets/css'));
});
