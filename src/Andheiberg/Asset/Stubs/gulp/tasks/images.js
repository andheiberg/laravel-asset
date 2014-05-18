var changed    = require('gulp-changed');
var gulp       = require('gulp');
var imagemin   = require('gulp-imagemin');
var handleErrors = require('../util/handleErrors');

gulp.task('images', function() {
	var dest = 'public/assets/images';

	gulp.src('app/assets/images/**')
		// .pipe(changed(dest)) // Ignore unchanged files
		.pipe(imagemin({
			progressive: true
		}))
		.on('error', handleErrors)
	.pipe(gulp.dest(dest));
});
