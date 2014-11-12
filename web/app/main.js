'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Require.js launcher
 */

require.config({
    // Load paths from global variable
    paths: {
        'jquery': '../bower_components/jquery/jquery.min.js',
        'domReady': '../bower_components/domReady/domReady',
        'angular': '../bower_components/angular/angular',
        'twitter-bootstrap': '../bower_components/sass-bootstrap/dist/js/bootstrap',
        'angular-resource': '../bower_components/angular-resource/angular-resource',
        'textAngular-sanitize': '../bower_components/textAngular/dist/textAngular-sanitize.min',
        'textAngular': '../bower_components/textAngular/dist/textAngular.min',
        'angular-cookies': '../bower_components/angular-cookies/angular-cookies.min',
        'angular-sanitize': '../bower_components/angular-sanitize/angular-sanitize',
        'angular-route': '../bower_components/angular-route/angular-route',
        'ui-bootstrap-tpls': '../bower_components/angular-bootstrap/ui-bootstrap-tpls',
        'ui-utils': '../bower_components/angular-ui-utils/ui-utils',
        'angular-notify': '../bower_components/angular-notify/dist/angular-notify.min',
        'md5': '../bower_components/angular-gravatar/build/md5',
        'angular-gravatar': '../bower_components/angular-gravatar/build/angular-gravatar',
        'angular-disqus': '../bower_components/angular-disqus/src/angular-disqus',
    },
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
    // Kick start application
    deps: [
        './Kernel/environment',
        'bootstrap',
        './Kernel/router',
        './Kernel/services/root',
        './Kernel/services/init',
        './Kernel/services/auth',
        './Aisel/Homepage/AiselHomepage',
        './Aisel/Contact/AiselContact',
        './Aisel/Search/AiselSearch',
        './Aisel/Page/AiselPage',
        './Aisel/Product/AiselProduct',
        './Aisel/User/AiselUser'],
    priority: [
        "angular"
    ]
});