var gulp = require('gulp');
var bust = require('gulp-buster');

gulp.task('cachebust', function() {
	gulp.src(['./public/assets/css/*.css', './public/assets/js/*.js'])
		.pipe(bust('cachebusters.json'))
		.pipe(gulp.dest('./app/storage/meta'));
});
