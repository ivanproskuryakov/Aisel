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
        'underscore',
        'angular-resource',
        'angular-cookies',
        'angular-sanitize',
        'textAngular',
        'ui-bootstrap-tpls',
        'ui-validate',
        'angular-gravatar',
        'md5',
        'angular-disqus',
        'angular-notify',
        'angular-ui-router',
        'angular-animate',
        'angular-loading-bar',
        'twitter-bootstrap'
    ],
    function (angular) {
        'use strict';

        var app = angular.module('app', [
            'ngCookies',
            'ngResource',
            'ngSanitize',
            'ui.bootstrap',
            'ui.router',
            'ui.validate',
            'ui.gravatar',
            'textAngular',
            'ngDisqus',
            'cgNotify',
            'ngAnimate',
            'angular-loading-bar'
        ]);

        app.run(['$http',
                '$rootScope',
                'settingsService',
                'Env',
                function ($http, $rootScope, settingsService, Env) {

                    $rootScope.env = Env;

                    $rootScope.locale = $rootScope.env.currentLocale();
                    $rootScope.disqusShortname = $rootScope.env.shortname;
                    $rootScope.disqusStatus = false;
                    $rootScope.currency = $rootScope.env.general.currency;
                    $rootScope.paymentMethods = $rootScope.env.general.paymentMethods;

                    console.log('----------- Aisel Loaded! -----------');

                    $rootScope.$on('$stateChangeStart',
                        function (event, toState, toParams, fromState, fromParams) {
                            $rootScope.pageTitle = $rootScope.env.meta.defaultMetaTitle;
                            $rootScope.metaDescription = $rootScope.env.meta.defaultMetaDescription;
                            $rootScope.metaKeywords = $rootScope.env.meta.defaultMetaKeywords;
                        }
                    );

                    settingsService.getMenu().success(
                        function (data, status) {
                            $rootScope.topMenu = data;
                        }
                    );
                }
            ])
            .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false;
                cfpLoadingBarProvider.includeBar = true;
            }])
            .config(function ($provide, $locationProvider, $httpProvider) {
                $httpProvider.defaults.withCredentials = true;
                $locationProvider.html5Mode(true);
                document.getElementById("page-is-loading").style.visibility = "hidden";
            });

        return app;
    });
