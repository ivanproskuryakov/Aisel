'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Require.js launcher
 */

require.config({
    // Load paths from global variable
    paths: Aisel.requirejs.paths,
    // Kick start application
    deps: _.union(
        ['bootstrap'],
        Aisel.requirejs.bundles
    ),
    // Add angular modules that does not support AMD out of the box, put it in a shim
    shim: Aisel.requirejs.shim,
    priority: [
        "angular"
    ]
});