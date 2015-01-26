module.exports = function (grunt) {

	grunt.loadNpmTasks( 'grunt-composer' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-git' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		composer: {
			options: {
				usePhp: true,
				cwd: '',
				composerLocation: '/usr/local/bin/composer'
			}
		},
		clean: {
			main: ['release/build/<%= pkg.version %>/']
		},
		copy: {
			main: {
				src:  [
					'**',
					'!node_modules/**',
					'!release/**',
					'!.git/**',
					'!.sass-cache/**',
					'!Gruntfile.js',
					'!package.json',
					'!.gitignore',
					'!.gitmodules'
				],
				dest: 'release/build/<%= pkg.version %>/'
			}
		},
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './release/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'release/build/<%= pkg.version %>/',
				src: [ '**/*' ],
				dest: '<%= pkg.name %>-<%= pkg.version %>/'
			}
		},
		gittag: {
			addtag: {
				options: {
					tag: '<%= pkg.version %>',
					message: 'Version <%= pkg.version %>'
				}
			}
		},
		gitpush: {
			push_tag: {
				options: {
					tags: true
				}
			}
		},
		gitcommit: {
			commit: {
				options: {
					message: 'Version <%= pkg.version %> Download',
					noVerify: true,
					noStatus: false,
					allowEmpty: true
				},
				files: {
					src: [ 'release/<%= pkg.name %>-<%= pkg.version %>.zip' ]
				}
			}
		},
	});

	grunt.registerTask( 'build', [ 'composer:update', 'copy', 'compress', 'gittag', 'gitcommit', 'gitpush', 'clean' ] );


};
