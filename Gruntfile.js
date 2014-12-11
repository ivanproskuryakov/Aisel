'use strict';
module.exports = function (grunt) {

    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

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
        }
    });
};
