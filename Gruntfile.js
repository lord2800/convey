module.exports = function (grunt) {
	['phplint', 'phpcs', 'php-analyzer', 'phpunit', 'parallelize', 'gh-pages', 'contrib-watch']
		.forEach(function (name) { grunt.loadNpmTasks('grunt-' + name); });
	grunt.loadTasks('tasks');

	grunt.initConfig({
		parallelize: { phplint: { app: require('os').cpus().length } },
		phplint: {
			options: { swapPath: '/tmp' },
			app: ['src/**/*.php', 'tests/**/*.php']
		},
		phpcs: {
			app: { dir: ['src'] },
			options: { bin: 'vendor/bin/phpcs', standard: 'PSR1' }
		},
		// seemingly broken?
		// TODO figure out what's wrong and re-enable
		// php_analyzer: {
		// 	options: { bin: 'vendor/bin/phpalizer' },
		// 	app: { dir: 'src' }
		// },
		phpunit: {
			unit: { dir: 'tests/' },
			options: {
				bin: 'vendor/bin/phpunit',
				configuration: 'phpunit.xml'
			}
		},
		process: {
			'vendor/bin/phpdoc.php': {}
		},
		'gh-pages': {
			options: {
				base: 'docs',
				message: 'Auto-commit via Travis [ci skip]',
				repo: 'https://' + process.env.GH_OAUTH_TOKEN + '@github.com/lord2800/convey.git',
				silent: true,
				user: {
					name: 'Travis CI',
					email: 'lord2800@gmail.com'
				}
			},
			src: ['**']
		},
		watch: {
			test: {
				files: ['tests/**/*.php'],
				tasks: ['phplint', 'phpcs', 'phpunit']
			}
		}
	});

	grunt.registerTask('precommit', ['parallelize:phplint', 'phpcs', 'phpunit']);
	grunt.registerTask('phpdoc', ['process:vendor/bin/phpdoc.php']);
	grunt.registerTask('test', ['phplint', 'phpcs', /*'php_analyzer',*/ 'phpunit']);
	grunt.registerTask('docs', ['phpdoc', 'gh-pages']);
	grunt.registerTask('default', ['test']);
};
