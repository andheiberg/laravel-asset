//Gruntfile
module.exports = function(grunt) {

	// Initialize configuration object
	grunt.initConfig({

		// Settings
		// ==================================

		// Read in project settings
		pkg: grunt.file.readJSON('package.json'),

		options: {
			base: {
				source: 'app/assets',
				destination: 'public/assets'
			},
			js: {
				source: '<%= options.base.source %>/js',
				destination: '<%= options.base.destination %>/js'
			},
			scss: {
				source: '<%= options.base.source %>/scss',
				destination: '<%= options.base.destination %>/css'
			}
		},



		// Script
		// ==================================

		// Clean build folder before replacement
		clean: ['<%= options.base.destination %>'],

		// Compile SASS files
		sass: {
			options: {
				lineNumbers: true
			},
			dist: {
				files: [{
					expand: true,
					cwd: '<%= options.scss.source %>',
					src: ['*.scss'],
					dest: '<%= options.scss.destination %>',
					ext: '.css'
				}]
			}
		},

		autoprefixer: {
			css: {
				expand: true,
				flatten: true,
				src: '<%= options.scss.destination %>/*.css',
				dest: '<%= options.scss.destination %>'
			},
		},

		// Minify and concatenate CSS files
		cssmin: {
			options: { keepSpecialComments: 0 },
			minify: {
				expand: true,
				cwd: '<%= options.scss.destination %>',
				src: ['*.css'],
				dest: '<%= options.scss.destination %>',
				ext: '.css'
			}
		},


		import: {
			js: {
				expand: true,
				cwd: '<%= options.js.source %>',
				src: '*.js',
				dest: '<%= options.js.destination %>',
				ext: '.js'
			}
		},

		// Javascript minification - uglify
		uglify: {
			options: {
				preserveComments: false,
				compress: {unused: false},
				report: 'min'
			},
			default: {
				files: [{
					expand: true,
					cwd: '<%= options.js.destination %>',
					src: '*.js',
					dest: '<%= options.js.destination %>'
				}]
			}
		},

		cachebuster: {
			build: {
				options: {
					format: 'json',
					basedir: '<%= options.base.destination %>',
					complete: function(hashes) {
						grunt.util._.each(hashes, function(element, index, array) {
							array['/assets/'+index] = '/assets/'+index.replace(/(\.[\w\d_-]+)$/i, '.'+element+'$1');
							delete array[index];
						});

						return hashes;
					}
				},
				src: ['<%= options.base.destination %>/**/*'],
				dest: 'app/storage/meta/cachebusters.json'
			}
		},

		// Display notifications
		notify: {
			watch: {
				options: {
					title: 'Grunt watch',
					message: 'Files were modified, recompiled and site reloaded.'
				}
			},
			watch_scss: {
				options: {
					title: 'Grunt watch (scss)',
					message: 'Files were modified, recompiled and site reloaded.'
				}
			},
			watch_js: {
				options: {
					title: 'Grunt watch (js)',
					message: 'Files were modified, recompiled and site reloaded.'
				}
			}
		},

		// Should be faster if you only change js and scss takes a long time to compile,
		// but at this point it seams to be slower
		
		// // Watch for files and folder changes
		// watch: {
		// 	options: {
		// 		livereload: true,
		// 	},
		// 	js: {
		// 		files: ['<%= sources.js.base %>/**/*.js'],
		// 		tasks: ['concat:js', 'cachebuster', 'notify:watch_js'],
		// 	},
		// 	css: {
		// 		files: ['<%= sources.scss.base %>/**/*.scss'],
		// 		tasks: ['sass', 'cachebuster', 'notify:watch_scss'],
		// 	}
		// }

		// Watch for files and folder changes
		watch: {
			options: {
				livereload: true
			},
			files: [
				'<%= options.js.source %>/**/*.js',
				'<%= options.scss.source %>/**/*.scss'
			],
			tasks: ['default', 'notify:watch']
		}

	});

	// Load npm tasks
	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-livereload');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-cachebuster');
	grunt.loadNpmTasks('grunt-import');
	

	// Register tasks
	grunt.registerTask('default', ['clean', 'sass', 'import:js', 'cachebuster', 'watch']);
	grunt.registerTask('build', ['clean', 'sass', 'autoprefixer', 'import:js', 'cssmin', 'uglify', 'cachebuster']);

};