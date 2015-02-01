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
                    baseUrl: "web/app",
                    mainConfigFile: "web/app/main.js",
                    name: 'main',
                    out: "web/build/main.js",
                    optimize: 'uglify2'
                }
            }
        },
        jsdoc : {
            dist : {
                src: [
                    'web/app/*.js',
                    'web/app/**/*.js',
                    'web/app/**/**/*.js',
                    'web/app/**/**/**/*.js',
                ],
                options: {
                    destination: '../documentation/frontend/'
                }
            }
        }
    });
};
