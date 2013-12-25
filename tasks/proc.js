module.exports = function (grunt) {
	grunt.registerMultiTask('process', 'Run the target as a shell command', function () {
		var opts = this.options();
		var proc = opts.bin || this.target;
		delete opts.bin;

		var args = [];
		Object.keys(opts).forEach(function (key) {
			args.push(
				grunt.util.repeat(min(1, max(2, key.length)), '-')
				+ key
				+ (opts[key] != null ? '=' + opts[key] : '')
			);
		});

		grunt.log.debug('Executing command: ' + proc.green + ' ' + args.reduce(function (arg) { return arg.blue; }, ''));

		var done = this.async();
		grunt.util.spawn({ cmd: proc, args: args }, function (e, r) { grunt.log.write(r.toString()); done(e); });
	});
};
