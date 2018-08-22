module.exports = function( grunt ) {
	var globalOptions = {
		browsers: [
			'> 1%',
			'last 3 versions',
			'ie 9',
			'ie 10',
			'ie 11'
		],
		less: {
			srcPath: 'less/',
			srcFiles: [
				'bootstrap.less',
				'style.less',
				'responsive.less',
				'slick.less',
				'visual-composer-starter-font.less',
				'woocommerce.less'
			],
			destPath: 'css/'
		},
		js: {
			srcPath: 'js/',
			destPath: 'js/'
		}
	};

	// Project configuration.
	grunt.initConfig( {

		// Task configuration.
		pkg: grunt.file.readJSON( 'package.json' ),
		go: globalOptions,

		// License banner text
		banner: '/*!\n' +
		' * <%= pkg.nativeName %> v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
		' * Copyright 2011-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
		' * License: GPL. More details: <%= pkg.license %>\n' +
		' */\n',

		// License banner config
		// WARNING:
		//  This task simply adds the banner to the head of the files that are specified,
		//  it makes no attempt to see if a banner already exists and it is up to you
		//  to ensure that the file should not already contain a banner.
		//  So run this task to only to add banners to production-ready code.
		usebanner: {
			css: {
				options: {
					position: 'top',
					banner: '<%= banner %>',
					linebreak: true
				},
				files: {
					src: [
						'css/*.css'
					]
				}
			}
		},

		// Compile LESS files to CSS.
		less: {
			main: {
				options: {
					sourceMap: false,
					outputSourceFiles: true
				},
				files: [
					{
						expand: true,           // Enable dynamic expansion.
						cwd: globalOptions.less.srcPath,    // Src matches are relative to this path.
						src: globalOptions.less.srcFiles,   // Actual pattern(s) to match.
						dest: globalOptions.less.destPath,  // Destination path prefix.
						ext: '.min.css',            // Dest filepaths will have this extension.
						extDot: 'first'         // Extensions in filenames begin after the first dot
					},
					{
						'css/style.css': 'less/style.less'
					},
					{
						'css/bootstrap.css': 'less/bootstrap.less'
					},
					{
						'css/responsive.css': 'less/responsive.less'
					},
					{
						'css/slick.css': 'less/slick.less'
					},
					{
						'css/style.css': 'less/style.less'
					},
					{
						'css/visual-composer-starter-font.css': 'less/visual-composer-starter-font.less'
					},
					{
						'css/woocommerce.css': 'less/woocommerce.less'
					}
				]
			}
		},

		// Add vendor prefixes on css rules
		postcss: {
			main: {
				options: {
					map: false,
					processors: [
						require( 'autoprefixer' )( { browsers: globalOptions.browsers } )
					]
				},
				files: [
					{
						expand: true,
						cwd: globalOptions.less.destPath,
						src: [
							'*.min.css'
						],
						dest: globalOptions.less.destPath,
						ext: '.min.css'
					},
					{
						'css/style.css': 'css/style.css'
					},
					{
						'css/bootstrap.css': 'css/bootstrap.css'
					},
					{
						'css/responsive.css': 'css/responsive.css'
					},
					{
						'css/slick.css': 'css/slick.css'
					},
					{
						'css/style.css': 'css/style.css'
					},
					{
						'css/visual-composer-starter-font.css': 'css/visual-composer-starter-font.css'
					},
					{
						'css/woocommerce.css': 'css/woocommerce.css'
					}
				]
			},
			lib: {
				options: {
					processors: [
						require( 'autoprefixer' )( { browsers: globalOptions.browsers } )
					],
					map: false
				}
			}
		},

		// Css min
		cssmin: {
			main: {
				files: [
					{
						expand: true,
						cwd: globalOptions.less.destPath,
						src: [ '*.min.css' ],
						dest: globalOptions.less.destPath,
						ext: '.min.css'
					}
				]
			},
			lib: {
				files: [
					{
						expand: true,
						src: [
							'**/*.css',
							'!**/*.min.css'
						],
						ext: '.min.css'
					}
				]
			}
		},

		lesslint: {
			main: {
				files: [
					{
						expand: true,           // Enable dynamic expansion.
						cwd: globalOptions.less.srcPath,    // Src matches are relative to this path.
						src: globalOptions.less.srcFiles   // Actual pattern(s) to match.
					}
				]
			}
		},

		uglify: {
			main: {
				files: [
					{
						dest: '<%= go.js.destPath %>functions.min.js',
						src: '<%= go.js.srcPath %>functions.js'
					},
					{
						dest: '<%= go.js.destPath %>customize-preview.min.js',
						src: '<%= go.js.srcPath %>customize-preview.js'
					}
				]
			}
		},

		// Run predefined tasks whenever watched file changed or deleted
		watch: {
			css: {
				options: {
					atBegin: true
				},
				files: [ 'less/**/*.less' ],
				tasks: [
					'build-css',
					'postcss:lib'
				]
			},
			js: {
				options: {
					atBegin: true
				},
				files: [
					'js/**/*.js',
					'!js/*min.js'
				],
				tasks: [
					'build-js'
				]
			}
		}
	} );

	// These plugins provide necessary tasks.
	require( 'load-grunt-tasks' )( grunt );
	grunt.loadNpmTasks( 'grunt-composer' );

	grunt.registerTask( 'build-css',
		[
			'less:main',
			'postcss:main',
			'cssmin:main'
		] );

	grunt.registerTask( 'build-js', [ 'uglify:main' ] );

	grunt.registerTask( 'build',
		[
			'build-css',
			'build-js'
		] );

	// Default task.
	grunt.registerTask( 'default', [ 'build' ] );
};
