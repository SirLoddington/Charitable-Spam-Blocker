/*global module:false*/
/*global require:false*/
/*jshint -W097*/
"use strict";

module.exports = function(grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Clean up build directory
        clean: {
            main: ['build/<%= pkg.name %>']
        },

    });

    // Default task. - grunt watch
    grunt.registerTask( 'default', 'build' );

    // Build task(s).
	grunt.registerTask( 'build', [ 'clean' ] );
};