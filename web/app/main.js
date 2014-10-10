'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Require.js launcher
 */

require.config({
    // load paths from global variable
    paths: Aisel.paths,
    // kick start application
    deps: _.union(
        ['bootstrap'],
        Aisel.bundles
    ),
    // Add angular modules that does not support AMD out of the box, put it in a shim
    shim: {
        'angular-route': ['angular'],
        "angular": {
            exports: "angular"
        },
        "jquery": ["angular"],
        "domReady": ["angular"],
        "angular-resource": ["angular"],
        "textAngular": ["angular"],
        "angular-cookies": ["angular"],
        "ui-bootstrap-tpls": ["angular"],
        "angular-disqus": ["angular"],
        "angular-notify": ["angular"],
        "angular-gravatar": ["angular"],
        "angular-sanitize": ["angular"],
        "twitter-bootstrap": ["angular"],
        "ui-utils": ["angular"],
        "md5": ["angular"]
    },
    priority: [
        "angular"
    ]
});