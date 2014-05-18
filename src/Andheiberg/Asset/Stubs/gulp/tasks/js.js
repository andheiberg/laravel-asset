var browserify   = require('browserify');
var gulp         = require('gulp');
var handleErrors = require('../util/handleErrors');
var source       = require('vinyl-source-stream');

gulp.task('js', function(){
	browserify('./app/assets/js/main.js').bundle({debug: true})
	.on('error', handleErrors)
	.pipe(source('main.js'))
	.pipe(gulp.dest('./public/assets/js'))
});
