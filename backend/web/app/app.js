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
        'fancytree',
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
    ],
    function (angular) {
        'use strict';

        var app = angular.module('app', [
            'ngCookies', 'ngResource', 'ngSanitize', 'ngRoute', 'ui.bootstrap', 'ui.router',
            'ui.utils', 'ui.validate', 'ui.gravatar', 'textAngular', 'ngDisqus', 'cgNotify',
            'ngAnimate', 'angular-loading-bar', 'ngTouch', 'ui.grid',
            'environment'
        ])

        app
            .run(function ($http, $rootScope, initService) {
                initService.launch();
            })
            .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false
                cfpLoadingBarProvider.includeBar = true;
            }])
            .config(['$provide', '$locationProvider', '$httpProvider', function ($provide, $locationProvider, $httpProvider) {
                $httpProvider.defaults.withCredentials = true;
                $locationProvider.html5Mode(true);
                document.getElementById("page-is-loading").style.visibility = "hidden";
            }])
        return app;
    })
;