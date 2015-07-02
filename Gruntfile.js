'use strict';
module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    grunt.loadNpmTasks('grunt-jsdoc');
    grunt.loadNpmTasks('grunt-fixmyjs');

    // Define the configuration for all the tasks
    grunt.initConfig({

        jshint: {
            files: [
                'frontend/web/app/**/*.js',
                'frontend/web/app/**/**/*.js',
                'frontend/web/app/**/**/**/*.js',
                'frontend/web/app/**/**/**/**/*.js',
            ],
            options: {
                curly: true,
                eqeqeq: true,
                eqnull: true,
                browser: true,
                globals: {
                    jQuery: true
                }
            }
        },
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
        },
        fixmyjs: {
            options: {
                config: '.jshintrc',
                indentpref: 'spaces'
            },
            your_target: {
                files: [
                    {
                        expand: true,
                        cwd: 'frontend/web/app/',
                        src: ['**/*.js'],
                        dest: 'frontend/web/app/',
                        ext: '.js'
                    }
                ]
            }
        }
    });
};
