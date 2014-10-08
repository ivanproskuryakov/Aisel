'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application core module
 */

require.config({
    paths: {
//        angular: '../bower_components/angular/angular',
//        angularRoute: '../bower_components/angular-route/angular-route',
//        angularMocks: '../bower_components/angular-mocks/angular-mocks',
//        text: '../bower_components/requirejs-text/text',
        'jquery: ': '/bower_components/jquery/jquery',
        'angular': '../bower_components/angular/angular',
        'angularAMD': '../bower_components/angularAMD/angularAMD.min',
        'bootstrap': '../bower_components/sass-bootstrap/dist/js/bootstrap',
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
        'angular-disqus': '../bower_components/angular-disqus/src/angular-disqus'
    },
    deps: ['app'],
    shim: {
        'angularAMD': ['angular'],
        'angular-route': ['angular'],
        "angular": {
            exports: "angular"
        },
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
        "bootstrap": ["angular"]
    },
    priority: [
        "angular"
    ]
});

//http://code.angularjs.org/1.2.1/docs/guide/bootstrap#overview_deferred-bootstrap
//window.name = "NG_DEFER_BOOTSTRAP!";

require([
    'app'
//    'appEnvironment',
//    'appRouter'
], function (app) {

//    var $html = angular.element(document.getElementsByTagName('html')[0]);
//
//    angular.element().ready(function() {
//        angular.resumeBootstrap([app['name']]);
//    });

});