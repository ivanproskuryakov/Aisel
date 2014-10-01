'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * Core module of the application.
 */

var aiselApp = angular.module('aiselApp', [
        'ngCookies',
        'ngResource',
        'ngSanitize',
        'ngRoute',
        'ui.bootstrap',
        'ui.utils',
        'ui.validate',
        'ui.gravatar',
        'textAngular',
        'ngDisqus',
        'cgNotify'
    ])

    .constant('API_URL', '/api')

    .run(['$http', '$rootScope', 'rootService', function ($http, $rootScope, rootService, $route) {
        rootService.init();
//        $rootScope.$on("$locstionChangeStart", function(event, next, current) {
//        });
    }])

    .config(function ($provide, $routeProvider, $locationProvider, $httpProvider, $disqusProvider) {
//        $locationProvider
//            .html5Mode(true)
//            .hashPrefix('!');

        // Intercept http calls
        $provide.factory('requestInterceptor', function ($q) {
            return {
                request: function (config) {
                    $('.loading-interceptor').show();
                    return config || $q.when(config);
                },
                requestError: function (rejection) {
                    $('.loading-interceptor').hide();
                    return $q.reject(rejection);
                },
                response: function (response) {
                    $('.loading-interceptor').hide();
                    return response || $q.when(response);
                },
                responseError: function (rejection) {
                    $('.loading-interceptor').hide();
                    return $q.reject(rejection);
                }
            };
        });
        $httpProvider.interceptors.push('requestInterceptor');


    });
