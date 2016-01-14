'use strict';
module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    grunt.loadNpmTasks('grunt-jsdoc');
    grunt.loadNpmTasks("grunt-jsbeautifier");

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
        "jsbeautifier": {
            files: [
                "frontend/web/app/*.js",
                "frontend/web/app/**/*.js",
                "frontend/web/app/**/**/*.js",
                "frontend/web/app/**/**/**/*.js",
                "frontend/web/app/**/**/**/**/*.js",
                "frontend/protractor/*.js",
                "frontend/protractor/**/*.js",

                "backend/web/app/*.js",
                "backend/web/app/**/*.js",
                "backend/web/app/**/**/*.js",
                "backend/web/app/**/**/**/*.js",
                "backend/web/app/**/**/**/**/*.js",
                "backend/protractor/*.js",
                "backend/protractor/**/*.js",
            ],
            options: {
                js: {
                    braceStyle: "collapse",
                    breakChainedMethods: false,
                    e4x: false,
                    evalCode: false,
                    indentChar: " ",
                    indentLevel: 0,
                    indentSize: 4,
                    indentWithTabs: false,
                    jslintHappy: false,
                    keepArrayIndentation: false,
                    keepFunctionIndentation: false,
                    maxPreserveNewlines: 10,
                    preserveNewlines: true,
                    spaceBeforeConditional: true,
                    spaceInParen: false,
                    unescapeStrings: false,
                    wrapLineLength: 0,
                    endWithNewline: true
                }
            }
        }
    });
};
