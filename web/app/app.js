'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Application core module
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
    .constant("LOCALE", {
        "primary": location.hash.substr(2, 2),
        "available": ['en', 'ru']
    })

    .run(['$http', '$rootScope', 'rootService', '$route', '$routeParams',
        function ($http, $rootScope, rootService, $route, $routeParams, $location) {
            rootService.init()
        }])

    .config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
//        $locationProvider
//            .html5Mode(true)
//            .hashPrefix('!');

        /**
         * HTTP calls Interception
         */
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
