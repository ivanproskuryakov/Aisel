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
        'angular', 'jQuery', 'underscore', 'angular-resource',
        'angular-cookies', 'angular-sanitize', 'textAngular',
        'ui-bootstrap-tpls', 'ui-utils', 'angular-gravatar',
        'md5', 'angular-disqus', 'angular-notify', 'twitter-bootstrap',
        'angular-ui-router', 'angular-route', 'angular-animate',
        'angular-loading-bar'],
    function (angular) {
        'use strict';

        var app = angular.module('app', [
            'ngCookies', 'ngResource', 'ngSanitize', 'ngRoute', 'ui.bootstrap', 'ui.router',
            'ui.utils', 'ui.validate', 'ui.gravatar', 'textAngular', 'ngDisqus', 'cgNotify',
            'ngAnimate', 'angular-loading-bar',
            'environment'
        ])

        app.run(['$http', '$rootScope', 'settingsService', 'initService',
            function ($http, $rootScope, settingsService, initService) {
                initService.launch();
            }])
            .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false
                cfpLoadingBarProvider.includeBar = true;
            }])
            .config(function ($provide, $locationProvider, $httpProvider) {
                $locationProvider.html5Mode(true);
                document.getElementById("page-is-loading").style.visibility = "hidden";
            });

        return app;
    })
;