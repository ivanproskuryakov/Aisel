'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application core module
 */

require.config({
    // load paths from global variable
    paths: Aisel.paths,
    // kick start application
    deps: [
        './bootstrap',
    ],
    // Add angular modules that does not support AMD out of the box, put it in a shim
    shim: {
        'angular-route': ['angular'],
        "angular": {
            exports: "angular"
        },
        "domReady": ["angular"],
        "angular-resource": ["angular"],
        "textAngular": ["angular"],
        "angular-cookies": ["angular"],
        "ui-bootstrap-tpls": ["angular"],
        "md5": ["angular"],
        "angular-disqus": ["angular"],
        "angular-notify": ["angular"],
        "ui-utils": ["angular"],
        "angular-gravatar": ["angular"],
        "angular-sanitize": ["angular"],
        "twitter-bootstrap": ["angular"]
    },
    priority: [
        "angular"
    ]
});