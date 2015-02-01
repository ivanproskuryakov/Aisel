'use strict';
module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    grunt.loadNpmTasks('grunt-jsdoc');

    // Define the configuration for all the tasks
    grunt.initConfig({

        requirejs: {
            js: {
                options: {
                    uglify2: {
                        mangle: false
                    },
                    baseUrl: "frontend/web/app",
                    mainConfigFile: "frontend/web/app/main.js",
                    name: 'main',
                    out: "frontend/web/build/main.js",
                    optimize: 'uglify2'
                }
            }
        }
    });
};
