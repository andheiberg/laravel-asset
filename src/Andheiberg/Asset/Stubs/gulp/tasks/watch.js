var gulp       = require('gulp');
var livereload = require('gulp-livereload');

gulp.task('watch', function() {
	var server = livereload();

	var reload = function(file) {
		server.changed(file.path);
	};

	gulp.watch('app/assets/js/**', ['js', 'cachebust']);
	gulp.watch('app/assets/sass/**', ['css', 'cachebust']);
	gulp.watch('app/assets/images/**', ['images']);
	gulp.watch('app/assets/fonts/**', ['fonts']);
	gulp.watch(['public/assets/**']).on('change', reload);
});
