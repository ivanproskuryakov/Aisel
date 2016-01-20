'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            Aisel
 * @description     App Kernel
 */

define([
        'angular',
        'jQuery',
        'jQuery-ui',
        'ui-contextmenu',
        'underscore',
        'angular-resource',
        'angular-cookies',
        'angular-sanitize',
        'textAngular',
        'ui-bootstrap-tpls',
        'ui-utils',
        'angular-gravatar',
        'md5',
        'angular-disqus',
        'angular-notify',
        'twitter-bootstrap',
        'angular-ui-router',
        'angular-route',
        'angular-animate',
        'angular-loading-bar',
        'angular-touch',
        'ui-grid',
        'flow'
    ],
    function (angular) {
        'use strict';

        var app = angular.module('app', [
            'ngCookies', 'ngResource', 'ngSanitize', 'ngRoute', 'ui.bootstrap', 'ui.router',
            'ui.utils', 'ui.validate', 'ui.gravatar', 'textAngular', 'ngDisqus', 'cgNotify',
            'ngAnimate', 'angular-loading-bar', 'ngTouch', 'ui.grid', 'flow'
        ]);

        app
            .run(function ($http, $rootScope, initService, Env) {
                initService.launch();
            })
            .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false;
                cfpLoadingBarProvider.includeBar = true;
            }])
            .config(['$provide', '$locationProvider', '$httpProvider', function ($provide, $locationProvider, $httpProvider) {
                $httpProvider.defaults.withCredentials = true;
                $locationProvider.html5Mode(true);
                document.getElementById("page-is-loading").style.visibility = "hidden";
            }])
            .config(['flowFactoryProvider', function (flowFactoryProvider) {
                flowFactoryProvider.defaults = {
                    withCredentials: true,
                    testMethod: 'GET',
                    uploadMethod: 'POST'
                };
                // You can also set default events:
                //flowFactoryProvider.on('catchAll', function (event) {
                //    ...
                //});
                // Can be used with different implementations of Flow.js
                // flowFactoryProvider.factory = fustyFlowFactory;
            }]);

        return app;
    }
);
