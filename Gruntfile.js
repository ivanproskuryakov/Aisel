'use strict';
module.exports = function (grunt) {

    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

    // Define the configuration for all the tasks
    grunt.initConfig({

        // Karma Settings
        karma: {
            unit: {
                configFile: 'karma/unit/karma.conf.js'
            },
            midway: {
                configFile: 'karma/midway/karma.midway.conf.js'
            },
            e2e: {
                configFile: 'karma/e2e/karma.e2e.conf.js'
            }
        },
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
